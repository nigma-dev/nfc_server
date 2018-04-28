<?php
    require "../lib/ip_io_lib.php";

    header('Content-Type: application/json');
    header('Connection: close');
    
    @$_request_method = isset($_SERVER["REQUEST_METHOD"])?$_SERVER["REQUEST_METHOD"]:"";

    if ($_request_method!="POST") {

       die(ServerResponse(404,"invalid request method",false));
       
    }

    $_content = trim(file_get_contents("php://input"));
	
    $_DEC = json_decode($_content, true);

    $_ip = $_DEC['ip'];

    if ($_ip==null or $_ip=="") {
        die(ServerResponse(404,"invalid argument",false));
    }

    setDeviceIP($_ip);
    ServerResponse(200,'ip address register successfully',true);
    
    function ServerResponse($_status_code,$_message,$_error){
        $_data = array('status' => $_status_code,
                                'message'=>$_message,
                                'success' => $_error
                                );
            $_response = trim(json_encode($_data));

         echo $_response;  
    }


?>