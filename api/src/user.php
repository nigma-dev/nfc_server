<?php
    include('../lib/init.inc.php');
    include('../lib/token.php');
	header('Content-Type: application/json');
    header('Connection: close');

	$_user_db_csv_path = '../res/user_db.csv';
	$_user_movie_list_path = '../res/users_movie/';

	$_response = array();

    $_request_method = trim($_SERVER['REQUEST_METHOD']);

    $_contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

	if ( $_request_method != 'POST' || $_contentType!='application/json') {
		die(responseToClient(404,'invalid !',false));
	}

	$_content = trim(file_get_contents("php://input"));
	
	$_DECODED = json_decode($_content, true);

    $_card_id = $_DECODED['card_id'];
	$_token = $_DECODED['token'];

    if ($_token!=authenticaion_token) {
        die(responseToClient(404,'access denied !',false));
    }

    $_user_is_exist = isUserExit($_user_db_csv_path,$_card_id);
    
    if (!$_user_is_exist) {
         die(responseToClient(202,'user not register',true));
    }
    $_data_array = array();

	$_data_array = getUserInfo($_user_db_csv_path,$_card_id);
	
	$_user_info = array('name' => $_data_array[1],
						'phone_no'=> $_data_array[2],
						'card_id'=> $_data_array[3],
						'start_use_date'=> $_data_array[4],
						'address'=>$_data_array[5]
						);

	$_response = array('status' =>200,
						'data'=>$_user_info,
						'success'=>true
					);					
	echo json_encode($_response);

    function responseToClient($_status,$_message,$_success){
		$_response = array(
			'status'=>$_status,
			'message'=>	$_message,
			'success'=> $_success
		);
		return json_encode($_response);
	}
?>