import cv2
import pytesseract
import numpy as np
import sys
import json
import os

# pytesseract.pytesseract.tesseract_cmd = r'C:\\Program Files\\Tesseract-OCR\\tesseract.exe'

def preprocess_region_otsu(image):
    resized = cv2.resize(image, None, fx=3, fy=3, interpolation=cv2.INTER_CUBIC)
    _, thresh = cv2.threshold(resized, 0, 255, cv2.THRESH_BINARY + cv2.THRESH_OTSU)
    return thresh

def scan_battle_data(image_path):
    image = cv2.imread(image_path)
    if image is None:
        return json.dumps({"error": "Failed to read image."})

    height, width = image.shape[:2]
    gray = cv2.cvtColor(image, cv2.COLOR_BGR2GRAY)

    # Result status region
    x1_r, x2_r, y1_r, y2_r = 0.418, 0.588, 0.028, 0.092
    x1 = int(width * x1_r)
    x2 = int(width * x2_r)
    y1 = int(height * y1_r)
    y2 = int(height * y2_r)
    result_crop = gray[y1:y2, x1:x2]
    result_processed = preprocess_region_otsu(result_crop)
    result_text = pytesseract.image_to_string(result_processed, config='--psm 8 --oem 3').strip().lower()

    if 'victory' in result_text:
        result_status = 'Victory'
    elif 'defeat' in result_text:
        result_status = 'Defeat'
    else:
        result_status = 'Not found'

    # Battle ID region
    x1_b, x2_b, y1_b, y2_b = 0.149, 0.279, 0.881, 0.916
    x1b = int(width * x1_b)
    x2b = int(width * x2_b)
    y1b = int(height * y1_b)
    y2b = int(height * y2_b)
    battle_crop = gray[y1b:y2b, x1b:x2b]
    battle_processed = cv2.threshold(battle_crop, 0, 255, cv2.THRESH_BINARY | cv2.THRESH_OTSU)[1]
    battle_processed = cv2.resize(battle_processed, None, fx=2, fy=2, interpolation=cv2.INTER_CUBIC)
    battle_id = pytesseract.image_to_string(battle_processed, config='--psm 7 --oem 3 -c tessedit_char_whitelist=0123456789').strip()

    return json.dumps({"resultStatus": result_status, "battleID": battle_id or "Not found"})

if __name__ == "__main__":
    if len(sys.argv) < 2:
        print(json.dumps({"error": "No image path provided."}))
        sys.exit(1)

    image_path = sys.argv[1]
    print(scan_battle_data(image_path))
