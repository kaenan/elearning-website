<?php

class core_renderer {

    static function header() {

        $html =
        '<link rel="stylesheet" href="theme/css/general.css">
        <header id="page-header">
            <div class="pageheader">
                <div class="header-logo">
                    <p>ELearning Website</p>
                </div>
                <div class="navigation-buttons">
                    <a class="nav-button" href="index.php">Dashboard</a>
                    <a class="nav-button" href="courses.php">Courses</a>
                </div>
                <div>
                    <form method="post" action="index.php">
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

    static function footer() {
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
}
