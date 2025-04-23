import cv2
import pytesseract
import numpy as np
import sys
import json
import os

pytesseract.pytesseract.tesseract_cmd = r'C:\Program Files\Tesseract-OCR\tesseract.exe'

def scan_battle_data(image_path):
    image = cv2.imread(image_path)
    if image is None:
        return json.dumps({"error": "Failed to read image."})

    height, width = image.shape[:2]
    gray = cv2.cvtColor(image, cv2.COLOR_BGR2GRAY)

    # Coordinates for result status and battle ID
    result_coords = (0.418, 0.588, 0.028, 0.092)
    battle_id_coords = (0.149, 0.279, 0.881, 0.916)

    # Process result status region
    x1, x2, y1, y2 = result_coords
    x1 = int(width * x1)
    x2 = int(width * x2)
    y1 = int(height * y1)
    y2 = int(height * y2)
    result_region = gray[y1:y2, x1:x2]
    result_processed = cv2.threshold(result_region, 150, 255, cv2.THRESH_BINARY_INV)[1]
    result_processed = cv2.morphologyEx(result_processed, cv2.MORPH_OPEN, np.ones((3, 3), np.uint8))
    result_processed = cv2.resize(result_processed, None, fx=3, fy=3, interpolation=cv2.INTER_CUBIC)
    result_config = '--psm 8 --oem 3 -c tessedit_char_whitelist=abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'
    result_text = pytesseract.image_to_string(result_processed, config=result_config).strip().lower()

    if 'victory' in result_text:
        result_status = 'Victory'
    elif 'defeat' in result_text:
        result_status = 'Defeat'
    else:
        result_status = 'Not found'

    # Process battle ID region
    x1, x2, y1, y2 = battle_id_coords
    x1 = int(width * x1)
    x2 = int(width * x2)
    y1 = int(height * y1)
    y2 = int(height * y2)
    battle_region = gray[y1:y2, x1:x2]
    battle_processed = cv2.threshold(battle_region, 0, 255, cv2.THRESH_BINARY | cv2.THRESH_OTSU)[1]
    battle_processed = cv2.resize(battle_processed, None, fx=2, fy=2, interpolation=cv2.INTER_CUBIC)
    battle_config = '--psm 7 --oem 3 -c tessedit_char_whitelist=0123456789'
    battle_id = pytesseract.image_to_string(battle_processed, config=battle_config).strip()

    return json.dumps({"resultStatus": result_status, "battleID": battle_id or "Not found"})

if __name__ == "__main__":
    if len(sys.argv) < 2:
        print(json.dumps({"error": "No image path provided."}))
        sys.exit(1)

    image_path = sys.argv[1]
    print(scan_battle_data(image_path))
