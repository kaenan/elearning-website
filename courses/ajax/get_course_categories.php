<?php

require_once(dirname(dirname(__DIR__)).'/settings/settings.php');
require_once(dirname(dirname(__DIR__)).'/settings/lib.php');

$catid = post_parameter('catid');

global $DB;

$sql =
" SELECT id, name, categoryid
    FROM courses_categories
    WHERE categoryid = $catid
ORDER BY sortorder";

if ($data = $DB->get_records('courses_categories', ['categoryid' => $catid], 'id, name, categoryid', 'sortorder')) {
    echo json_encode($data);
    die;
}
echo false;
