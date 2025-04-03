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
        // Database hostname, can resolve or point to any host that serves the database
    'DB_HOST' => 'localhost',
        // Database name, by default it is 'mlofficial_database'
    'DB_NAME' => 'mlofficial_database',
        // Database username that can access the database above
    'DB_USERNAME' => 'root',
        // Database password for the username above (Depending on the user setup.)
    'DB_PASSWORD' => '',
    // Cookie and session timeout
        // How long does the cookie last in seconds
    'COOKIE_LIFETIME' => 1800,
        // The Domain Name or Hostname the cookie refers to
    'COOKIE_DOMAIN' => 'localhost',
        // Notification sound path
    'COOKIE_NOTIFICATION_SOUND_PATH' => '../AUDIO/cookie.mp3',
    // Minimum stars that the user can only search: matchmaking.php
    'MIN_STARS' => 0,
    // Maximum stars that the user can only search: matchmaking.php
    'MAX_STARS' => 50,
    // Default stars that the search starts at (upon clicking 'Find Scrim'): matchmaking.php
    'DEFAULT_STARS' => 10,
);
?>