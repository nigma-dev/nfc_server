<?php 
	include('../lib/init.inc.php');
	$_token = '123';

	$_tmp_token = '';

	$_card_id = ''; 

	if (!isset($_GET['token'])) {
		die('access denied !');
	}

	$_tmp_token = $_GET['token'];

	if (@$_token != $_tmp_token) {
		die('invalid token !');	
	}

	if (!isset($_GET['card_id'])) {
		die('invalid argument !');	
	}

	$_card_id = $_GET['card_id'];

	$service_port = 9090;

	$address = getDeviceIP();

	echo '<br>'.$address.'<br>';

	$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

	if ($socket === false) {
	    die("socket_create() failed: " . socket_strerror(socket_last_error()) . "\n");
	} 

	$result = socket_connect($socket, $address, $service_port);

	if ($result === false) {
	    die("socket_connect() failed." . socket_strerror(socket_last_error($socket)) . "\n");
	} 	

	$in = $_card_id."\r\n";
	$out = '';

	echo "<br>Sending HTTP HEAD request...";
	socket_write($socket, $in, strlen($in));

	echo "<br>Reading response:\n\n";
	while ($out = socket_read($socket, 1024)) {
	    echo $out;
	}

	echo "<br>Closing socket...";
	socket_close($socket);
	echo "OK.\n\n";	

?>