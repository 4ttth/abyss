<?php

declare(strict_types= 1);

function is_input_empty(string $username, string $pwd, string $email) {
    if (empty($username) || empty($pwd) || empty($email)) {
        return true;
}   else {
        return false;
}
}

function is_email_invalid(string $email) {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return true;
}   else {
        return false;
}
}

function is_username_taken(object $pdo, string $username) {
    if (get_username( $pdo, $username)) {
        return true;
}   else {
        return false;
}
}

function is_email_registered(object $pdo, string $email) {
    if (get_email($pdo, $email)) {
        return true;
}   else {
        return false;
}
}

function is_passwordLength_short(object $pdo, string $password) {
        if (strlen($password) < 8){
                return true;
        }
        else {
                return false;
        }
}

function is_password_not_same(string $pwd, string $confirmPassword) {
        return $pwd !== $confirmPassword;
}


function create_user(object $pdo, string $email, string $pwd, string $username) {
    set_user($pdo, $email, $pwd, $username);
}