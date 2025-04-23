import cv2
from matplotlib import pyplot as plt
from PIL import Image
import pytesseract

# For Tesseract PATH
pytesseract.pytesseract.tesseract_cmd = r'C:\Program Files\Tesseract-OCR\tesseract.exe' 

# Load the image using OpenCV
image_path = "C:/Users/angel/OneDrive/Desktop/ML-OCR/image.png"
image = cv2.imread(image_path)

if image is None:
    print(f"Error: Could not open or read the image at: {image_path}")
    # Check if the file exists at all
    import os
    if not os.path.exists(image_path):
        print("The file does not exist at the specified path.")
    else:
        print("The file exists, but OpenCV cannot read it. Ensure it is a valid image format.")
else:
    # Convert the image to grayscale
    gray_image = cv2.cvtColor(image, cv2.COLOR_BGR2GRAY)

    # Crop and OCR ID Number
    cropped_id = gray_image[231:281, 750:900]
    extracted_id = pytesseract.image_to_string(Image.fromarray(cropped_id), config='--psm 6')
    print("Extracted ID:", extracted_id)

    # Crop and OCR Lowest Stars
    cropped_22 = gray_image[653:703, 560:620]
    extracted_22 = pytesseract.image_to_string(Image.fromarray(cropped_22), config='--psm 6')
    print("Extracted Lowest Stars:", extracted_22)

    # Crop and OCR Highest Stars
    cropped_63 = gray_image[653:703, 960:1010]
    extracted_63 = pytesseract.image_to_string(Image.fromarray(cropped_63), config='--psm 6')
    print("Extracted Highest Stars:", extracted_63)

    cv2.imshow("Cropped 63", cropped_63)
    cv2.waitKey(0)
    cv2.destroyAllWindows()