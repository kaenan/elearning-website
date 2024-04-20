<?php
require_once('../lib.php');

function create_activity($data) {
    global $DB;

    $activityid = get_activity_id('quiz');

    return $DB->insert_record('course_activities', [
        'courseid' =>  (integer) $data['courseid'],
        'activityid' => (integer) $activityid,
        'sortorder' => 1,
        'name' => $data['quizname']
    ]);
}