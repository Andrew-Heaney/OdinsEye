import cv2 
import numpy as np
from datetime import date
import datetime
import time
import sys


trig_level = 10
firstFrame = None
filename = date.today().strftime("vids/%d-%m-%Y")+".mp4"
print(date.today().strftime("%d-%m-%Y"))

video = cv2.VideoCapture(0) 
   
if (video.isOpened() == False):  
    #print("Error reading video file") 
    sys.exit("Error reading video device")
 
frame_width = int(video.get(3)) 
frame_height = int(video.get(4)) 
size = (frame_width, frame_height)   
aspect_ratio = frame_width/frame_height

# Dimensions for resized motion detect frames
md_frame_width = 512
md_frame_height = int(md_frame_width/aspect_ratio)
md_size = (md_frame_width, md_frame_height)
num_md_pixels = md_frame_width*md_frame_height
   

result = cv2.VideoWriter(filename, cv2.VideoWriter_fourcc(*'a','v','c','1'), 24, size) 

ref_frame = None    #Motion detect reference frame
startTime = time.time()

while(int(time.time() - startTime) < 60): 
    ret, frame = video.read() 
    ######if firstFrame is None:
    # Normalise frames by resizing, converting to monochrome
    # and smoothing to reduce noise and compression artifacts
    if ref_frame is None:         
        ref_frame = cv2.resize(frame, md_size)
        ref_frame = cv2.cvtColor(ref_frame, cv2.COLOR_BGR2GRAY)
        ref_frame = cv2.GaussianBlur(ref_frame, (21,21), 0)
        ref_level = np.sum(ref_frame) / num_md_pixels
    else:
        md_frame = cv2.resize(frame, md_size)    
        md_frame = cv2.cvtColor(md_frame, cv2.COLOR_BGR2GRAY)
        md_frame = cv2.GaussianBlur(md_frame, (21,21), 0)
        md_level = np.sum(md_frame) / num_md_pixels
        #Implement brightness compensation  
        alpha = ref_level/md_level
        md_frame = cv2.convertScaleAbs(md_frame, alpha, beta = 0)
        
        #Get difference between reference and current frames 
        frameDelta = cv2.absdiff(ref_frame, md_frame)
    
        #Count number of pixels above a defined trigger level
        #num_dif_pix = np.sum(frameDelta>trig_level)
        
        #Alternatively get sum of pixels above trigger level
        dif_level = np.sum(frameDelta[frameDelta>trig_level])
        average_dif_level = dif_level/num_md_pixels

        print(average_dif_level)
    
	  
        if average_dif_level >= 50: 
            frame = cv2.putText(frame,str(datetime.datetime.now()),(10, 450),cv2.FONT_HERSHEY_SIMPLEX,1,(0,0,0),1,cv2.LINE_8) 
            result.write(frame) 
            cv2.imshow('Frame', frame)

            # Press S on keyboard  
            # to stop the process 
            if cv2.waitKey(1) & 0xFF == ord('s'): 
                break

  
video.release() 
result.release() 
    
# Closes all the frames 
cv2.destroyAllWindows() 
   
print("The video was successfully saved") 

