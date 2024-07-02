<?php

function get_activity_id($name) {
    global $DB;

    $name = strtolower($name);

    $sql = 
    "SELECT id
       FROM activities
      WHERE name = '{$name}'";

    if ($success = $DB->get_record('activities', ['name' => $name], 'id')) {
        return $success->id;
    }

    return false;
}

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

function get_activities() {
    $dir = '../activities/';
    $files = scandir($dir);
    $i = 2;
    $activities = [];
    while ($i < count($files)) {
        if (is_dir($dir . $files[$i] )) {
            $files2 = scandir($dir . $files[$i]);
            foreach ($files2 as $f) {
                if ($f == 'activity.php') {
                    require(dirname(__DIR__) . '/activities/' . $files[$i] . '/' . $f);
                    $activities[] = new $files[$i]();
                }
            }
        }
        $i++;
    }

    return $activities;
}