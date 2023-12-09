<?php
require_once(dirname(__DIR__).'/core_renderer.php');

// Start session.
session_start();

// Database connection params.
$db_server = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "elearningwebsite";

// Global variables.
$GLOBALS['DB'] = mysqli_connect($db_server, $db_user, $db_pass, $db_name); // Database connection.
$GLOBALS['OUTPUT'] = new core_renderer; // HTML class render.
