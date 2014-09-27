<?php

require 'RestClient.php';


$client = new RestClient();

$base_url = 'http://localhost/RestClient/';

//$client->debug = TRUE;
switch($_GET['method'])
{
    case 'post' :
        $rs = $client->post($base_url . 'test.php', array('test' => '测试'));
        break;
    case 'delete' :
        $rs = $client->delete($base_url . 'test.php', array('test' => '测试'));
        break;
    case 'put' :
        $rs = $client->put($base_url . 'test.php', array('test' => '测试'));
        break;
    case 'patch' :
        $rs = $client->patch($base_url . 'test.php', array('test' => '测试'));
        break;
    default :
        $rs = $client->get($base_url . 'test.php', array('test' => '测试'));
        break;
    
    
}

//测试
print_r($rs);