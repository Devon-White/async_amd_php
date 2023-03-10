<?php
use SignalWire\LaML\VoiceResponse;

require '../vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $response = new VoiceResponse();

    $response->play('https://s3-us-west-2.amazonaws.com/s.cdpn.io/123941/Yodel_Sound_Effect.mp3', array('loop' => 15));

    echo $response;
}
?>