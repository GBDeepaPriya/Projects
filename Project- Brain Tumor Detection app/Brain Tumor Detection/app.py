from flask import Flask, render_template, request, send_from_directory
import os
from model import image_pre, predict

app = Flask(__name__)
UPLOAD_FOLDER = "/tmp"
app.config['UPLOAD_FOLDER'] = UPLOAD_FOLDER


@app.route('/uploads/<filename>')
def uploaded_file(filename):
    return send_from_directory(app.config['UPLOAD_FOLDER'], filename)


@app.route('/', methods=['GET', 'POST'])
def upload_file():
    if request.method == 'POST':
        try:
            if 'file1' not in request.files:
                return 'No file uploaded'

            file1 = request.files['file1']
            if file1.filename == '':
                return 'Empty filename'

            filename = 'output.jpg'
            path = os.path.join(app.config['UPLOAD_FOLDER'], filename)
            file1.save(path)

            data = image_pre(path)
            s = predict(data)
            result = 'No Brain Cancer' if s >= 0.5 else 'Brain Cancer'

            # Pass the image URL to the template
            image_url = f'/uploads/{filename}'

            return render_template('index.html', result=result, image_url=image_url)
        except Exception as e:
            print("Error during prediction:", e)
            return f"Internal Server Error: {e}", 500

    return render_template('index.html')


if __name__ == '__main__':
    app.run(host='0.0.0.0', port=7860, debug=False)