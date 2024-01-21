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
        return mysqli_fetch_all($data);
    }
}

function course_category_thumbnail($name, $category = null) {

    $html = html_writer::start_tag('div', array('style' => 'width:200px; display:flex; justify-content:center;'));

    $url = '#?';
    if(isset($category)) {
        "category=$category";
    } 

    $html .= html_writer::start_tag('a', array('href' => $url));
    $html .= $name;
    $html .= html_writer::end_tag('a');
    return html_writer::end_tag('div');

    // return
    // "<div style=\"width: 200px; display: flex; justify-content: center;\">
    //     <a href=\"#\">
    //         $name
    //     </a>
    // </div>";
}
