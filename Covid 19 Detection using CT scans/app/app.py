from flask import Flask, render_template, request, jsonify
import os
from model import image_pre, predict
import uuid

app = Flask(__name__)

UPLOAD_FOLDER = os.path.join(os.path.dirname(__file__), 'static')
os.makedirs(UPLOAD_FOLDER, exist_ok=True)
app.config['UPLOAD_FOLDER'] = UPLOAD_FOLDER

@app.route('/', methods=['GET', 'POST'])
def upload_file():
    result = None
    image_url = None
    filename = None

    if request.method == 'POST':
        file1 = request.files.get('file1')
        if file1 and file1.filename != '':
            ext = file1.filename.rsplit('.', 1)[-1].lower()
            if ext in ['jpg', 'jpeg', 'png']:
                filename = f"{uuid.uuid4().hex}.{ext}"
                save_path = os.path.join(app.config['UPLOAD_FOLDER'], filename)
                file1.save(save_path)

                data = image_pre(save_path)
                s = predict(data)
                result = 'No COVID detected' if s == 1 else 'COVID detected'

                image_url = f"/static/{filename}"
            else:
                result = "Unsupported file type. Use JPG or PNG."

    return render_template('index.html', result=result, image_url=image_url, filename=filename)


@app.route('/delete-image', methods=['POST'])
def delete_image():
    data = request.get_json()
    filename = data.get("filename")
    if filename:
        try:
            file_path = os.path.join(app.config['UPLOAD_FOLDER'], filename)
            if os.path.exists(file_path):
                os.remove(file_path)
                return jsonify({"status": "success"}), 200
        except Exception as e:
            return jsonify({"status": "error", "message": str(e)}), 500
    return jsonify({"status": "error", "message": "Filename missing"}), 400


if __name__ == '__main__':
    app.run(host='0.0.0.0', port=7860, debug=True)
