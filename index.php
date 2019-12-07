<?php
	
	require_once('vendor/autoload.php');
	
	use Sudatel\SMS;
	
	$sms = new SMS('xxxx','password','xxxxx');
	
	
	$sms->send('text to be send',['249900000000','249000000']);// send sms for bulk numbers
	// true if message sended , false if not
	
	$sms->getContent();// response body from server
	$sms->getHeaders();// response headers from server
	$sms->getStatusCode();// response status code from server
	
	
	$sms->getBalance(); // check your balance
	
	