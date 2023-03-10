<?php
use SignalWire\Rest\Client;

require './vendor/autoload.php';

$projectid = "b08dacad-2f6c-4de1-93d6-cc732e0c69c5";
$auth_token = "PT16d2254f1cf1be0766881a2043afe8ef9e2fc8e8f739750b";
$space_url = "devspace.signalwire.com";
$url = "https://4669-2600-4040-12eb-b400-50c4-8063-22ac-8d3f.ngrok.io";

$client = new Client($projectid, $auth_token, array("signalwireSpaceUrl" => $space_url));

$call = $client->calls
    ->create("+18048390497", // to
        "+12078045546", // from
        array(
            "url" => "$url/xml.php",
            "MachineDetection" => "Enable",
            "Method" => "POST",
            "AsyncAmd" => "true",
            "AsyncAmdStatusCallback" => "$url/amd.php",
            )
    );

print($call->sid);
?>