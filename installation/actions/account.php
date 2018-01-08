<?php
/**
 * Open Source Social Network
 *
 * @package   (softlab24.com).ossn
 * @author    OSSN Core Team <info@softlab24.com>
 * @copyright 2014-2017 SOFTLAB24 LIMITED
 * @license   Open Source Social Network License (OSSN LICENSE)  http://www.opensource-socialnetwork.org/licence
 * @link      https://www.opensource-socialnetwork.org/
 */


require_once(dirname(dirname(dirname(__FILE__))) . '/system/start.php');

$file_content = file_get_contents(dirname(dirname(__FILE__)) . '/ossn.config.json');
$json = json_decode($file_content, true);

$user['username']   = $json['username'] ;
$user['firstname']  = $json['firstname'];
$user['lastname']   = $json['lastname'] ;
$user['email']      = $json['email']    ;
//$user['reemail']  = $json['reemail'];
$user['password']   = $json['password'] ;
$user['gender']     = $json['gender']   ;

$user['bdd']        = $json['bdd']      ;
$user['bdm']        = $json['bdm']      ;
$user['bdy']        = $json['bdy']      ;

foreach ($user as $field => $value) {
    if (empty($value)) {
        ossn_installation_message(ossn_print('fields:require'), 'fail');
        redirect(REF);
    }
}

//if ($user['reemail'] !== $user['email']) {
//    ossn_installation_message(ossn_print('emai:match:error'), 'fail');
//    redirect(REF);
//}


$user['birthdate'] = "{$user['bdd']}/{$user['bdm']}/{$user['bdy']}";

$add = new OssnUser;
$add->username = $user['username'];
$add->first_name = $user['firstname'];
$add->last_name = $user['lastname'];
$add->email = $user['email'];
$add->password = $user['password'];
$add->gender = $user['gender'];
$add->birthdate = $user['birthdate'];
$add->sendactiviation = false;
$add->usertype = 'admin';
$add->validated = true;

$robot = new OssnUser;
$robot->username = 'smartbot';
$robot->first_name = 'Smart';
$robot->last_name = 'Bot';
$robot->email = 'smartbot@ossn.com';
$robot->password = $user['password'];
$robot->gender = $user['gender'];
$robot->birthdate = $user['birthdate'];
$robot->sendactiviation = false;
$robot->usertype = 'normal';
$robot->validated = true;

$test = new OssnUser;
$test->username = 'testuser';
$test->first_name = 'Test';
$test->last_name = 'User';
$test->email = 'testuser@ossn.com';
$test->password = $user['password'];
$test->gender = $user['gender'];
$test->birthdate = $user['birthdate'];
$test->sendactiviation = false;
$test->usertype = 'normal';
$test->validated = true;

if (!$add->isUsername($user['username'])) {
    ossn_installation_message(ossn_print('username:error'), 'fail');
    redirect(REF);
}
if (!$add->isPassword()) {
    ossn_installation_message(ossn_print('password:error'), 'fail');
    redirect(REF);
}

if ($add->addUser()) {
    $robot->addUser();
    $test->addUser();
    ossn_installation_message(ossn_print('account:created'), 'success');
    redirect('installation?page=installed');
} else {
    ossn_installation_message(ossn_print('account:create:error:admin'), 'fail');
    redirect(REF);
}