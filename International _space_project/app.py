from flask import Flask, render_template, request
from markupsafe import Markup
import matplotlib
matplotlib.use('Agg')  # Use non-GUI backend
import matplotlib.pyplot as plt
import io, os, base64
import requests

# Global variables
app = Flask(__name__)

# Get path directory
BASE_DIR = os.path.dirname(os.path.abspath(__file__))

# Get ISS location
def get_space_station_location():
    try:
        r = requests.get(url='http://api.open-notify.org/iss-now.json')
        space_station_location = r.json()

        space_station_longitude = float(space_station_location['iss_position']['longitude'])
        space_station_latitude = float(space_station_location['iss_position']['latitude'])
        return space_station_latitude, space_station_longitude  # <- FIXED ORDER
    except:
        print('Request not working')
        return None, None

def get_nearest_city(latitude, longitude):
    try:
        opencage_key = "0253eb206a1d49e9892043728661ed86"
        oc_url = f"https://api.opencagedata.com/geocode/v1/json?q={latitude}+{longitude}&key={opencage_key}"
        headers = {'User-Agent': 'Mozilla/5.0'}
        response = requests.get(oc_url, headers=headers)
        data = response.json()

        if data.get('results'):
            result = data['results'][0]
            components = result.get('components', {})
            formatted = result.get('formatted', 'Remote Area')

            print("OpenCage components:", components)

            # Primary components
            city = components.get("city") or components.get("town") or components.get("village")
            state = components.get("state")
            country = components.get("country")

            # Secondary components (shown only if no city/country)
            hamlet = components.get("hamlet")
            suburb = components.get("suburb")
            body_of_water = components.get("body_of_water")
            ocean = components.get("ocean")

            if country:
                # Build full location if country is present
                parts = [city, state, country]
                location_str = ", ".join([p for p in parts if p])
                return location_str, "city/state/country"

            # Fallback: show first available detail
            for component, label in [
                (hamlet, "hamlet"),
                (suburb, "suburb"),
                (body_of_water, "water"),
                (ocean, "ocean")
            ]:
                if component:
                    return component, label

            return formatted, "formatted"

        return "Remote Area", "no results"

    except Exception as e:
        print("Geocoding error:", e)
        return "Remote Area", "error"






# Geo to pixel conversion
def translate_geo_to_pixels(longitude, latitude, max_x_px, max_y_px):
    scale_x = ((longitude + 180) / 360) * max_x_px
    scale_y = ((latitude - 90) / -180) * max_y_px
    return scale_x, scale_y

@app.route("/", methods=['POST', 'GET'])
def ISS_Tracker():
    fig, ax = plt.subplots(figsize=(20, 10))

    # Load world map image
    img_path = os.path.join(BASE_DIR, 'static/images/world_map.jpg')
    img = plt.imread(img_path)

    ax.imshow(img, extent=[-180, 180, -90, 90])

    # Add labels for reference points
    ax.text(0, 90, "Latitude", color="red", fontsize=14, fontweight="bold")
    ax.text(180, 0, "Longitude", color="blue", fontsize=14, fontweight="bold")

    if request.method == "POST":
        iss_location = get_space_station_location()
        if iss_location[0] is not None and iss_location[1] is not None:
            latitude, longitude = iss_location  # <- FIXED ORDER

            # Get nearest city or feature
            location_name, label_type = get_nearest_city(latitude, longitude)

            # Plot ISS
            ax.scatter(x=[longitude], y=[latitude], c='blue', s=500, marker="P")

            # Add info near marker
            ax.text(
                longitude + 5,
                latitude + 5,
                f"ISS: {location_name} ({label_type})\n({latitude:.2f}°, {longitude:.2f}°)",
                color="yellow",
                fontsize=12,
                fontweight="bold",
                bbox=dict(facecolor="black", alpha=0.5)
            )

    plt.axis('off')
    img_data = io.BytesIO()
    plt.savefig(img_data, format='jpg')
    img_data.seek(0)
    plot_url = base64.b64encode(img_data.getvalue()).decode()

    return render_template('index.html',
        forecast_plot=Markup(f'<img src="data:image/jpg;base64, {plot_url}" style="width:100%;vertical-align:top">')
    )

if __name__ == '__main__':
    app.run(debug=True)
