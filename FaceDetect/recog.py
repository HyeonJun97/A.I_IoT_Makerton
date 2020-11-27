import cv2
import os
import numpy as np
import glob
from tensorflow.keras.models import load_model
import datetime as dt
from PIL import Image
import requests

#cam = cv2.VideoCapture("http://192.168.0.120:8081")
cam = cv2.VideoCapture(0)

cam.set(3, 640)
cam.set(4, 480)
face_detector = cv2.CascadeClassifier('haarcascade_frontalface_default.xml')

count = 0

while True:
    ret, img = cam.read()
    gray = cv2.cvtColor(img, cv2.COLOR_BGR2GRAY)
    faces = face_detector.detectMultiScale(gray, 1.3, 5)
    td = dt.datetime.now()
    
    for (x,y,w,h) in faces:
        cv2.rectangle(img, (x,y), (x+w,y+h), (255,0,0), 2)
        picname = "./toserver/" +"guest"+str(count)+".jpg"
        cv2.imwrite(picname, gray[y:y+h,x:x+w])
        count += 1
    
    cv2.imshow('image', img)
    
    if count == 30:
        break
    
    k = cv2.waitKey(100) & 0xff
    
    if k == 27:
        break
    

cam.release()
cv2.destroyAllWindows()

caltech_dir = "./toserver"
image_w = 64
image_h = 64

pixels = image_h * image_w * 3

X = []
filenames = []
files = glob.glob(caltech_dir+"/*.*")
for i, f in enumerate(files):
    img = Image.open(f)
    img = img.convert("RGB")
    img = img.resize((image_w, image_h))
    data = np.asarray(img)
    filenames.append(f)
    X.append(data)

X = np.array(X)
model = load_model('./facedetect.model')

prediction = model.predict(X)
np.set_printoptions(formatter={'float': lambda x: "{0:0.3f}".format(x)})

chk = [0,0,0,0,0]


for i in prediction:
    pre_ans = i.argmax()  # Face Detect 
    
    if i[0] >= 0.8: chk[0] +=1
    if i[1] >= 0.8: chk[1] +=1
    if i[2] >= 0.8: chk[2] +=1
    if i[3] >= 0.8: chk[3] +=1
    if i[4] >= 0.8: chk[4] +=1
    
chkmax = max(chk)
    
if chkmax == chk[0]:
    name = "Hyeonjun"
    print("Image: Hyeonjun")
if chkmax == chk[1]:
    name = "Jaegeun"
    print("Image: Jaegeun")
if chkmax == chk[2]:
    name = "Jongha"
    print("Image: Jongha")
if chkmax == chk[3]:
    name = "Jongwon"
    print("Image: Jongwon")
if chkmax == chk[4]:
    name = "Sunhoo"
    print("Image: Sunhoo")
    

username = name # Application Connecting

try :
    url = 'http://118.67.129.164/maker/upload.php'
    files = {'files':open('./toserver/guest1.jpg','rb')}
    datas  = {'username':usernname}
    l = requests.post(url,files=files,data=datas)
    print(l.text)
    
except:
    print("")
    

