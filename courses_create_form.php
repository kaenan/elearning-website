<?php
require_once('custom_form.php');
class create_course_form extends custom_form {

    function create_form() {

        $this->add_label('coursename', 'Course Name');
        $this->add_input('string', 'coursename', true);

        $this->add_label('description', 'Description');
        $this->add_input('string', 'description');

        $this->add_submit('Create');
    }
}