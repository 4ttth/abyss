<?php
// htdocs/abyss/pythonTrial.php

// Set absolute paths
$baseDir = "/var/www/html/abyss";
$pythonScript = "$baseDir/Python/ML-OCR/playerVerification.py";
$uploadDir = "$baseDir/uploads/";

// Function to handle file upload
function processUpload($file, $uploadDir) {
    // Check for errors
    if ($file['error'] !== UPLOAD_ERR_OK) {
        throw new Exception("Upload error: " . $file['error']);
    }

    // Validate image
    $validExtensions = ['jpg', 'jpeg', 'png'];
    $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    
    if (!in_array($extension, $validExtensions)) {
        throw new Exception("Invalid file type. Only JPG, JPEG and PNG are allowed.");
    }

    // Generate unique filename
    $filename = uniqid() . '.' . $extension;
    $destination = $uploadDir . $filename;

    // Create directory if it doesn't exist
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Move uploaded file
    if (!move_uploaded_file($file['tmp_name'], $destination)) {
        throw new Exception("Failed to move uploaded file");
    }

    return $destination;
}

// Function to execute Python script
function executePythonOCR($pythonScript, $imagePath) {
    if (!file_exists($pythonScript)) {
        throw new Exception("Python script not found at: $pythonScript");
    }

    if (!file_exists($imagePath)) {
        throw new Exception("Image file not found at: $imagePath");
    }

    // Use full path to python executable if needed
    $command = "python3 " . escapeshellarg($pythonScript) . " " . escapeshellarg($imagePath) . " 2>&1";
    $output = shell_exec($command);
    
    if ($output === null) {
        throw new Exception("Python script execution failed. Command: $command");
    }
    
    return $output;
}

// Main execution
$output = '';
$result = [];
$displayResults = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
    $displayResults = true;
    
    try {
        // Process upload
        $imagePath = processUpload($_FILES['image'], $uploadDir);
        
        // Execute Python OCR
        $pythonOutput = executePythonOCR($pythonScript, $imagePath);
        
        // Clean and decode JSON output
        $result = json_decode($pythonOutput, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception("Invalid JSON response. Raw output: " . htmlspecialchars($pythonOutput));
        }
        
        // Clean up uploaded file
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
        
    } catch (Exception $e) {
        $output = "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-5PJVHXE14X"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-5PJVHXE14X');
</script>
    <title>OCR Image Upload</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; }
        .result { margin-top: 20px; padding: 20px; background: #f5f5f5; border-radius: 5px; }
        .result-item { margin-bottom: 10px; }
        .result-label { font-weight: bold; }
        .error { color: red; }
        .debug { margin-top: 20px; padding: 10px; background: #eee; }
    </style>
</head>
<body>
    <h1>Upload Image for OCR Processing</h1>
    <form method="post" enctype="multipart/form-data">
        <input type="file" name="image" accept="image/jpeg, image/png" required>
        <button type="submit">Process Image</button>
    </form>

    <?php if ($displayResults): ?>
    <div class="result">
        <h2>OCR Results:</h2>
        
        <?php if (!empty($output)): ?>
            <div class="error"><?= $output ?></div>
        <?php elseif (!empty($result)): ?>
            <?php if (isset($result['error'])): ?>
                <div class="error"><?= htmlspecialchars($result['error']) ?></div>
            <?php else: ?>
                <div class="result-item">
                    <span class="result-label">Account ID:</span> <?= htmlspecialchars($result['accountID'] ?? 'Not found') ?>
                </div>
                <div class="result-item">
                    <span class="result-label">Current Stars:</span> <?= htmlspecialchars($result['currentStars'] ?? 'Not found') ?>
                </div>
                <div class="result-item">
                    <span class="result-label">Highest Stars:</span> <?= htmlspecialchars($result['highestStars'] ?? 'Not found') ?>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <div class="error">No results were returned from the OCR process</div>
        <?php endif; ?>
    </div>
    
    <div class="debug">
        <h3>Debug Information:</h3>
        <?php if (isset($imagePath)): ?>
            <p>Processed image: <?= htmlspecialchars($imagePath) ?></p>
        <?php endif; ?>
        <?php if (isset($pythonOutput)): ?>
            <p>Raw Python output:</p>
            <pre><?= htmlspecialchars($pythonOutput) ?></pre>
        <?php endif; ?>
    </div>
    <?php endif; ?>
</body>
</html>