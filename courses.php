<?php

require_once('settings/settings.php');
require_once('settings/lib.php');

check_loggedin();

echo $OUTPUT->header();
echo $OUTPUT->create_link('Create Course', 'courses_create.php');
echo $OUTPUT->footer();