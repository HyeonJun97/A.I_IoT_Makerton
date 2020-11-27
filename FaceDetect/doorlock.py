import RPi.GPIO as GPIO
import time
import requests

GPIO.setmode(GPIO.BCM)
GPIO.setup(23, GPIO.OUT)
GPIO.setup(24, GPIO.OUT)

lock = 0 #Close

While True:
    GPIO.output(23, True) #RED LED ON
    GPIO.output(24, False)
    
    if lock = 1:
        GPIO.output(23, False)
        GPIO.output(24, True) #GREED LED ON
        time.sleep(5)
        
    