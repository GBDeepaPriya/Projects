import os
import gdown
import tensorflow as tf
from tensorflow.keras.models import load_model
import numpy as np
from PIL import Image, ImageOps

MODEL_PATH = os.path.join("static", "CovidTest.h5")
url = "https://drive.google.com/uc?id=1n6SWBbuyuvZpEAEhfwoixKS0fJ81K4Dh"

if not os.path.exists(MODEL_PATH):
    os.makedirs(os.path.dirname(MODEL_PATH), exist_ok=True)
    gdown.download(url, MODEL_PATH, quiet=False)

model = load_model(MODEL_PATH)

def image_pre(image_path):
    img = Image.open(image_path).convert('L')  # grayscale
    img = ImageOps.fit(img, (128, 128))
    img = np.array(img).astype('float32') / 255.0
    img = img.reshape(1, 128, 128, 1)
    return img

def predict(img_array):
    prediction = model.predict(img_array)
    return int(round(prediction[0][0]))
