<?php

function createaccount($firstname, $lastname, $username, $password, $createsession = false) {
    global $DB;

    if (checkaccountexists($username)) {
        return false;
    }

    $pass = password_hash($password, PASSWORD_BCRYPT);

    $sql =
    "INSERT INTO accounts (username, password, firstname, lastname)
                VALUES('$username', '$pass', '$firstname', '$lastname')";

    if ($DB->query($sql)) {
        if ($createsession) {
            $data = new stdClass();
            $data->username = $username;
            $data->firstname = $firstname;
            $data->lastname = $lastname;

            createsession($data, time());
        }
    }
}

function login($username, $password, $sesskey) {
    global $DB;

    $sql =
    "SELECT username, password, firstname, lastname
       FROM accounts
      WHERE username='$username'";

    $data = mysqli_fetch_object($DB->query($sql));

    if ($data) {
        if (password_verify($password, $data->password)) {
            createsession($data, $sesskey);
            return true;
        }
    }

    return false;
}

function logout() {
    session_destroy();
    header('Location: index.php');
}

function check_loggedin() {
    if (!isset($_SESSION['username']) || !isset($_SESSION['sesskey'])) {
        header('Location: index.php');
        die;
    }
}

function checkaccountexists($username) {
    global $DB;

    $sql =
    "SELECT id
       FROM accounts
      WHERE username='$username'";

    $exists = $DB->query($sql);

    return count(mysqli_fetch_all($exists)) > 0;
}

function createsession($data, $sesskey) {
    $_SESSION['username'] = $data->username;
    $_SESSION['firstname'] = $data->firstname;
    $_SESSION['lastname'] = $data->lastname;
    $_SESSION['sesskey'] = $sesskey;
}

function post_parameter($parameter) {
    return isset($_POST[$parameter]) ? $_POST[$parameter] : null;
}
