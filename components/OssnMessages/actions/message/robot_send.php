<?php
/**
 * Created by PhpStorm.
 * User: Hunter
 * Date: 11/12/2017
 * Time: 5:08 PM
 */

//date_default_timezone_set('US/Pacific');
//$date = new DateTime();
//$datestr=(string)$date->format('Y-m-d H:i:s');

$robot_uid=ossn_robot_uid()->guid;

$send = new OssnMessages;

$from = $robot_uid;
$to = input('to');
$message = input('message');
if ($send->send($from, $to, $message)) {
    $user = ossn_user_by_guid(ossn_loggedin_user()->guid);
    $message = ossn_restore_new_lines($message);

    $params['user'] = $user;
    $params['message'] = $message;
    echo ossn_plugin_view('messages/templates/message-send', $params);

} else {
    echo 0;
}
//messages only at some points #470
// don't mess with system ajax requests
exit;
