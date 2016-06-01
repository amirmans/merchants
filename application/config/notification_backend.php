<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
ini_set('display_errors', 1);
//error_reporting(E_ALL);

include '../include/dbmanager.inc';

function APN_NotifyCustomers($nickName, $message, $sender, $businessID, $imageName, $typeName, $dateTimeSent) {
//     $apnsHost = 'gateway.sandbox.push.apple.com';
    //$apnsHost = 'gateway.push.apple.com';
    $apnsHost = 'gateway.sandbox.push.apple.com';
    $apnsPort = 2195;
    //$apnsFeedbackHost = 'feedback.sandbox.push.apple.com';
    //$apnsFeedbackPort = 2196;
    $apnsCert = 'tapin_dev.pem';


    // device token is an associative Array
    try {
        $notificationTypeArr = getAllFieldsWithName("notification_type", 'notification_type_id', " notification_type_name= \"$typeName\"");
        $notificationType = $notificationTypeArr[0]['notification_type_id'];

        $deviceTokens = getAllFieldsWithName("consumer_profile", 'device_token', " nickName = \"$nickName\"");
        $deviceToken = $deviceTokens[0]['device_token'];
        if (strlen($deviceToken) <> 64)
            throw new Exception('Device Token is not correct - is the customer name right?');
    } catch (Exception $e) {
        echo 'Error - Invalid customer name.  Please try again - actuall error message: ';
        exit();
    }

    if (strlen($message) < 5) {
        echo 'Error - Too short of a message!' . PHP_EOL;
        exit();
    }

    // $passphrase = 'id0ntknow';
    $passphrase = 'Tapin';
    $ctx = stream_context_create();
    stream_context_set_option($ctx, 'ssl', 'local_cert', $apnsCert);
    stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

    // Open a connection to the APNS server
    $err = 0;
    $errstr = "";
    $fp = stream_socket_client(
            'ssl://' . $apnsHost . ':' . $apnsPort, $err,
            //        'ssl://gateway.sandbox.push.apple.com:2195', $err,
            $errstr, 60, STREAM_CLIENT_CONNECT, $ctx);
    if (!$fp) {
        exit("Failed to connect: $err $errstr" . PHP_EOL);
    }
    echo 'Connected to APNS' . PHP_EOL;

    // Create the payload body
    $body['aps'] = array(
        'content-available' => 1,
        'alert' => $message,
        'sender' => $sender,
        'business_id' => $businessID,
        'imageName' => $imageName,
        'timeSent' => $dateTimeSent,
        'status' => 1,
        'notification_type ' => $notificationType,
        "badge" => 1,
        'sound' => 'newMessage.wav'
    );

    // Encode the payload as JSON
    $payload = json_encode($body);

    // Build the binary notification
    //   $msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
    $msg = chr(0) . chr(0) . chr(32) . pack('H*', str_replace(' ', '', $deviceToken)) . chr(0) . chr(strlen($payload))
            . $payload;
    if (strlen($msg) > 256) {
        echo 'Error - Too many charaters in your message.  Please reduce it.' . PHP_EOL;
        exit();
    }
    // Send it to the server
    $result = fwrite($fp, $msg, strlen($msg));

    if (!$result) {
        echo 'Message not delivered' . PHP_EOL;
    } else {
        echo 'Message successfully delivered' . PHP_EOL;
    }
    // Close the connection to the server
    fclose($fp);

    // get feedback from apns
}

$nickName = filter_input(INPUT_POST, 'nickName');
$message = filter_input(INPUT_POST, 'notificationMessage');
$sender = filter_input(INPUT_POST, 'sender');
$businessID = intval(filter_input(INPUT_POST, 'businessID'));
$imageName = filter_input(INPUT_POST, 'imageName');
$typeName = filter_input(INPUT_POST, 'type');
$dateTimeSent = date('Y-m-d H:i:s');
APN_NotifyCustomers($nickName, $message, $sender, $businessID, $imageName, $typeName, $dateTimeSent);

