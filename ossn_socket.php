<?php
error_reporting(E_ALL);

/* Allow the script to hang around waiting for connections. */
set_time_limit(0);

/* Turn on implicit output flushing so we see what we're getting
 * as it comes in. */
ob_implicit_flush();

$address = '172.31.6.54';
$port = 10000;

if (($sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)) === false) {
    echo "socket_create() failed: reason: " . socket_strerror(socket_last_error()) . "\n";
}

if (socket_bind($sock, $address, $port) === false) {
    echo "socket_bind() failed: reason: " . socket_strerror(socket_last_error($sock)) . "\n";
}

if (socket_listen($sock, 5) === false) {
    echo "socket_listen() failed: reason: " . socket_strerror(socket_last_error($sock)) . "\n";
}

do {
    if (($msgsock = socket_accept($sock)) === false) {
        echo "socket_accept() failed: reason: " . socket_strerror(socket_last_error($sock)) . "\n";
        //break;
    }
    /* Send instructions. */
    $msg = "\nWelcome to the PHP Test Server. \n" .
        "To quit, type 'quit'. To shut down the server type 'shutdown'.\n";
    socket_write($msgsock, $msg, strlen($msg));

    do {
        if (false === ($buf = socket_read($msgsock, 2048, PHP_NORMAL_READ))) {
        
            echo "socket_read() failed: reason: " . socket_strerror(socket_last_error($msgsock)) . "\n";
            //break 2;
                break;
        }
        if (!$buf = trim($buf)) {
            continue;
        }
        if ($buf == 'quit') {
            break;
        }
        if ($buf == 'shutdown') {
            socket_close($msgsock);
            //break 2;
                break;
        }
        $talkback = "PHP: You said '$buf'.\n";
        //socket_write($msgsock, $talkback, strlen($talkback));
        //echo "$buf\n";

        $param = json_decode($buf,true);
        $uid = query_uid($param['email']);

        robot_send($param['message'],$uid);

    } while (true);
    socket_close($msgsock);
} while (true);

function robot_send($message,$to){

    $url="http://ec2-54-183-248-169.us-west-1.compute.amazonaws.com/action/message/robot_send";

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
}

function query_uid($to_email)
{
    $url="http://ec2-54-183-248-169.us-west-1.compute.amazonaws.com/action/query/get_uid";
    $params = array(
        'email'=> $to_email,
    );
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    //curl_setopt($curl, CURLOPT_COOKIE, $cookie);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($params));

    session_write_close();
    $uid = curl_exec($curl);
    curl_close($curl);
    session_write_close();
    return $uid;
}
socket_close($sock);
?>
