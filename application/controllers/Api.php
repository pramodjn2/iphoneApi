<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {


    var $insertDt = '';

    var $mandatoryFields = '';
    var $notFound = '';
    var $recordSave = '';
    var $anError = '';
    var $userId = '';

    public function __construct(){

		parent::__construct();
		//$this->output->enable_profiler(TRUE);	
		$this->insertDt = date("Y-m-d H:i:s");

		$this->mandatoryFields = "Please fill all mandatory fields.";
		$this->notFound = "Not found result";
		$this->recordSave = "Record has been saved successfully";
		$this->anError = "An error has occurred. Please try again.";
	  $this->userId;
  } 
  

	public function index()
	{
		$msg = array('message'=> "This API is no longer available.");
		echo json_encode($msg);
	}
   
 
  /**
   * security check the specified headers parameter
   * @param  array
   * @return json
  **/
  private function security($headers){
   $uidNumber = ''; $uidType = ''; $token = '';
   foreach ($headers as $header => $value) {
     if($header == 'uidNumber'){
       $uidNumber = $value;
     }else if($header == 'uidType'){
       $uidType = $value;
     }else if($header == 'token'){
       $token = $value;
     }

   } 
    
   if(empty($uidNumber) || empty($uidType)){
     $msg = array('status'=> "0",  'error' => __LINE__, 'message'=> 'Please send uid number and mobile type.');
     echo json_encode($msg);
     die;
   } 

   if(!empty($token)){
      $this->tokenCheck($token);
    }
  }
 

  /**
   * session token number check 
   * @param  string
   * @return json
  **/
  private function tokenCheck($token){
   
    if(empty($token)){
     $msg = array('status'=> "0", 'error' => __LINE__, 'message'=> 'Please send token number.');
    }else{
       $where = " where token = '".$token."'";
       $result = $this->Common->select('car_userLoginAccessToken',$where);
       if($result){
        $this->userId = $result[0]['token']; 
        return true;
       }else{
        $msg = array('status'=> "0",  'error' => __LINE__, 'message'=> 'Please send valid token number.');
       }
    }
     echo json_encode($msg);
     die;
  }



  /**
   * Create a new authentication controller instance.
   * @param  array
   * @return json
  **/
  public function login(){
    $headers = apache_request_headers();
    //$this->security($headers );
    //header('Content-type: application/json');
    $input = file_get_contents('php://input');
	if($input){
       $post= json_decode( $input, TRUE );

      // print_r($post); die;

      $blanckArray = array('email' => '','password'=> '');
      $post = array_merge($blanckArray,$post);

      $email    = $post['email'];
      $password = $post['password'];
      if(empty($email) ||  empty($password)){
        $msg = array('status'=> "0", 'error' => __LINE__, 'message'=> $this->mandatoryFields); 
      }else{
       $where = " where email = '".$email."' && password = '".$password."'";
       $result = $this->Common->select('user',$where);
       if($result){
           $msg = array('status'=> "1", 'message'=> "login successfully");
           foreach($result as $val){
               $id = $val['id'];
               
               /* delte old token */
               $this->Common->delete('userLoginAccessToken',$id, 'userId');
               
               /* new token save */
               $token = genrateRandNumber();
               $insertData = array('userId' => $id,
                                   'token' => $id.'_'.$token);
               $this->Common->insert('userLoginAccessToken',$insertData);

               $msg['data'][] = array('userId' => $val['id'],
                                      'name' => $val['name'],
                                      'surName' => $val['surName'],
                                      'email' => $val['email'],
                                      'mobileNo' => $val['mobileNo'],
                                      'latitude' => $val['latitude'],
                                      'longitude' => $val['longitude'],
                                      'userType' => $val['userType'],
                                      'user_img' => base_url().'media/user/'.$val['user_img'],
                                      'token' => $id.'_'.$token
                                      );

          


           }
       }else{
         $msg = array('status'=> "0",  'error' => __LINE__, 'message'=> 'Sorry, incorrect email or password'); 
       }
      }
    }else{
     $msg = array('status'=> "0",  'error' => __LINE__, 'message'=> $this->mandatoryFields); 
    }
       echo json_encode($msg);
  } 
   
  /**
   * registration infomation save.
   * @param  array
   * @return json
  **/

  public function registration(){
    $headers = apache_request_headers();

    $this->security($headers );
    $post = $this->input->post();
    if($post){
     $target_dir = $this->config->item('root_path'); 
       //dd($_FILES);
   $imgName = '';
    if($_FILES){

    $target_file = $target_dir . basename($_FILES["user_img"]["name"]);

     $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

     $imgName = time().'.'.$imageFileType;

      $target_file = $target_dir . $imgName;

      move_uploaded_file($_FILES["user_img"]["tmp_name"], $target_file);

    }  
      
     // $time = time();
     // file_put_contents($root_path.$time.'.png', base64_decode($post['user_img']));

     $post = $this->input->post();
    
      $blanckArray = array("name" => "",
                            'surName' => '',
                            'email' => '',
                            'password' => '',
                            'mobileNo' => '',
                            'latitude' => '',
                            'longitude' => '',
                            'uidNumber' => '',
                            'userType' => '',
                            'uidType' => '',
                            );

      $post = array_merge($blanckArray,$post);

       $where = " where email = '".$post['email']."'"; 
       $result = $this->Common->select('user',$where);
       if(empty($result)){
       $insertData = array('name' => $post['name'],
                            'surName' => $post['surName'],
                            'email' => $post['email'],
                            'password' => $post['password'],
                            'user_img' => $imgName,
                            'mobileNo' => $post['mobileNo'],
                            'latitude' => $post['latitude'],
                            'userType' => $post['userType'],
                            'longitude' => $post['longitude'],
                            'uidNumber' => $post['uidNumber'],
                            'uidType' => $post['uidType']
                            );

      $this->Common->insert('user', $insertData);
      $msg = array('status'=> "1",  'message'=> 'Thank you for registration'); 
    }else{
      $msg = array('status'=> "0",  'error' => __LINE__, 'message'=> 'This email id already exists'); 
    }
    echo json_encode($msg);
   } 
  }
   
  
  

  
  
	function test(){
    $img = 're.png';
    $img = get_user_image($img);
    echo '<pre/>';
    print_r($img);
    die;
  }



}
