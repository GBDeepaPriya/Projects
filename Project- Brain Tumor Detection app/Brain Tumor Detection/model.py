import keras
import numpy as np
from PIL import Image, ImageOps
import os
import gdown

MODEL_PATH = "/tmp/model.h5"
FILE_ID = "1s9pWdQnAA09A0N7-Ot47GMPlFSsSB9L8"
url = f"https://drive.google.com/uc?id={FILE_ID}"

if not os.path.exists(MODEL_PATH):
    print("Downloading model.h5 to /tmp/")
    gdown.download(url, MODEL_PATH, quiet=False, use_cookies=False)

model = keras.models.load_model(MODEL_PATH)

def image_pre(path):
    size = (150, 150)
    image = Image.open(path)
    image = ImageOps.grayscale(image)
    image = ImageOps.fit(image, size, Image.LANCZOS)
    image_array = np.asarray(image)
    data = image_array.reshape((-1, 150, 150, 1)).astype("float32")
    return data

def predict(data):
    prediction = model.predict(data)
    return prediction[0][0]

# ✅ New safe MRI image check without OpenCV
def is_mri_image(path):
    try:
        image = Image.open(path).convert("L")
        np_img = np.array(image)

        # Heuristic: MRI scans are mostly mid-tone grayscale
        mean_val = np.mean(np_img)
        std_dev = np.std(np_img)

        return 50 < mean_val < 200 and std_dev > 10
    except:
        return False
