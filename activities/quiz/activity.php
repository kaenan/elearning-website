<?php
require_once(dirname(dirname(__DIR__)).'/activities/base_activity.php');
class quiz extends activity {

    function define_name() {

        return 'Quiz';
    }

    function activity_url() {

        return 'quiz/create_quiz.php';
    }
}