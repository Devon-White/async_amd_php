<h1>Async AMD with PHP</h1>

<h2>Prerequisites</h2>
<h3>Running on a ngrok tunnel</h3>
<h5>
<li>SignalWire Number</li>
<li>SignalWire API Token</li>
<li>SignalWire Space Url</li>
<li>Destination number you can call</li>
<li><a href="https://ngrok.com">ngrok Account and API Token - if using for local development</a></li>

<h4>.env File Setup</h3>

````dotenv
TO_NUM='Number you wish to call'

FROM_NUM='Number you will be calling from'

PROJECT_ID='SignalWire Project ID'

AUTH_TOKEN='SignalWire Auth Token'

SPACE_URL='SignalWire Space Url - Example: example.signalwire.com'

URL='ngrok tunnel - Will automatically be set/update if a tunnel is running and api token is provided'

NGROK_API_TOKEN='ngrok api token'
````

`NGROK_API_TOKEN` can be left blank if you plan on using your own web server or if you prefer to hard set the ngrok tunnel in `URL`. Make sure to also comment out the
`check_ngrok_url` function on `line 7` in the `create_call.php` file if you plan on 
doing this!

````php
<?php

require './vendor/autoload.php';
require 'function.php';


//check_ngrok_url(); // you can comment this function out if you don't plan to use Ngrok or rather Hard set the Url in the .env file
$payload = get_info();

$to_num = $payload['to_num'];
$from_num = $payload['from_num'];
$url = $payload['url'];
````

<h2>Getting Started</h2>
<ol>
<li>In your terminal run the command</li>

`php -S localhost:8080 -t public`
<li>Run the next command in your terminal to start your ngrok tunnel - if you are using ngrok</li>

`ngrok http 8080`

<li>Run the create_call.php script</li>

<li>Answer call</li>
</ol>

Once the call is answered, it will listen for feedback while also playing the `wait.mp3` file. 
Once determined if the callee is a `human`, it will update the call with the `human.xml` document, 
otherwise it will update with the `Machine.xml`document.
Both files can be found in the `public` folder

<h3>Human Xml Logic</h3>

```xml
<?xml version="1.0" encoding="UTF-8"?>
<Response>
    <Say>What is a human for 1000 points</Say>
    <Hangup/>
</Response>
```

<h3>Machine Xml Logic</h3>
```xml
<?xml version="1.0" encoding="UTF-8"?>
<Response>
    <Say>What is A Machine for 0 points</Say>
    <Hangup/>
</Response>
```


<h3>AMD Settings</h3>
AMD settings can be adjusted in the `create_call.php` file `lines 21 to 27`

````php
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
````

