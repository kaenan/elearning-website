<?php
require_once('settings/settings.php');
require_once('settings/lib.php');

$username = post_parameter('username');
$password = post_parameter('password');
$firstname = post_parameter('firstname');
$lastname = post_parameter('lastname');
$sesskey = post_parameter('sessionkey');
$action = post_parameter('action');

if ($action == 'login') {
    login($username, $password, $sesskey);
} else if ($action == 'create') {
    if (!createaccount($firstname, $lastname, $username, $password, true)) {
        $success = 'Error trying to create account. Please try again';
    }
} else if ($action =='logout') {
    logout();
    die;
}

if (isset($_SESSION['sesskey'])) {
    header('Location: courses.php');
}

echo $OUTPUT->header();
echo $OUTPUT->login();
echo $OUTPUT->footer();
