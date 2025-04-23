import cv2

# Load the image
image_path = "C:/xampp/htdocs/abyss/Python/ML-OCR/ally2_ocr.png"
image = cv2.imread(image_path)

# Callback function to get mouse coordinates
def mouse_callback(event, x, y, flags, param):
    if event == cv2.EVENT_MOUSEMOVE:
        print(f"Coordinates: X={x}, Y={y}")

# Create a window and set the mouse callback function
# Alternative: Use a fixed window size
cv2.namedWindow("Image", cv2.WINDOW_NORMAL)
cv2.resizeWindow("Image", 950, 600)  # Manually set window size
cv2.imshow("Image", image)
cv2.namedWindow("Image")
cv2.setMouseCallback("Image", mouse_callback)

# Display the image
cv2.imshow("Image", image)
cv2.waitKey(0)
cv2.destroyAllWindows()

            # coordinates ng battleResults
            # 'battleID': gray[1130:1175, 410:780],
            # 'allyScore': gray[50:125, 900:1025],
            # 'enemyScore': gray[50:125, 1780:1900]

            # coordinates ng profile
            # 'id': gray_image[231:281, 750:900],
            # 'lowest': gray_image[653:703, 560:620],
            # 'highest': gray_image[653:703, 960:1010]
        