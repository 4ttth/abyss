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
foreach ($ocrResult1 as $key => $value){
    echo "$key: $value\n";
};
echo "jsonResult" . $ocrResult1['battleID'] . "<br><br>";
echo "jsonResult" . $ocrResult1['resultStatus'] . "<br><br>";
echo "shellResult" . $ocrResult2 . "<br><br>";
echo "Raw Shell Output: " . $output . "<br><br>";

$ocrResult = json_decode($output, true);
if (!is_array($ocrResult)) {
    $ocrResult = ['battleID' => 'Not found', 'resultStatus' => 'Not found'];
    $_SESSION['debug'] = $ocrResult;
}
$battleID = $ocrResult['battleID'] ?? 'Not found';
$resultStatus = $ocrResult['resultStatus'] ?? 'Not found';
echo "<br>battleID: " . $battleID . "<br><br>";
echo "resultStatus: " . $resultStatus . "<br><br>";

echo shell_exec("/usr/bin/python3 --version 2>&1") . "<br><br>";
echo shell_exec("/usr/bin/python3 -m pip list 2>&1") . "<br><br>";
if (strpos(strtolower($resultStatus), 'victory') !== false) {
    $resultStatus = 'Victory';
    $victoryCount++;
} elseif (strpos(strtolower($resultStatus), 'defeat') !== false) {
    $resultStatus = 'Defeat';
    $defeatCount++;
}
echo $victoryCount . "<- Victories <br><br>";
echo $defeatCount . "<- Defeat <br><br>";
?>
CSIA{Y0u_f0und_m3}
</body>
</html>
