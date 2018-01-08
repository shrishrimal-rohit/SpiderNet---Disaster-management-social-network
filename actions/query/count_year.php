<?php
/**
 * Created by PhpStorm.
 * User: Hunter
 * Date: 11/22/2017
 * Time: 1:07 AM
 */
$user = new OssnUser();
$data = $user->countByYearMonth();
$json = json_encode($data);
echo $json;