<?php
require_once('../lib.php');

function create_activity($data) {
    global $DB;

    $activityid = get_activity_id('quiz');

    $sql =
    "INSERT INTO course_activities (courseid, activityid, sortorder, name)
    VALUES(
    ".$data['courseid'].",
    ".$activityid.",
    1,
    '".$data['quizname']."')";

    return $DB->query($sql);
}