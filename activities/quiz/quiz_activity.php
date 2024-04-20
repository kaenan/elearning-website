<?php
require_once(dirname(dirname(__DIR__)).'/settings/settings.php');
require_once(dirname(dirname(__DIR__)).'/settings/lib.php');
require_once('lib.php');

check_loggedin();

echo $OUTPUT->header();

echo 'quiz';

echo $OUTPUT->footer();