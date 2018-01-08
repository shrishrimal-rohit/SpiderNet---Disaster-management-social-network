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

$file_content = file_get_contents(dirname(dirname(__FILE__)) . '/ossn.config.json');
$json = json_decode($file_content, true);

$Settings = new OssnInstallation;
$Settings->dbusername($json['dbuser']);
$Settings->dbpassword($json['dbpassword']);
$Settings->dbhost($json['host']);
$Settings->dbname($json['dbname']);
$Settings->weburl($json['url']);
$Settings->socketPort($json['socketport']);
$Settings->server($json['server']);
$Settings->datadir($json['userdata']);
$Settings->setStartupSettings(array(
    'owner_email' => $json['owner_email'],
    'notification_email' => $json['notify_email'],
    'sitename' => $json['site']
));
if(empty($json['owner_email']) || empty($json['notify_email']) || empty($json['site'])){
	    ossn_installation_message(ossn_installation_print('fields:require'), 'fail');
    	$failed = ossn_installation_paths()->url . '?page=settings';
		header("Location: {$failed}");	
		exit;
}
if ($Settings->INSTALL()) {
    $installed = ossn_installation_paths()->url . '?page=account';
    header("Location: {$installed}");
} else {
    ossn_installation_message($Settings->error_mesg, 'fail');
    $failed = ossn_installation_paths()->url . '?page=settings';
    header("Location: {$failed}");
}
