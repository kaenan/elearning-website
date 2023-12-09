<?php
require_once(dirname(__DIR__).'/settings/settings.php');
require_once(dirname(__DIR__).'/settings/lib.php');
require_once('courses_create_form.php');
require_once('category_create_form.php');

$form = new create_course_form('courseform');
$categoryform = new create_category_form('categoryform');

if ($data = $form->get_data()) {
    create_course(0, $data['coursename'], $data['description']);
    header('Location: courses_create.php');
    die;
}

if ($data = $categoryform->get_data()) {
    create_category(0, $data['categoryname'], $data['description']);
    header('Location: courses_create.php');
    die;
}

echo $OUTPUT->header();
echo $form->print_form();
echo $categoryform->print_form();

$table = new html_table();
$table->headers = array('ID', 'Name');
$courses = get_courses();

foreach ($courses as $coursedata) {
    $cells = array();
    foreach($coursedata as $c) {
        $cells[] = new html_cell($c);
    }
    $table->new_row(new html_row($cells));
}

echo $table->print_table();
echo $OUTPUT->footer();