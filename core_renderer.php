<?php
class core_renderer {

    protected $root;

    function __construct()
    {
        $this->root = '';
        $count = count(explode('/', $_SERVER['REQUEST_URI'])) - 3;
        while($count > 0) {
            $this->root .= '../';
            $count--;
        }
    }

    function header() {
        $csslink= $this->root.'theme/css/general.css';
        $html =
        '<link rel="stylesheet" href="'.$csslink.'">
        <header id="page-header">
            <div class="pageheader">
                <div class="header-logo">
                    <p>ELearning Website</p>
                </div>
                <div class="navigation-buttons">
                    <a class="nav-button" href="'.$this->root.'index.php">Dashboard</a>
                    <a class="nav-button" href="'.$this->root.'courses/courses.php">Courses</a>
                </div>
                <div>
                    <form method="post" action="'.$this->root.'index.php">
                        <input type="hidden" name="action" value="logout">
                        <input type="submit" value="Logout">
                    </form>
                </div>';
        if (isset($_SESSION['username'])) {
            $html .=
            '<div>
                <p>'. ucfirst(substr($_SESSION['firstname'], 0, 1)) . ucfirst(substr($_SESSION['lastname'], 0, 1)) .
            '</p></div>';
        }
        $html .=
        '</div>
        </header>
    
        <div id="main-content">
            <div id="inner-content">';
        
        return $html;
    }

    function footer() {
        return 
        '</div>
        </div>
        <footer id="page-footer">
        </footer>';
    }

    /**
     * login - HTML for the login form including creating account.
     */
    static function login() {
        return
        '<div class="login-container">
            <div class="login-form">
                <form method="post">
                    <input type="text" name="username" class="login-input" placeholder="Username">
                    <input type="password" name="password" class="login-input" placeholder="************">
                    <input type="hidden" name="sessionkey" value="'.time().'">
                    <input type="hidden" name="action" value="login">
                    <input type="submit" value="Login">
                </form>
            </div> 
            <div class="createaccount-form">
                <form method="post">
                    <input type="text" name="firstname" class="firstname-input" placeholder="Firstname">
                    <input type="text" name="lastname" class="lastname-input" placeholder="Lastname">
                    <input type="text" name="username" class="login-input" placeholder="Username">
                    <input type="password" name="password" class="login-input" placeholder="************">
                    <input type="hidden" name="action" value="create">
                    <input type="submit" value="Create">
                </form>
            </div>
        </div>';
    }

    static function create_link(string $name, string $link, array $attributes = array()) {

        $html =
        '<a href="'.$link.'"';

        if (isset($attributes['class'])) {
            $html .= ' class="' . $attributes['class'] .'"';
        }

        $html .= '>'.$name.'</a>';

        return $html;
    }

    static function post_button(string $label, array $data, string $action = null) {

        $html = '<form method="post"';

        if (isset($action)) {
            $html .= ' action="'.$action.'"';
        }

        $html .= '>';

        foreach ($data as $key => $d) {
            $html .= '<input type="hidden" name="'.$key.'" value="'.$d.'">';
        }

        $html .= '<input type="submit" value="'.$label.'">';

        return $html;
    }

    static function add_js($filepath) {
        return '<script src="'.$filepath.'"></script>';
    }
}

/**
 * Creating html table functions.
 */

class html_table {

    public array $headers;

    private array $rows;

    function __construct()
    {
        $this->headers = array();
        $this->rows = array();
    }

    function new_row(html_row $row) {
        $this->rows[] = $row;
    }

    function print_table() {

        $html = '<table>';

        $html .= '<tr>';
        foreach($this->headers as $head) {
            $html .= '<th>'.$head.'</th>';
        }
        $html .= '</tr>';

        foreach($this->rows as $row) {
            $html .= '<tr>';
            foreach($row->get_row_data() as $cell) {
                $html .= '<td>'.$cell->get_cell_data().'</td>';
            }
            $html .= '</tr>';
        }

        return $html . '</table>';
    }
}

class html_row {

    private array $cells;

    function __construct($array = array())
    {
        $this->cells = $array;
    }

    function add_cell(html_cell $cell) {
        $this->cells[] = $cell->get_cell_data();
    }

    function get_row_data() {
        return $this->cells;
    }
}

class html_cell {

    private string $cell;
    
    function __construct(string $data)
    {
        $this->cell = $data;
    }
    
    function get_cell_data() {
        return $this->cell;
    }
}

class html_list_item {

    private object $item;

    function __construct(string $label, array $attributes)
    {
        $this->item = new stdClass;
        $this->item->label = $label;
        $this->item->attributes = $attributes;
    }

    function get() {
        return $this->item;
    }
}

class html_description_list {

    private $html;

    private $terms;

    private array $descriptions;

    function __construct()
    {
        $this->html = '';
        $this->terms = array();
        $this->descriptions = array();
    }

    function add_term(html_list_item $term) {
        $this->terms[] = $term;
    }

    function add_description(html_list_item $description) {
        $this->descriptions[] = $description;
    }

    function print_list() {
        $this->html .= '<dl>';
        
        foreach($this->terms as $term) {
            $this->html .= '<dt ';
            
            foreach($term->get()->attributes as $key => $val) {
                $this->html .= $key . '="'. $val .'"';
            }
            
            $this->html .= '>'.$term->get()->label.'</dt>';
        }

        foreach($this->descriptions as $d) {
            $this->html .= '<dd></dd>';
        }

        return $this->html .= '</dl>';
    }
}

class html_buttom {

    private $html;

    private $label;

    private $attributes;

    function __construct($label, $attributes)
    {
        $this->html = '';
        $this->label = $label;
        $this->attributes = $attributes;
    }

    function print_button() {

        $this->html = '<button ';

        foreach ($this->attributes as $key => $val) {
            $this->html .= $key . '="' . $val . '" ';
        }

        $this->html .= '>' . $this->label . '</button>';

        return $this->html;
    }
}

class html_writer {

    static function start_tag($tag, $attributes = array()) {
        $html = "<" . $tag;

        foreach($attributes as $key => $val) {
            $html .= " $key=\"$val\"";
        }

        return $html . ">";
    }

    static function end_tag($tag) {
        return "</$tag>";
    }
}
