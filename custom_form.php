<?php
class custom_form {

    private $formid;

    private $html;

    private $data;

    protected $formdata;

    function __construct($formid, array $formdata = null)
    {
        $this->html = '';
        $this->formdata = $formdata;
        $this->data = array();
        $this->set_data();
        $this->create_form($formdata);
        $this->formid = $formid;
    }

    /**
     * Protected functions.
     */

    /**
     * Create_form - Init function to define form inputs.
     */
    protected function create_form() {}

    /**
     * Set_data - DO NOT CALL THIS FUNCTION - Sets form data that was posted.
     */
    protected function set_data() {
        foreach($_POST as $key => $val) {
            $this->data[$key] = $val; 
        }
    }

    /**
     * Add_label - Create a label for an input.
     */
    protected function add_label($for, $label) {
        $this->html .= '<label for="'.$for.'">'.$label.'</label>';
    }

    /**
     * Add_input - Create a form input.
     */
    protected function add_input(string $type, string $name, $required = false, $selectoptions = null) {

        $required = $required ? 'required' : '';

        switch($type) {

            case 'select':
                $this->html .= '<select name="'.$name.'" '.$required.'>';
                foreach ($selectoptions as $key => $val) {
                    $this->html .= '<option value="'.$key.'">' . $val . '</option>';
                }
                break;

            default:
                $this->html .= '<input type="'.$type.'" name="'.$name.'" '.$required.'>';
                break;
        }
    }

    protected function add_hidden(string $name, $value) {
        $this->html .= '<input type="hidden" name="'.$name.'" value="'.$value.'">';
    }

    /**
     * Add_submit - Create a form submit button.
     */
    protected function add_submit(string $value) {
        $this->html .= '<input type="submit" value="'.$value.'">';
    }

    /**
     * Public functions.
     */

    /**
     * Print_form - Prints form HTML.
     * 
     * @return string $html - String of HTML to create form defined inputs.
     */
    function print_form() {
        return 
        '<form method="post">' .
        $this->html .
        '<input type="hidden" name="formsubmitted" value="'.$this->formid.'">
        </form>';
    }

    /**
     * Get_data - Get data posted by form.
     * 
     * @return object|bool $data - Posted data as object. False if no data posted.
     */
    function get_data() {
        if (isset($this->data['formsubmitted'])) {
            if ($this->data['formsubmitted'] == $this->formid) {
                return $this->data;
            }
        }
        return false;
    }
}