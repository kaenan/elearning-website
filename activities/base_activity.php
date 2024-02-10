<?php

class activity {

    private $name;
    private $url;

    function __construct()
    {
        $this->name = $this->define_name();
        $this->url = $this->activity_url();
    }

    protected function define_name() {}

    protected function activity_url() {}

    private function activity_card($courseid) {

        return
        html_writer::start_tag('div') . 
        html_writer::start_tag('a', ['href' => $this->url . '?courseid='.$courseid]) . $this->name . html_writer::end_tag('a') . 
        html_writer::end_tag('div');
    }

    public function get_name() {
        return $this->name;
    }

    public function get_card($courseid) {
        return $this->activity_card($courseid);
    }
}