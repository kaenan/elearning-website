<?php
require_once(dirname(__DIR__).'/settings/settings.php');
require_once(dirname(__DIR__).'/settings/lib.php');
require_once('lib.php');

check_loggedin();

$category = post_parameter('category', 0);

$categories = get_categories($category);
$courses = get_courses($category);

echo $OUTPUT->header();
echo $OUTPUT->create_link('Create Course', 'courses_create.php');

echo '<div style="width:100%; display: flex; justify-content: center;">';

foreach($categories as $c) {
    echo course_category_thumbnail($c[1]);
}

foreach($courses as $c) {
    echo course_category_thumbnail($c[1]);
}

echo '</div>';

echo $OUTPUT->footer();