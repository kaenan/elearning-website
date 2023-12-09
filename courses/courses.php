<?php
require_once(dirname(__DIR__).'/settings/settings.php');
require_once(dirname(__DIR__).'/settings/lib.php');

check_loggedin();

echo $OUTPUT->header();
echo $OUTPUT->create_link('Create Course', 'courses_create.php');
echo $OUTPUT->footer();