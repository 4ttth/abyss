<?php if (isset($_SESSION['Error'])) : ?>
<!DOCTYPE html>
<body>
    <p><?= $_SESSION['Error']?></p>

<?php else : ?>
    <?php 
    header("Location: /index.php");
    exit;?>
<?php endif; ?>
</body>