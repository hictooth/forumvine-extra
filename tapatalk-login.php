<?php

include_once __DIR__ . "/vendor/autoload.php";
PhpXmlRpc\Autoloader::register();


function checkTapatalkLogin($username, $password) {

    $client = new PhpXmlRpc\Client('https://www.tapatalk.com/groups/berksforumvine/mobiquo/mobiquo.php');

    // setup the request
    $encoder = new PhpXmlRpc\Encoder();
    $request = new PhpXmlRpc\Request('login', array(
        $encoder->encode($username),
        $encoder->encode($password)
    ));

    // make the request and get response
    $response = $client->send($request);

    if ($response->faultCode()) {
        return false;
    }

    $string = $response->value()->structmem("result")->serialize();
    $xml = simplexml_load_string($string);
    $result = $xml->boolean;

    if ($result == 1) {
        return true;
    }

    return false;
}

?>
