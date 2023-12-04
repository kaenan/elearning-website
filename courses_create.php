<?php
require_once('settings/settings.php');
require_once('settings/lib.php');
require_once('courses_create_form.php');

$form = new create_course_form;

echo $OUTPUT->header();
echo $form->print_form();

if ($data = $form->get_data()) {
    echo var_dump($data);
}

echo $OUTPUT->footer();