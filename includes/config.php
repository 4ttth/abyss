<?php

// THIS IS A CONFIGURATION FILE FOR ABYSS
// To include this on a .php file, copy thie line below after session_start(): 
// $config = include('config.php');
//
// To add a configuration, simply add in the following line within the return array() function:
// 'CONFIG_VAR_NAME' => 'VALUE',
// You may check out the example of some within return array() function.
//
// To use a configuration variable, simply do the following:
// 1) Make sure to follow line 3-4.
// 2) Call / Fetch the configuration variable via the following line (making use of the sample in line 7):
// $config['CONFIG_VAR_NAME']

return array(
    // Database requirements
        // Database hostname, can resolve or point to any host that serves the databases
    'DB_HOST' => 'localhost',
        // Database name, by default it is 'mlofficial_database'
    'DB_NAME' => 'mlofficial_database',
        // Database username that can access the database above
    'DB_USERNAME' => 'root',
        // Database password for the username above (Depending on the user setup.)
    'DB_PASSWORD' => '',
    // Minimum stars that the user can only search: matchmaking.php
    'MIN_STARS' => 0,
    // Maximum stars that the user can only search: matchmaking.php
    'MAX_STARS' => 1000,
    // Default stars that the search starts at (upon clicking 'Find Scrim'): matchmaking.php
    'DEFAULT_STARS' => 5,
    // Maximum number of players that can be in a team
    'MAX_PLAYERS' => 5,
    // Machine host name
    'HOST_NAME' => 'abyss.folded.cloud',
    // CLOUDFLARE API TOKEN
    'CLOUDFLARE_TOKEN' => 'G5o5Hsy8myNXtNjy7ge8hAWCmmsN47kD90beFxqF'
);
?>