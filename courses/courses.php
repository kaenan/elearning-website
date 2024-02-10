<?php
require_once(dirname(__DIR__).'/settings/settings.php');
require_once(dirname(__DIR__).'/settings/lib.php');
require_once('lib.php');

check_loggedin();

$category = get_parameter('category', 0);
$categories = get_categories($category);
$courses = get_courses($category);

echo $OUTPUT->header();
echo $OUTPUT->create_link('Create Course', 'courses_create.php');

echo html_writer::start_tag('h1') . 'Categories' . html_writer::end_tag('h1');

echo html_writer::start_tag('div', array('style' => 'width:100%; display: flex; justify-content: space-around; flex-wrap: wrap;'));
if ($categories) {
    foreach($categories as $c) {
        echo course_category_thumbnail($c[1], $c[0]);
    }
} else {
    echo 'No categories to show.';
}
echo html_writer::end_tag('div');

echo html_writer::start_tag('h1') . 'Courses' . html_writer::end_tag('h1');
echo html_writer::start_tag('div', array('style' => 'width:100%; display: flex; justify-content: space-around; flex-wrap: wrap;'));
foreach($courses as $c) {
    echo course_category_thumbnail($c[1], $c[0], true);
}
echo html_writer::end_tag('div');

echo $OUTPUT->footer();