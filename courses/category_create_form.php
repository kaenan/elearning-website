<?php
require_once(dirname(__DIR__).'/custom_form.php');
class create_category_form extends custom_form {

    function create_form() {

        $this->add_label('categoryname', 'Category Name');
        $this->add_input('string', 'categoryname', true);

        $this->add_label('description', 'Description');
        $this->add_input('string', 'description');

        $this->add_label('catid', 'CategoryID');
        $this->add_input('number', 'catid');

        $this->add_submit('Create');
    }
}