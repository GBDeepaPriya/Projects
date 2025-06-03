from flask import Flask, render_template, request
from tensorflow.keras.models import load_model
from tensorflow.keras.preprocessing.image import img_to_array, load_img
import numpy as np
import matplotlib.pyplot as plt
from model import image_pre,predict
import os
app = Flask(__name__)

UPLOAD_FOLDER = os.path.join(os.path.dirname(os.path.abspath(__file__)), 'static')

ALLOWED_EXTENSIONS = set(['png', 'jpg', 'jpeg']) 
app.config['UPLOAD_FOLDER'] = UPLOAD_FOLDER

@app.route('/')
def home():
    return render_template('index.html')


@app.route('/', methods=['GET', 'POST'])
def upload_file():
    if request.method == 'POST':
       if 'filel' not in request.files:
           return 'there is no filel in form!'
       file1 = request.files['filel']
       path = os.path.join(app.config['UPLOAD_FOLDER'], 'output.jpg')
       file1.save(path)
       #return path
       data = image_pre(path)
       s = predict(data) 
       if s == 1:
        result = 'No Brain Cancer'
       else:
        result = 'Brain Cancer'
       return render_template('index.html', result=result)   



if __name__ == '__main__':
    app.run(debug=True)
