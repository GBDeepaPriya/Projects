import keras
import numpy as np
from matplotlib.pyplot import imshow
from PIL import Image, ImageOps
import os
base = os.path.dirname(os.path.abspath(__file__))  # This gets the directory of the current file
model = keras.models.load_model(os.path.join(base, 'model.h5'))
                                
def image_pre(path):
    print(path)
    data = np.ndarray(shape=(1,150, 158, 1), dtype=np.float32)
    size = (150, 150)
    image = Image.open(path)
    image = ImageOps.grayscale(image)
    image = ImageOps.fit(image, size, Image.LANCZOS)
    image_array = np.asarray(image) 
    data = image_array.reshape((-1,150,150,1))
    return data

def predict(data):
    prediction = model.predict(data)
    return prediction [0][0]