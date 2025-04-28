import cv2
import numpy as np

def select_roi(image_path):
    # Load image
    img = cv2.imread(image_path)
    if img is None:
        print(f"Error: Could not load image at {image_path}")
        return
    
    # Get image dimensions
    height, width = img.shape[:2]
    
    # Calculate resize ratio to fit screen
    screen_height = 1080  # Adjust based on your screen resolution
    resize_ratio = min(0.8 * screen_height / height, 1.0)
    
    # Create window and set mouse callback
    window_name = "Image (Press Q to quit)"
    cv2.namedWindow(window_name, cv2.WINDOW_NORMAL)
    cv2.resizeWindow(window_name, int(width * resize_ratio), int(height * resize_ratio))
    
    roi = {'x1': 0, 'y1': 0, 'x2': 0, 'y2': 0, 'dragging': False}
    
    def mouse_callback(event, x, y, flags, param):
        nonlocal img, roi, resize_ratio
        
        # Adjust coordinates back to original image scale
        orig_x, orig_y = int(x / resize_ratio), int(y / resize_ratio)
        
        if event == cv2.EVENT_LBUTTONDOWN:
            roi['x1'], roi['y1'] = orig_x, orig_y
            roi['x2'], roi['y2'] = orig_x, orig_y
            roi['dragging'] = True
            
        elif event == cv2.EVENT_MOUSEMOVE and roi['dragging']:
            roi['x2'], roi['y2'] = orig_x, orig_y
            
        elif event == cv2.EVENT_LBUTTONUP:
            roi['x2'], roi['y2'] = orig_x, orig_y
            roi['dragging'] = False
            
            # Calculate and print coordinates
            x1, y1 = min(roi['x1'], roi['x2']), min(roi['y1'], roi['y2'])
            x2, y2 = max(roi['x1'], roi['x2']), max(roi['y1'], roi['y2'])
            
            # Absolute coordinates
            print(f"\nAbsolute coordinates: [y1:y2, x1:x2] = [{y1}:{y2}, {x1}:{x2}]")
            
            # Proportional coordinates
            x1_pct, x2_pct = x1/width, x2/width
            y1_pct, y2_pct = y1/height, y2/height
            print(f"Proportional coordinates: ({x1_pct:.3f}, {x2_pct:.3f}, {y1_pct:.3f}, {y2_pct:.3f})")
            
            # Show cropped region
            crop = img[y1:y2, x1:x2]
            cv2.imshow("Cropped Region", crop)
    
    cv2.setMouseCallback(window_name, mouse_callback)
    
    while True:
        img_copy = img.copy()
        
        # Draw rectangle if dragging (on original image)
        if roi['dragging']:
            cv2.rectangle(img_copy, (roi['x1'], roi['y1']), 
                         (roi['x2'], roi['y2']), (0, 255, 0), 2)
        
        # Resize for display only
        display_img = cv2.resize(img_copy, None, fx=resize_ratio, fy=resize_ratio)
        
        # Display instructions
        cv2.putText(display_img, "Drag to select ROI. Press 'q' to quit.", 
                   (10, 30), cv2.FONT_HERSHEY_SIMPLEX, 0.7 * resize_ratio, (0, 0, 255), 2)
        
        # Display dimensions
        cv2.putText(display_img, f"Image Size: {width}x{height} (Displayed at {int(width*resize_ratio)}x{int(height*resize_ratio)})", 
                   (10, 60), cv2.FONT_HERSHEY_SIMPLEX, 0.6 * resize_ratio, (255, 255, 255), 1)
        
        cv2.imshow(window_name, display_img)
        
        key = cv2.waitKey(1) & 0xFF
        if key == ord('q'):
            break
    
    cv2.destroyAllWindows()

if __name__ == "__main__":
    # Hardcoded image path
    image_path = "/var/www/html/abyss/Python/ML-OCR/image.png"
    
    # Verify path
    import os
    if not os.path.exists(image_path):
        print(f"Error: Image not found at {image_path}")
        print("Please verify the path or drag your image into the terminal to get its full path")
    else:
        select_roi(image_path)