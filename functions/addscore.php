<?php

$secretKey = "4yloxmo9x8ouo079b9";

$realHash = md5($_GET['userID'] . $_GET['score'] . $secretKey);
$score = $_GET['score'];
$userID = $_GET['userID'];
if($realHash == $hash) {
    $this->_db->insert('highscore', array(
        'userID' => $userID,
        'score' => $score
    ))
}