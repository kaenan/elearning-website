<?php
require_once(dirname(dirname(__DIR__)).'/custom_form.php');
class create_quiz_form extends custom_form {

    function create_form() {
        $courseid = $this->formdata['courseid'];

        $this->add_label('quizname', 'Quiz Name');
        $this->add_input('string', 'quizname', true);

        $this->add_hidden('courseid', $courseid);

        $this->add_submit('Create');
    }
}