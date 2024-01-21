<?php
require_once(dirname(__DIR__).'/settings/settings.php');
require_once(dirname(__DIR__).'/settings/lib.php');
require_once('lib.php');

check_loggedin();

$id = get_parameter('c');

$course = get_course($id);

echo $OUTPUT->header();
echo $course->name;
echo $OUTPUT->footer();