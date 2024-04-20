<?php
require_once(dirname(__DIR__).'/settings/settings.php');
require_once(dirname(__DIR__).'/settings/lib.php');
require_once('lib.php');

check_loggedin();

$courseid = get_parameter('courseid');

echo $OUTPUT->header();

$activities = get_activities();

foreach ($activities as $a) {
    echo $a->create_activity_card($courseid);
}

echo $OUTPUT->footer();