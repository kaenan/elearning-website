<?php

function create_course(int $categoryid, string $name, string $description) {
    global $DB;

    $sql =
       "SELECT id, sortorder
          FROM courses
         WHERE categoryid = $categoryid
      ORDER BY sortorder DESC
         LIMIT 1";

    if (($success = $DB->query($sql)) !== false) {
        $record = mysqli_fetch_object($success);
        if ($record !== false) {
            $order = $record->sortorder + 1;
        } else {
            $order = 0;
        }
    } else {
        return false;
    }

    $created = time();

    $sql =
    "INSERT INTO courses (categoryid, name, description, sortorder, created)
                 VALUES($categoryid, '$name', '$description', $order, $created)";

    return $DB->query($sql);
}

function create_category(int $categoryid, string $name, string $description) {
    global $DB;

    $sql =
       "SELECT id, sortorder
          FROM courses_categories
         WHERE categoryid = $categoryid
      ORDER BY sortorder DESC
         LIMIT 1";

    if (($success = $DB->query($sql)) !== false) {
        $record = mysqli_fetch_object($success);
        if ($record !== false) {
            $order = $record->sortorder + 1;
        } else {
            $order = 0;
        }
    } else {
        return false;
    }

    $created = time();

    $sql =
    "INSERT INTO courses_categories (categoryid, name, description, sortorder, created)
                 VALUES($categoryid, '$name', '$description', $order, $created)";

    return $DB->query($sql);
}

function get_courses($categoryid = null) {
    global $DB;

    $sql =
    " SELECT id, name
        FROM courses";

    if (isset($categoryid)) {
        $sql .= " WHERE categoryid = $categoryid";
    }
    
    $sql .= " ORDER BY sortorder";

    return $DB->get_records_sql($sql);
}

function get_course($id) {
    global $DB;

    $sql =
    " SELECT id, name
        FROM courses
       WHERE id = $id";

    if ($data = $DB->get_record('courses', ['id' => $id], 'id, name')) {
        return $data;
    }

    return false;
}

/**
 * get_categories - Get categories with id.
 * 
 * @param int $categoryid - Category ID.
 * @return array $data - Array of category data.
 */
function get_categories($categoryid = 0) {
    global $DB;

    if ($data = $DB->get_records('courses_categories', ['categoryid' => $categoryid], 'id, name, categoryid', 'sortorder')) {
        return $data;
    }

    return false;
}

/**
 * get_all_categories - Get all categories ordered by sort order.
 * 
 * @param int $categoryid - Category ID.
 * @return array $data - Array of category data.
 */
function get_all_categories() {
    global $DB;

    if ($data = $DB->get_records('courses_categories', null, 'id, name', 'categoryid, sortorder')) {
        $categories = array(0 => 'root');
        foreach ($data as $d) {
            $categories[$d->id] = $d->name;
        }

        return $categories;
    }

    return array(0 => 'root');
}

function course_category_thumbnail($name, $id, $coursethumbnail = false) {

    $html = html_writer::start_tag('div', 
        array('style' => 'width:200px;
                            height:150px;
                            display:flex;
                            justify-content:center;
                            align-content:center;
                            flex-wrap:wrap;
                            border: 2px solid black;
                            border-radius: 10px;
                            margin-bottom: 10px;'));

    if ($coursethumbnail == 0) {
        $url = "?category=$id";
    } else {
        $url = "course.php?c=$id";
    }

    $html .= html_writer::start_tag('a', array('href' => $url));
    $html .= $name;
    $html .= html_writer::end_tag('a');
    $html .= html_writer::end_tag('div');

    return $html;
}

function get_activities($courseid) {
    global $DB;

    $sql =
    "SELECT ca.id, ca.name AS activityname, a.name AS name 
       FROM course_activities ca
       JOIN activities a ON ca.activityid = a.id
      WHERE ca.courseid = {$courseid}";

    // if ($success = $DB->query($sql)) {
    //     if (count($data = mysqli_fetch_all($success)) > 0) {

    //         $activities = [];
    //         foreach ($data as $d) {
    //             require_once(dirname(__DIR__) . '/activities/' . $d[2] . '/activity.php');
    //             $activity = new $d[2]();
    //             $activities[] = $activity->get_activity_card($d[0], $d[1]);
    //         }

    //         return $activities;
    //     }
    // }

    if ($data = $DB->get_records_sql($sql)) {
        if (count($data) > 0) {

            $activities = [];
            foreach ($data as $d) {
                require_once(dirname(__DIR__) . '/activities/' . $d->name . '/activity.php');
                $activity = new ($d->name)();
                $activities[] = $activity->get_activity_card($d->id, $d->activityname);
            }

            return $activities;
        }
    }

    return false;
}
