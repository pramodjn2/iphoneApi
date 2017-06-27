<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Common extends CI_Model {


  	/* updating data in datebase */
  	public function update($table,$data,$where)
	{
		if(is_array($where)){
			foreach ($where as $key => $value){
			  $this->db->where($key, $value);
			}
		} 
		$this->db->update($table, $this->db->escape_str($data));
		return true;
	}

	/* insert data in datebase */
	public function insert($table,$data){
		$query = $this->db->insert($table, $data); 
		$id = $this->db->insert_id();
		return $id;
	}

	/* delete data in datebase */
	public function delete($table,$id,$col = 'id'){
		$this->db->where($col, $id);
		$query = $this->db->delete($table); 
		return $query;
	}


	/* select query */
    function select($table, $where ='',$coloumn = '*'){
        $sql = "SELECT $coloumn FROM $table";
		if(!empty($where)){
		   $sql .= " $where";
		}
		$query = $this->db->query($sql);
        if($query->num_rows()>0){
            return $query->result_array();
        }else{
            return false;
        }
    }
    

   /* user infomation and  user contact infomation get */
    function userContactInfomation($userId){

	$this->db->select('*',false);
	$this->db->from('user u');
	$this->db->where('u.status', 'Active');
	$this->db->where('u.id', $userId); 
	$query = $this->db->get();	
	    if($query->num_rows()>0){
	        return $query->result_array();
	    }else{
	        return false;
	    }
    }


     /* resucue note enformation */
    function getActivityInfomation($id){

    $this->db->select('ar.*,u.user_img, u.name, u.surName, u.mobileNo, u.address',false);
    $this->db->from('userActivityRescue ar');
    $this->db->join('userActivity ua', 'ua.id = ar.activityId', 'LEFT');
    $this->db->join('user u', 'u.id = ua.userId', 'LEFT');
    $this->db->where('ar.id', $id); 
    $query = $this->db->get();    
        if($query->num_rows()>0){
            return $query->result_array();
        }else{
            return false;
        }
    }

 /* resucue information */
    function getRescueInfomation(){

    $this->db->select('ar.*,u.user_img,u.name, u.surName, u.mobileNo, u.address',false);
    $this->db->from('userActivityRescue ar');
    $this->db->join('userActivity ua', 'ua.id = ar.activityId', 'LEFT');
    $this->db->join('user u', 'u.id = ua.userId', 'LEFT');
    $this->db->where('ar.status', 'open'); 
    $this->db->order_by("ar.createDt", "DESC");
    $query = $this->db->get();    
        if($query->num_rows()>0){
            return $query->result_array();
        }else{
            return false;
        }
    }
  
  /* get user activity information */
    function getUserActivity($userId){

    $this->db->select('a.*,u.name, u.surName, u.mobileNo, u.address',false);
    $this->db->from('userActivity a');
    $this->db->join('user u', 'u.id = a.userId', 'LEFT');
    $this->db->where('a.userId', $userId); 
    $this->db->order_by("createDt", "DESC");

    //ORDER BY `userActivity`.`createDt` DESC
    $query = $this->db->get();    
        if($query->num_rows()>0){
            return $query->result_array();
        }else{
            return false;
        }
    }


    function selectgetAllInfo($id){

       // $sql = "SELECT $coloumn FROM $table";
  $sql = "SELECT b.*,r.name as relName FROM basicInfo as b left join relationShip as r on b.relationShip = r.lavel where b.relationShip = $id ORDER BY b.id ASC";

		

		$query = $this->db->query($sql);

        if($query->num_rows()>0){

            return $query->result_array();

        }else{

            return false;

        }

    }

	

	

    

	function count($table, $where =''){

        $sql = "SELECT COUNT(*) FROM $table";

		if(!empty($where)){

		   $sql .= " $where";

		}

		$query = $this->db->query($sql);

       

		if($query->num_rows()> 0){

			return (int)$query->row(0)->{'COUNT(*)'};	

        }else{

            return 0;

        }

    }

	

	
	
	

	
	
	function property_info_get($property_id){
		if(empty($property_id)){ return false;}
		 $this->db->select('p.user_id,p.property_id,p.property_name, p.address, p.country, p.zipcode, p.prices,p.bedrooms,p.auction_status,pc.categoryName,pty.typeName,pimg.image_name,u.firstName,u.lastName,u.email,u.profile_image',false);


	$this->db->from('property p');
	$this->db->join('user u', 'u.user_id = p.user_id', 'LEFT');
	$this->db->join('property_category pc', 'pc.property_category_id = p.property_category', 'LEFT');
	$this->db->join('property_types pty', 'pty.property_types_id = p.property_type', 'LEFT');
	$this->db->join('property_image pimg', 'pimg.property_id = p.property_id', 'LEFT');
    $this->db->where('p.property_id', $property_id); 
    $this->db->where('p.status', 'Active');
	$this->db->where('p.property_availability', 'available');
	$this->db->group_by("p.property_id");
	$query = $this->db->get();
	if($query->num_rows()>0){
		$result =  $query->result_array();
		 return  $result;
	}else{ 
	   return false;
	}
		
		}

}



