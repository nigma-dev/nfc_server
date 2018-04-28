<?php 

	function readCSV($_filename){
		$_row = array();
		foreach(file($_filename)as $_line){
		 $_row[] = $_line;		
		}
		return $_row;	
	}

	function getSrIndex($_path){
		
		$_user_array = array();
		$_user_array = readCSV($_path);
		$_index = sizeof($_user_array);

		return $_index;
	}

	function isUserExit($_file_dir,$_card_id){
		
		if (!file_exists($_file_dir)) {
			return false;
		}
		$file = fopen($_file_dir,"r");

		while(!feof($file))
		  {
		  	$_temp_array = array();
		  	$_temp_array = fgetcsv($file);

			if ($_temp_array[3]==$_card_id) {
				fclose($file);
				return true;
			}
		  }

		fclose($file);
		return false;
	}

	function insertUser($_file_dir,$_name,$_phone_no,$_card_id,$_start_use_date,$_address){
		$_sr_no; 
		$_file_handle;

		if(!file_exists($_file_dir)){
			$_data[] = array("sr_no","name","phone_no","card_id","start_use","address");
		}	
			$_file_handle = fopen($_file_dir,'a');
			$no = getSrIndex($_file_dir);
			if ($no==0) {
				$_sr_no = 1;
			}else{
				$_sr_no = $no;				
			}


			
			$_data[] = array($_sr_no,$_name,$_phone_no,$_card_id,$_start_use_date,$_address);

			foreach ($_data as $_row) {
				fputcsv($_file_handle,$_row);
			}
			fclose($_file_handle);
			

        return true;

	}

	function getUserInfo($_file_dir,$_card_id){
		
		$file = fopen($_file_dir,"r");

		while(!feof($file))
		  {
		  	$_temp_array = array();
			$_temp_array = fgetcsv($file); 
			  
			if ($_temp_array[3]==$_card_id) {
				fclose($file);
				return $_temp_array;
			}	
		  }

		fclose($file);

		return NULL;
	}

	function createUserMovieList($_create_file){
		if(!touch($_create_file)){return false;}
		$header = array('card_id','movie_id','movie_name','date');
		$file = fopen($_create_file,'w');
		foreach ($header as $row) {
			fputcsv($file,$row);
		} 
		fclose($file);
		return true;
	}
	function insertUserMovieList($_file_path,$_card_id,$_movie_id,$_move_name,$_date){
		
		$_multi_array[][] = array();

		for ($i=0; $i <sizeof($_movie_id) ; $i++) { 

			for ($j=0; $j <=3 ; $j++) { 
				if ($j==0) {
					$_multi_array[$i][$j] = $_card_id; 	
				}
				elseif ($j==1) {
					$_multi_array[$i][$j] = $_movie_id[$i]; 	
				}
				elseif ($j==2) {
					$_multi_array[$i][$j] = $_move_name[$i]; 
				}
				else{
					$_multi_array[$i][$j] = $_date; 	
				}
				
			}
		}

		$_file = fopen($_file_path,'a');
		if (!$_file) {	return false;}

		foreach ($_multi_array as $row ) {
			fputcsv($_file,$row);
		}
		fclose($_file);
		return true;
	}
?>