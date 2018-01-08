<?php
/**
 * Open Source Social Network
 *
 * @package Open Source Social Network
 * @author    Open Social Website Core Team <info@softlab24.com>
 * @copyright 2014-2017 SOFTLAB24 LIMITED
 * @license   Open Source Social Network License (OSSN LICENSE)  http://www.opensource-socialnetwork.org/licence
 * @link      https://www.opensource-socialnetwork.org/
 */

$send = new OssnMessages;
$to_email = input('email');
$message = input('message');
$to = input('to');
if($from==ossn_robot_uid()->guid)
{
    robot_send($message,1);
    render_view($message);
}
else if($to==ossn_robot_uid()->guid)
{
    // To do: $to should be an email address
    //$to_email = $message;
    send_to_socket($from, $to_email, $message);
    render_view($message);
}
else if ($send->send(ossn_loggedin_user()->guid, $to, $message))
{
    render_view($message);
}
else
{
    echo 0;
}

//messages only at some points #470
// don't mess with system ajax requests
exit;

function robot_send($message,$to){
    global $Ossn;
    $url=$Ossn->url . "action/message/robot_send";

    //$ossn_ts = time();
    //$ossn_token = ossn_generate_action_token_robot($ossn_ts);
    $params = array(
        'message'=> $message, //'TEST' . $datestr,
        //'ossn_ts'=> $ossn_ts, //'1510628890',
        //'ossn_token'=> $ossn_token, //'ecef7bdfbe3a429316bba0a492f6a988',
        'to'=> $to,
    );

    //$cookie='PHPSESSID=' . $_COOKIE['PHPSESSID'];

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    //curl_setopt($curl, CURLOPT_COOKIE, $cookie);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($params));

    session_write_close();
    curl_exec($curl);
    curl_close($curl);
    session_write_close();
    exit;
}

function send_to_socket($from, $to_email, $message)
{
    global $Ossn;
    error_reporting(E_ALL);

    //echo "<h2>TCP/IP Connection</h2>\n";

    /* Get the port for the WWW service. */
    $service_port = $Ossn->socketPort;//getservbyname('www', 'tcp');

    /* Get the IP address for the target host. */
    $address = gethostbyname($Ossn->server);
    //$address = '127.0.0.1';

    /* Create a TCP/IP socket. */
    $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
    if ($socket === false) {
        echo "socket_create() failed: reason: " . socket_strerror(socket_last_error()) . "\n";
    } else {
        //echo "OK.\n";
    }

    //echo "Attempting to connect to '$address' on port '$service_port'...";
    $result = socket_connect($socket, $address, $service_port);
    if ($result === false) {
        echo "socket_connect() failed.\nReason: ($result) " . socket_strerror(socket_last_error($socket)) . "\n";
    } else {
        //echo "OK.\n";
    }

//    $in = "HEAD / HTTP/1.1\r\n";
//    $in .= "Host: 127.0.0.1\r\n";
//    $in .= "Connection: Close\r\n\r\n";
//    $out = '';

    $param['email']=$to_email;
    $param['message']=$message;

    $json = json_encode($param);
    $json .= "\r\n";
    //echo "Sending HTTP HEAD request...";
    socket_write($socket, $json, strlen($json));
    //echo "OK.\n";

//    echo "Reading response:\n\n";
//    while ($out = socket_read($socket, 2048)) {
//        echo $out;
//    }

    //echo "Closing socket...";
    socket_close($socket);
    //echo "OK.\n\n";
}

function render_view($message)
{
    $user = ossn_user_by_guid(ossn_loggedin_user()->guid);
    $message = ossn_restore_new_lines($message);

    $params['user'] = $user;
    $params['message'] = $message;
    echo ossn_plugin_view('messages/templates/message-send', $params);
}