<?php 

	$_file_dir = dirname(__DIR__).'/res/';

	$_file_name = 'device_ip.txt';
	
	$_device_ip ='';

	function getDeviceIP(){
		global $_file_name,$_device_ip,$_file_dir;

		$_file = fopen($_file_dir.$_file_name, 'r') or die('<br>file could not open !<br>');

		$_device_ip = fread($_file,filesize($_file_dir.$_file_name));

		fclose($_file);

		return $_device_ip;
	}


	function setDeviceIP($_ip_){
		
		global $_file_name,$_file_dir;

		$_file_ = fopen($_file_dir.$_file_name,'w') or die('<br>file could not open !<br>');

		fwrite($_file_,$_ip_);

		fclose($_file_);
	}
?>