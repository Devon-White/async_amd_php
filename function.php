<?php
use GuzzleHttp\Client as guzzle;
use GuzzleHttp\Psr7\Request;
use SignalWire\Rest\Client;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

function get_info(): array
{


    $projectid = $_ENV['PROJECT_ID'];
    $auth_token = $_ENV['AUTH_TOKEN'];
    $space_url = $_ENV['SPACE_URL'];
    $to_num = $_ENV['TO_NUM'];
    $from_num = $_ENV['FROM_NUM'];
    $url = $_ENV['URL'];
    return array(
        "projectid" => $projectid,
        "auth_token" => $auth_token,
        "space_url" => $space_url,
        "to_num" => $to_num,
        "from_num" => $from_num,
        "url" => $url

    );
}

function get_ngrok_url() : array
{
    $auth = $_ENV['NGROK_API_TOKEN'];
    $client = new guzzle();
    $headers = [
        'Authorization' => "Bearer $auth",
        'Ngrok-Version' => '2'
    ];
    $request = new Request('GET', 'https://api.ngrok.com/tunnels', $headers);
    $res = $client->sendAsync($request)->wait();
    $test = $res->getBody();
    $decoded_json = json_decode($test, true);
    $tunnels = $decoded_json['tunnels'];
    $url = $tunnels[0]['public_url'];
    return array(
        "url" => $url
    );
}



function check_ngrok_url(): void
{
    $url = $_ENV['URL'];
    if ($url != get_ngrok_url()['url']) {

            // Read the contents of the .env file
        $envContents = file_get_contents('.env');

// Make the changes to the contents as needed
    $envContents = str_replace($url, get_ngrok_url()['url'], $envContents);

// Write the updated contents back to the .env file
    file_put_contents('.env', $envContents);
}
}

function get_sw_client(): Client
{
    $projectid = $_ENV['PROJECT_ID'];
    $auth_token = $_ENV['AUTH_TOKEN'];
    $space_url = $_ENV['SPACE_URL'];
    $client = new Client($projectid, $auth_token, array("signalwireSpaceUrl" => $space_url));
    return $client;

}
