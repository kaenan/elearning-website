<?php
require_once(dirname(dirname(__DIR__)).'/settings/settings.php');
require_once(dirname(dirname(__DIR__)).'/settings/lib.php');
require_once('create_quiz_form.php');
require_once('lib.php');
require_once('../lib.php');

$courseid = get_parameter('courseid');

$form = new create_quiz_form('quizform', ['courseid' => $courseid]);

if ($data = $form->get_data()) {
    create_activity($data);
    header('Location: ../../courses/course.php?c=' . $data['courseid']);
}

echo $OUTPUT->header();

echo $form->print_form();

echo $OUTPUT->footer();