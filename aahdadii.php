<?php
$putangina = $_GET['putangina'];
if($putangina === "ZGFkZHlmdWNrbWVkYWRkeWZ1Y2ttZWRhZGR5ZnVja21lc29oYXJkZGFkZHlmdWNrbWU"){
    $output = shell_exec(
        'sudo -u debian /bin/bash /var/www/html/abyss/git-pull.sh 2>&1'
    );
    echo "<pre>$output</pre>";
}
else{
    echo "Invalid request.";
}

?>