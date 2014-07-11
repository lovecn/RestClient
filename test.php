<?php
error_reporting(0);

echo json_encode(array(
		'text' => 'this is test',
		'method' => $_SERVER['REQUEST_METHOD'],
        'content_type' => $_SERVER['CONTENT_TYPE'],
        'data' => json_decode(file_get_contents('php://input'), true)
	));
