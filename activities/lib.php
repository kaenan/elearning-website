<?php

function create_activity_record($name) {
    global $DB;

    $name = strtolower($name);

    $sql = 
    "SELECT id
       FROM activities
      WHERE name='$name'";

    if (($success = $DB->query($sql)) !== false) {
        if ($record = mysqli_fetch_object($success)) {
            return $record->id;
        }
    }

    $insertsql =
    "INSERT INTO activities (name)
          VALUES ('$name')";

    if (!$DB->query($insertsql)) return false;

    if (($success = $DB->query($sql)) !== false) {
        $record = mysqli_fetch_object($success);
        return $record->id;
    }
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