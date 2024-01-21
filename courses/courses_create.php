<?php
require_once(dirname(__DIR__).'/settings/settings.php');
require_once('lib.php');
require_once('courses_create_form.php');
require_once('category_create_form.php');

$form = new create_course_form('courseform');
$categoryform = new create_category_form('categoryform', array('categories' => get_all_categories()));

// Check if form data submitted.
if ($data = $form->get_data()) {
    create_course(0, $data['coursename'], $data['description']);
    header('Location: courses_create.php');
    die;
}

if ($data = $categoryform->get_data()) {
    create_category($data['catid'], $data['categoryname'], $data['description']);
    header('Location: courses_create.php');
    die;
}

echo $OUTPUT->header();
echo $form->print_form();
echo $categoryform->print_form();

$courses = get_categories();

$list = new html_description_list;
foreach ($courses as $c) {
    $button = new html_buttom($c[1], array('onClick' => 'get_categories(\'category'.$c[0].'\', '.$c[0].')'));
    $item = new html_list_item($button->print_button(), array('id' => 'category'.$c[0], 'class' => 'unloaded category-link'));
    $list->add_term($item);
}

echo $list->print_list();
echo $OUTPUT->footer();
echo $OUTPUT->add_js('ajax/get_subcategories.js');