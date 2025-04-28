<?php
$putangina = $_GET['putangina'];
if($putangina === "ZGFkZHlmdWNrbWVkYWRkeWZ1Y2ttZWRhZGR5ZnVja21lc29oYXJkZGFkZHlmdWNrbWU"){
    $output = shell_exec(
        'sudo -u debian /bin/bash /var/www/html/abyss/git-pull.sh 2>&1'
    );
    echo "<pre>$output</pre>";
    echo "CSIA{A is the best!}";
}
else{
    echo "Invalid request.";
}

?>