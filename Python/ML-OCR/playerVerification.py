import cv2
import os
import sys
import json
from PIL import Image
import pytesseract
import numpy as np

# For Tesseract PATH
# pytesseract.pytesseract.tesseract_cmd = r'C:\Program Files\Tesseract-OCR\tesseract.exe' 

def process_image(image_path):
    try:
        # Read image
        image = cv2.imread(image_path)
        if image is None:
            return {"error": f"Could not read image at {image_path}"}

        # Get image dimensions
        height, width = image.shape[:2]

        # Convert to grayscale
        gray_image = cv2.cvtColor(image, cv2.COLOR_BGR2GRAY)

        # Define regions of interest using proportional coordinates
        regions_config = {
            'accountID': {
                'coords': (0.267, 0.323, 0.178, 0.206),  # x1, x2, y1, y2
                'preprocess': 'thresh',
                'config': '--psm 6'
            },
            'currentStars': {
                'coords': (0.200, 0.219, 0.517, 0.542),
                'preprocess': 'thresh',
                'config': '--psm 6 -c tessedit_char_whitelist=0123456789'
            },
            'highestStars': {
                'coords': (0.346, 0.364, 0.519, 0.540),
                'preprocess': 'thresh',
                'config': '--psm 6 -c tessedit_char_whitelist=0123456789'
            }
        }

        # Process each region with OCR
        result = {}
        for key, config in regions_config.items():
            # Calculate absolute coordinates
            x1, x2, y1, y2 = config['coords']
            abs_x1 = int(width * x1)
            abs_x2 = int(width * x2)
            abs_y1 = int(height * y1)
            abs_y2 = int(height * y2)
            
            # Extract region
            region = gray_image[abs_y1:abs_y2, abs_x1:abs_x2]
            
            # Preprocessing
            if config['preprocess'] == 'thresh':
                region = cv2.threshold(region, 0, 255, cv2.THRESH_BINARY | cv2.THRESH_OTSU)[1]
            
            # OCR processing
            text = pytesseract.image_to_string(
                Image.fromarray(region),
                config=config['config']
            ).strip()
            
            result[key] = text if text else "Not found"

        return json.dumps(result)

    except Exception as e:
        return {"error": str(e)}

if __name__ == "__main__":
    # Get image path from command line
    if len(sys.argv) < 2:
        print(json.dumps({"error": "No image path provided"}))
        sys.exit(1)
        
    image_path = sys.argv[1]
    result = process_image(image_path)
    print(result)