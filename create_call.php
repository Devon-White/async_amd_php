<?php

require './vendor/autoload.php';
require 'function.php';


check_ngrok_url(); // you can comment this function out if you don't plan to use Ngrok or rather Hard set the Url in the .env file
$payload = get_info();

$to_num = $payload['to_num'];
$from_num = $payload['from_num'];
$url = $payload['url'];


$client = get_sw_client();

$call = $client->calls
    ->create("$to_num", // to
        "$from_num", // from
        array(
            "url" => "$url/play.xml",
            "MachineDetection" => "DetectMessageEnd",
            "MachineDetectionTimeout" => 30,
            "MachineDetectionSilenceTimeout" => 10000,
            "Method" => "POST",
            "AsyncAmd" => "true",
            "AsyncAmdStatusCallback" => "$url/amd.php",
            )
    );

print($call->sid);
?>