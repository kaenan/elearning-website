<?php

class activity {

    private $name;
    private $create_url;
    private $activity_url;

    function __construct()
    {
        $this->name = $this->define_name();
        $this->create_url = $this->create_url();
        $this->activity_url = $this->activity_url();
    }

    protected function define_name() {}

    protected function create_url() {}

    protected function activity_url() {}

    private function create_activity($courseid) {

        return
        html_writer::start_tag('div') . 
        html_writer::start_tag('a', ['href' => $this->create_url . '?courseid='.$courseid]) . $this->name . html_writer::end_tag('a') . 
        html_writer::end_tag('div');
    }

    private function activity_card($id, $name) {

        return
        html_writer::start_tag('div') . 
        html_writer::start_tag('a', ['href' => $this->activity_url . '?id='.$id]) . $name . html_writer::end_tag('a') . 
        html_writer::end_tag('div');
    }

    public function get_name() {
        return $this->name;
    }

    public function create_activity_card($courseid) {
        return $this->create_activity($courseid);
    }

    public function get_activity_card($id, $name) {
        return $this->activity_card($id, $name);
    }

    public function get_activity_url() {
        return $this->activity_url;
    }
}