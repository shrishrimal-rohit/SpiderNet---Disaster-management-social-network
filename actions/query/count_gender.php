<?php
/**
 * Created by PhpStorm.
 * User: Hunter
 * Date: 11/22/2017
 * Time: 1:14 AM
 */
$user = new OssnUser();
$data['male'] = $user->countByGender('male');
$data['female'] = $user->countByGender('female');
$json = json_encode($data);
echo $json;