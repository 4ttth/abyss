<!DOCTYPE html>
<html>
<body>

<?php
$command = "/usr/bin/python3 /var/www/html/abyss/Python/ML-OCR/battleResults.py /var/www/html/abyss/uploads/match_proofs/proof_680ef2998a6260.33876361.PNG 2>&1";
$output = shell_exec($command);
$jsonResult = '{"resultStatus": "Defeat", "battleID": "201965272562210724"}';
$ocrResult1 = json_decode($jsonResult, true);
$ocrResult2 = json_decode($output, true);
echo "jsonResult" . $ocrResult1 . "<br><br>";
echo "shellResult" . $ocrResult2 . "<br><br>";
echo "Raw Shell Outpu: " . $output . "<br><br>";
?>

</body>
</html>
