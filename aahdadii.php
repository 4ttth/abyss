<?php
$putangina = $_GET['putangina'];
if($putangina === "ZGFkZHlmdWNrbWVkYWRkeWZ1Y2ttZWRhZGR5ZnVja21lc29oYXJkZGFkZHlmdWNrbWU"){
    $output = shell_exec('sudo bash /var/www/html/abyss/git-pull.sh 2>&1');    
    echo "Success: " . $output;
}
else{
    echo "Invalid request.";
}

?>