<?php
use SignalWire\Rest\Client;



require '../vendor/autoload.php';

$projectid = "b08dacad-2f6c-4de1-93d6-cc732e0c69c5";
$auth_token = "PT16d2254f1cf1be0766881a2043afe8ef9e2fc8e8f739750b";
$space_url = "devspace.signalwire.com";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $client = new Client($projectid, $auth_token, array("signalwireSpaceUrl" => $space_url));
    // Get the form data
    $sid = $_REQUEST['CallSid'];
    $answered_by = $_REQUEST['AnsweredBy'];


    if ($answered_by == "human") {
        // Update call with new instructions
        $call = $client->calls($sid)
            ->update([
                    "method" => "POST",
                    "url" => "https://devspace.signalwire.com/laml-bins/73336917-6cd8-4df4-ae58-b13904271c2a"

            ]);
    }
    if ($answered_by == "machine_start") {
        $call = $client->calls($sid)
            ->update([
                    "method" => "POST",
                    "url" => "https://devspace.signalwire.com/laml-bins/dd5b11ae-cd46-4ae8-90df-632ac68afb98"

            ]);
    }
}
?>
