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

    if ($data = $DB->query($sql)) {
        return mysqli_fetch_all($data);
    }
}

function get_course($id) {
    global $DB;

    $sql =
    " SELECT id, name
        FROM courses
       WHERE id = $id";

    if ($data = $DB->query($sql)) {
        return mysqli_fetch_object($data);
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

    $sql =
    " SELECT id, name, categoryid
        FROM courses_categories
       WHERE categoryid = $categoryid
    ORDER BY sortorder";

    if ($data = $DB->query($sql)) {
        $data = mysqli_fetch_all($data);

        if (sizeof($data) > 0) {
            return $data;
        } else {
            return false;
        }
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

    $sql =
    " SELECT id, name
        FROM courses_categories
    ORDER BY categoryid, sortorder";

    $data = mysqli_fetch_all($DB->query($sql));

    if ($data) {
        $categories = array(0 => 'root');
        foreach ($data as $d) {
            $categories[$d[0]] = $d[1];
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
