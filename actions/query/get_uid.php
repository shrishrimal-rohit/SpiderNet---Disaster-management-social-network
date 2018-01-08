<?php
/**
 * Created by PhpStorm.
 * User: Hunter
 * Date: 11/16/2017
 * Time: 11:34 PM
 */
//if(ossn_isLoggedin() &&
//   ossn_loggedin_user()->guid == ossn_robot_uid()->guid) {

    $email = input('email');

    $db = new OssnDatabase();

    $param['from'] = 'ossn_users';
    $param['wheres'] = array(
        "email = '{$email}'"
    );

    $uid = ($db->select($param))->guid;
    if(!uid)
        echo "-1";
    echo $uid;
//echo 1;
//}