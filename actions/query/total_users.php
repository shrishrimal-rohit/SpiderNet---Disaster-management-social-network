<?php
/**
 * Created by PhpStorm.
 * User: Hunter
 * Date: 11/22/2017
 * Time: 1:03 AM
 */
$total = ossn_total_site_users();
$json = json_encode($total);
echo $json;