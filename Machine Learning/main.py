import os
import cv2
from ultralytics import YOLO
from flask import Flask, Response
from ..path import model_path

app = Flask(__name__)
model = YOLO(model_path)

cap = cv2.VideoCapture(0)
cap.set(cv2.CAP_PROP_FRAME_WIDTH, 1920)
cap.set(cv2.CAP_PROP_FRAME_HEIGHT, 1920)

def generate_frames():
    if not cap.isOpened():
        print("Error: Camera not initialized.")
        return

    while True:
        success, frame = cap.read()
        if not success:
            print("Error: Failed to read frame.")
            break

        results = model.track(frame, classes=0, conf=0.8, imgsz=640)
        cv2.putText(frame, 
                    f"Total: {len(results[0].boxes)}", 
                    (50, 50), cv2.FONT_HERSHEY_SIMPLEX, 
                    1, (0, 0, 255), 
                    1, cv2.LINE_AA)
        ret, buffer = cv2.imencode('.jpg', results[0].plot())
        frame = buffer.tobytes()
        yield (b'--frame\r\n'
               b'Content-Type: image/jpeg\r\n\r\n' + frame + b'\r\n')


@app.route('/preview')
def preview():
    """Video feed route."""
    return Response(generate_frames(), mimetype='multipart/x-mixed-replace; boundary=frame')

if __name__ == "__main__":
    app.run(host='0.0.0.0', port=4000, debug=False)
