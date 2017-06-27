<?php
  
  function dd($post){
   echo "<pre>";
   print_r($post);
   die();
  }

/**
*	Genrate rand number
**/	
function genrateRandNumber(){
	return  random_string('alnum',20);
}

/**
	* User profile image 
**/
function get_user_image($image){
	$CI = & get_instance();
	$url = $CI->config->item('root_path'); 
	$filename="$url/$image";
	if(!empty($image)){
			if(@getimagesize($filename)){
			  return $image ;
			}else{
			  return 'default.png';
			}
	}else{
	   return 'default.png';
	}
}

function safe_b64encode($string) {
 
        $data = base64_encode($string);
        $data = str_replace(array('+','/','='),array('-','_',''),$data);
        return $data;
}
 
function safe_b64decode($string) {
        $data = str_replace(array('-','_'),array('+','/'),$string);
        $mod4 = strlen($data) % 4;
        if ($mod4) {
            $data .= substr('====', $mod4);
        }
        return base64_decode($data);
}

/**
* User login check
**/
function check_user_login(){
	$CI = & get_instance();
	$user_id = $CI->session->userdata('user_id');
	if($user_id ==''){
		redirect(base_url('login'), 'refresh');
	}else{
		return $user_id;
	}
}


function reverseGeocoding($address){
  

  //$address = urlencode($address);
  $request_url = "http://maps.googleapis.com/maps/api/geocode/xml?latlng=".$address."&sensor=true";
  $xml = simplexml_load_file($request_url);
  $status = $xml->status;
  if ($status=="OK") {
      $address = $xml->result->formatted_address;
   
   return $address;
  }
  return true;
}


?>