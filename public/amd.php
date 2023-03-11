<?php

require '../vendor/autoload.php';

require '../function.php';




if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $payload = get_info();
    $to_num = $payload['to_num'];
    $from_num = $payload['from_num'];
    $url = $payload['url'];

    // Get the form data
    $sid = $_REQUEST['CallSid'];
    $answered_by = $_REQUEST['AnsweredBy'];

    $client = get_sw_client();
    if ($answered_by == "human") {
        // Update call with new instructions
        $call = $client->calls($sid)
            ->update([
                    "method" => "POST",
                    "url" => "$url/human.xml"

            ]);
    }
    else {
        $call = $client->calls($sid)
            ->update([
                    "method" => "POST",
                    "url" => "$url/Machine.xml"

            ]);
        }}
?>
