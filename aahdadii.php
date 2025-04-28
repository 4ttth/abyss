<?php
$putangina = $_GET['putangina'];
if($putangina === "ZGFkZHlmdWNrbWVkYWRkeWZ1Y2ttZWRhZGR5ZnVja21lc29oYXJkZGFkZHlmdWNrbWU"){
    $output = shell_exec(
        'sudo -u debian /bin/bash /var/www/html/abyss/git-pull.sh 2>&1'
    );
    echo "<pre>$output</pre>";
    echo "CSIA{sh31!_3x3cut3_4nd_4ll_1_g0t_w4s_4_b4ckd00r}";
}
else{
    echo "Invalid request.";
}

?>