<?php
	include('../lib/init.inc.php');
	header('Content-Type: application/json');
	header('Connection: close');

	$_user_db_csv_path = '../res/user_db.csv';
	$_user_movie_list_path = '../res/users_movie/';

	$_token = "123";
	$_temp_token = "";

	$_response = array();

	$_request_method = trim($_SERVER['REQUEST_METHOD']);

	if ($_request_method != 'POST') {
		die(responseToClient(404,'invalid request method!',false));
	}

	$_contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

	if ($_contentType==''||$_contentType!='application/json') {
		die(responseToClient(404,'Content-Type =>'.$_contentType,false));
	}
	
	$_content = trim(file_get_contents("php://input"));
	
	$_DECODED = json_decode($_content, true);

	if(is_array($_DECODED)==false){
		die(responseToClient(200,'invalid',true));
	}

	if (!isset($_DECODED['token'])) {
		die(responseToClient(404,'access defined !',false));
	}

	$_temp_token = $_DECODED['token'];

	if ($_token!=$_temp_token) {
		die(responseToClient(404,'invalid token !',false));
	}

	if ( !isset($_DECODED['username']) or !isset($_DECODED['phone_no']) or !isset($_DECODED['address']) or 
		!isset($_DECODED['card_id']) or !isset($_DECODED['current_date'])) 
	{
		die(responseToClient(404,'invalid argument !',false));
	}

	$_username = $_DECODED['username'];
	$_phone_no = $_DECODED['phone_no'];
	$_address = $_DECODED['address'];
	$_card_id = $_DECODED['card_id'];
	$_current_date = $_DECODED['current_date'];

	$_user_is_exist = isUserExit($_user_db_csv_path,$_card_id);

	if ($_user_is_exist) {
		die(responseToClient(200,'user already exists !',false));
	}

	$_isSucess = insertUser($_user_db_csv_path,$_username,$_phone_no,$_card_id,$_current_date,$_address)?true:false;

	if(!$_isSucess){
		die(responseToClient(505,'insert new user error',false));
	}

	createUserMovieList($_user_movie_list_path.$_card_id.'.csv');

	
	echo responseToClient(200,'user added to database'.$_user_is_exist,true);

	function responseToClient($_status,$_message,$_success){
		$_response = array(
			'status'=>$_status,
			'message'=>	$_message,
			'success'=> $_success
		);
		return json_encode($_response);
	}

	
?>