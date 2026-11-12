<?php 
header('Access-Control-Allow-Origin: *');
 session_start();
	error_reporting(0);
	
date_default_timezone_set('Asia/Kolkata');	

	$final_dest='../temp';
	if(is_dir( $final_dest)==FALSE){
		mkdir($final_dest,0777,TRUE);
	}
	
	 $sm_img2=$_FILES['importfile']['name'];
      $sm_file_tmp2 = $_FILES['importfile']['tmp_name'];
	  
		$sm_img2=str_replace(" ","_",$sm_img2);
		$filename2=date('ymdhmi').'_'.$sm_img2;

	if(move_uploaded_file($sm_file_tmp2,$final_dest.'/'.$filename2)){
		$_SESSION['sm_img2']=$filename2;
	}
	
	$sm_img=$_FILES['photo']['name'];
      $sm_file_tmp = $_FILES['photo']['tmp_name'];
		$sm_img=str_replace(" ","_",$sm_img);
		$filename=date('ymdhmi').'_'.$sm_img;
			
	if(move_uploaded_file($sm_file_tmp,$final_dest.'/'.$filename)){
		$_SESSION['sm_img']=$filename;
	}
	
	
	$json_data = array("op2"=>$filename2,"op"=>$filename);


echo json_encode($json_data); 
	

?>