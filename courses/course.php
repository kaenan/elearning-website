<?php
require_once(dirname(__DIR__).'/settings/settings.php');
require_once(dirname(__DIR__).'/settings/lib.php');
require_once('lib.php');

check_loggedin();

$id = get_parameter('c');

$course = get_course($id);
$activites = get_activities($id);

echo $OUTPUT->header();
echo $OUTPUT->create_link('Add activity', '../activities/add_activity.php?courseid='.$id);
echo '<br>';
echo $course->name;
echo '<br>';

if ($activites) {
    foreach ($activites as $a) {
        echo $a . '<br>';
        echo '<br>';
    }
}

echo $OUTPUT->footer();