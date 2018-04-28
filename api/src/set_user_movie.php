/* @Code by Enigma 
 * Owned by Znet Company
 * [+] script usage 
        this script is used to insert data to our database when customer is came and copy thie movie
        form our Znet Data Centre.this script will record all movie that user has been taken;
    @method POST METHOD
    @Content-type: application/json
    @params [card_id],[movie_id[]],[movie_name[]],[current_date]        

*/
<?php 
    include('../lib/init.inc.php');
	header('Content-Type: application/json');
    header('Connection: close');
    
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
    
    if ( !isset($_DECODED['card_id']) or !isset($_DECODED['movie_id'])
		 or !isset($_DECODED['movie_name']) or !isset($_DECODED['current_date'])) 
	{
		die(responseToClient(404,'invalid argument !',false));
    }
    
    $_card_id = $_DECODED['card_id'];
    $_movie_name = array();
    $_movie_name = json_decode($_DECODED['movie_name'],true);
    $_movie_id = array();
    $_movie_id = json_decode($_DECODED['movie_id'],true);
    $_date = $_DECODED['current_date'];
    
    if(!insertUserMovieList('../res/users_movie/'.$_card_id.'.csv',$_card_id,$_movie_id,$_movie_name,$_date))
    {
        die(responseToClient(504,'can\'t added to db',false));
    }

    echo responseToClient(200,'add to database !',true);

    function responseToClient($_status,$_message,$_success){
		$_response = array(
			'status'=>$_status,
			'message'=>	$_message,
            'success'=> $_success,            
		);
		return json_encode($_response);
	}
    
?>