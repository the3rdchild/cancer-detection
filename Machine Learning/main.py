import cv2
from ultralytics import YOLO
import os

home_directory = os.path.expanduser('~lokasidir')
model_dir = os.path.join(home_directory, "model.pt" )
model = YOLO(model_dir)

def predict(chosen_model, img, classes=[], conf=0.5):
    if classes:
        results = chosen_model.predict(img, classes=classes, conf=conf)
    else:
        results = chosen_model.predict(img, conf=conf)

    return results

def predict_and_detect(chosen_model, img, classes=[], conf=0.5, rectangle_thickness=2, text_thickness=1):
    results = predict(chosen_model, img, classes, conf=conf)
    for result in results:
        for box in result.boxes:
            cv2.rectangle(img, (int(box.xyxy[0][0]), int(box.xyxy[0][1])),
                          (int(box.xyxy[0][2]), int(box.xyxy[0][3])), (255, 0, 0), rectangle_thickness)
            cv2.putText(img, f"{result.names[int(box.cls[0])]}",
                        (int(box.xyxy[0][0]), int(box.xyxy[0][1]) - 10),
                        cv2.FONT_HERSHEY_PLAIN, 1, (255, 0, 0), text_thickness)
    return img, results
imagedir = os.path.join(home_directory, "image.png")
image = cv2.imread(imagedir)
result_img, _ = predict_and_detect(model, image, classes=[], conf=0.5)
cv2.imshow("Image", result_img)
cv2.imwrite("result.jpg", result_img)
cv2.waitKey(1) & 0xFF == ord('q')
