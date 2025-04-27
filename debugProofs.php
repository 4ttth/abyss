<?php
require_once '/includes/dbh.inc.php';

echo "<h2>📄 Latest Uploaded Proofs (OCR Scan Results)</h2>";
echo "<table border='1' cellpadding='10'>";
echo "<tr><th>Proof ID</th><th>Verification ID</th><th>File Path</th><th>Battle ID</th><th>Result Status</th></tr>";

$stmt = $pdo->query("SELECT Proof_ID, Verification_ID, File_Path, Battle_ID, Result_Status FROM tbl_prooffiles ORDER BY Proof_ID DESC LIMIT 10");

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "<tr>";
    echo "<td>{$row['Proof_ID']}</td>";
    echo "<td>{$row['Verification_ID']}</td>";
    echo "<td><a href='{$row['File_Path']}' target='_blank'>View File</a></td>";
    echo "<td>{$row['Battle_ID']}</td>";
    echo "<td>{$row['Result_Status']}</td>";
    echo "</tr>";
}

echo "</table>";
?>
