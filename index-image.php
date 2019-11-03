<?php
require_once('./vendor/autoload.php');

//Namespace
use \LINE\LINEBot\HTTPClient\CurlHTTPClient;
use \LINE\LINEBot;
use \LINE\LINEBot\MessageBuilder\TextMessageBuilder;

$channel_token = 'YtEtuzPQlNrrekfMoTVSUQcAnn4jPV9fVBmZNl3MX74ZS37mYD44//Z7E2WDMw1aBQM9C9Oz7jg6t994pinTkk7GVOaXfm8Ea86RgLGBvya4G1p6lPKF41Gdnpy5vhb6M0rsIeM5zRr5jgltbLBzFwdB04t89/1O/w1cDnyilFU=
';
$channel_secret ='881a884de09df2e46ec2bfe33556aef2';

//Get message from Line API
$content = file_get_contents('php://input');
$events = json_decode($content, true);

if(!is_null($events['events'])){

	//Loop through each event
	foreach($events['events']as $event){

		//Line API send a lot of event type, we interested in message only
		if($event['type'] == 'message'){

			//Get replyToken
			$replyToken=$event['replyToken'];

			switch ($event['message']['type']) {

				case 'image':

					$messageID=$event['message']['id'];
					$respMessage='Hello, your image ID is '.$messageID;

					break;

				default:

					$respMessage='Please send image only';

					break;
			}

			$httpClient = new CurlHTTPClient($channel_token);
			$bot = new LINEBot($httpClient, array('channelSecret'=>$channel_secret));

			$textMessageBuilder = new TextMessageBuilder($respMessage);
			$response = $bot->replyMessage($replyToken, $TextMessageBuilder);
		}
	}
}

echo "OK";