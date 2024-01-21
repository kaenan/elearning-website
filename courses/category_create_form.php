<?php
require_once(dirname(__DIR__).'/custom_form.php');
class create_category_form extends custom_form {

    function create_form() {

        $categories = $this->formdata['categories'];

        $this->add_label('categoryname', 'Category Name');
        $this->add_input('string', 'categoryname', true);

        $this->add_label('description', 'Description');
        $this->add_input('string', 'description');

        $this->add_label('catid', 'CategoryID');
        $this->add_input('select', 'catid', false, $categories);

        $this->add_submit('Create');
    }
}