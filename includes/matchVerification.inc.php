<?php
session_start();
error_reporting(E_ALL);
require_once 'dbh.inc.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['verify_submit'])) {
    $scrimID = $_POST['scrim_id'] ?? null;
    $yourScore = $_POST['your_score'] ?? null;
    $opponentScore = $_POST['opponent_score'] ?? null;
    $squadID = $_SESSION['user']['Squad_ID'] ?? null;

    if (!$scrimID || !$yourScore || !$opponentScore || !$squadID) {
        header("Location: matchVerificationPage.php?scrim_id=$scrimID&error=missing_fields");
        exit();
    }

    try {
        if (empty($_FILES['proof_files']['name'][0])) {
            header("Location: matchVerificationPage.php?scrim_id=$scrimID&error=no_files");
            exit();
        }

        $stmt = $pdo->prepare("INSERT INTO tbl_matchverifications (Match_ID, Squad_ID, Your_Score, Opponent_Score) VALUES (?, ?, ?, ?)");
        $stmt->execute([$scrimID, $squadID, $yourScore, $opponentScore]);
        $verificationID = $pdo->lastInsertId();

        $uploadDir = '../uploads/match_proofs/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        foreach ($_FILES['proof_files']['tmp_name'] as $key => $tmpName) {
            if ($_FILES['proof_files']['error'][$key] !== UPLOAD_ERR_OK) {
                continue;
            }

            $fileName = basename($_FILES['proof_files']['name'][$key]);
            $fileExt = pathinfo($fileName, PATHINFO_EXTENSION);
            $newFileName = uniqid('proof_', true) . '.' . $fileExt;
            $uploadPath = $uploadDir . $newFileName;

            if (move_uploaded_file($tmpName, $uploadPath)) {
                $stmtFile = $pdo->prepare("INSERT INTO tbl_prooffiles (Verification_ID, File_Path) VALUES (?, ?)");
                $stmtFile->execute([$verificationID, $uploadPath]);
                $proofID = $pdo->lastInsertId();

                // OCR SCRIPT
                $pythonScript = 'C:/xampp/htdocs/abyss/Python/ML-OCR/battleResults.py';
                $command = "python " . escapeshellcmd($pythonScript) . " " . escapeshellarg($uploadPath) . " 2>&1";
                $output = shell_exec($command);

                if ($output === null || trim($output) === '') {
                    $output = json_encode(['error' => 'Shell command failed or returned empty.']);
                }

                $ocrResult = json_decode($output, true);
                if (!is_array($ocrResult)) {
                    $ocrResult = ['battleID' => 'Not found', 'resultStatus' => 'Not found'];
                }

                $battleID = $ocrResult['battleID'] ?? 'Not found';
                $resultStatus = $ocrResult['resultStatus'] ?? 'Not found';

                if (strpos(strtolower($resultStatus), 'victory') !== false) {
                    $resultStatus = 'Victory';
                } elseif (strpos(strtolower($resultStatus), 'defeat') !== false) {
                    $resultStatus = 'Defeat';
                } else {
                    $resultStatus = 'Not found';
                }

                $updateStmt = $pdo->prepare("UPDATE tbl_prooffiles SET Battle_ID = ?, Result_Status = ? WHERE Proof_ID = ?");
                $updateStmt->execute([$battleID, $resultStatus, $proofID]);
            }
        }

        $_SESSION['verification_submitted'] = true;
        header("Location: ../verificationSuccess.php");
        exit();

    } catch (PDOException $e) {
        header("Location: matchVerificationPage.php?scrim_id=$scrimID&error=database");
        exit();
    } catch (Exception $e) {
        header("Location: matchVerificationPage.php?scrim_id=$scrimID&error=general");
        exit();
    }
} else {
    header("Location: invitesPage.php");
    exit();
}
?>