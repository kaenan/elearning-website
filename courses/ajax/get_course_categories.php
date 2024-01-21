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

if ($data = $DB->query($sql)) {
    echo json_encode(mysqli_fetch_all($data));
    die;
}
echo false;
