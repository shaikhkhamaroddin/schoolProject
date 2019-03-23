<?php
/*
 Author  		: Shaikh Khamaroddin 
 Start Date 	: 9 April 2018
 Last Modified 	: 31 May 2018
 File Name 		: schoolmodel.php 
 Purpose 		: Model for user CRUD, assign case CRUD, sorting,searching operations.			 
*/
    class Schoolmodel extends CI_Model {    
		 function __construct()
		{
		    // Call the Model constructor
		    parent::__construct();
		    $this->load->database();
		}
	
// function to get total record count
	 function totalrecords($where=NULL){
		if(!empty($where))
		{
			$this->db->where($where,NULL,FALSE);
		}
		return $this->db->count_all_results(TBL_USER_CASE);
	   }
// Get all records for list page
		function get_all($limit=NULL,$offset=NULL)                      
		{
		   
			$this->db->select('srno,username,class,hobbies, d.name, gender,a.name AS city, b.name AS state ,c.name AS country');
			$this->db->from(TBL_SCHOOLDATA.' d'); 
			$this->db->join(TBL_CITIES.' a', 'a.id=d.city', 'left');
			$this->db->join(TBL_STATES.' b', 'b.id=d.state', 'left');
			$this->db->join(TBL_COUNTRIES.' c', 'c.id=d.country', 'left');
			$this->db->limit($limit, $offset);
			$query = $this->db->get();
			$data = $query->result();
			return $data;
		}
		
// function to get all cities of selected states and all states of selected country
		function listAll($cid)                      
		{
			$tempst="";
			$statelist = array();
			$citieslist = array();
			$this->db->select('a.name AS country, b.name AS state ,b.id as state_id, c.name as city, c.id as city_id');
			$this->db->from(TBL_COUNTRIES.' a'); 
			$this->db->join(TBL_STATES.' b', 'b.country_id=a.id', 'left');
			$this->db->join(TBL_CITIES.' c', 'c.state_id=b.id', 'right');
			$this->db->where('a.id',$cid);        
			$query = $this->db->get()->result_array();
			
			foreach($query as $q){
			    if($q['state_id']!=$tempst){
				    $statelist[$q['state_id']] = $q['state'];
				    $tempst =$q['state_id'];
			    }
			    $citieslist[$q['city_id']] = $q['city'];
			    
			}			//foreach close
			$data = array(
				    'citieslist' => $citieslist,
					'statelist' => $statelist
					);
			return $data;
		}
	    
//function to insert user record
		function insert_record($data)          
		{
			$this->db->insert(TBL_SCHOOLDATA,$data);
			$insertId = $this->db->insert_id();
		    $this->db->select('srno,usrimage');
		    $this->db->from(TBL_SCHOOLDATA);
		    $this->db->where('srno',$insertId);
			return $this->db->get()->row_array();
		
		}
		
//function to load update page values
		function load_update_page($id)        
		{
			$list = array();
		    $this->db->select('*');
		    $this->db->from(TBL_SCHOOLDATA);
		    $this->db->where('srno',$id);
			return $this->db->get()->row_array();
		}
		
//function to update record in database
		function update_record($id,$data)       
		{
			$this->db->where(TBL_SCHOOLDATA.'.srno',$id);
		    $this->db->update(TBL_SCHOOLDATA, $data);
		}
		
//function to delete user record from list page
		function delete_record($id)             
		{
			$this->db->where(TBL_SCHOOLDATA.'.srno',$id);
			return $this->db->delete(TBL_SCHOOLDATA);
		}
		
// function to get all countries list for add/update page
		function getCountryList()		
		{
		    $list = array();
			$query = $this->db->query('SELECT id, name FROM `countries` ORDER BY `countries`.`name` ASC')->result_array();
			foreach ($query as $record){
		       $list[$record['id']] = $record['name']; 
			}
			$data['countrylist'] = $list;
		    return $data;
		}
		
// function to get all states list based on selected country
		function getStates($id){		
		    $list = array();
		    $query = $this->db->query('SELECT `id`, `name` FROM `states` WHERE `country_id`='.$id)->result_array();
			    foreach ($query as $record){
			       $list[$record['id']] = $record['name']; 
			    }	
			    $data = $list;
			    return $data;
		}
		
// function to get all cities based on selected states
		function getCities($id){		
		    $list = array();
		    $query = $this->db->query('SELECT `id`, `name` FROM `cities` WHERE `state_id`='.$id)->result_array();  
		    foreach ($query as $record){
				$list[$record['id']] = $record['name']; 
		    }	
			return $list;
			    
			     
		}
		
		// function to get city name by id
		//function getc($id){		
		//    $query = $this->db->query('SELECT `name` FROM `cities` WHERE `id`='.$id)->row_array();
		//    return $query;
		//}
		//
		//// get city name by id
		//function gets($id){		
		//    $query = $this->db->query('SELECT `name` FROM `states` WHERE `id`='.$id)->row_array();
		//    return $query;
		//}
		
		
// function to get country name , state name and city name by city id for update operation
		function getLocation($id) 
		{
		    
			$this->db->select('a.name AS city, b.name AS state ,c.name AS country');
			$this->db->from(TBL_CITIES.' a'); 
			$this->db->join(TBL_STATES.' b', 'b.id=a.state_id', 'left');
			$this->db->join(TBL_COUNTRIES.' c', 'c.id=b.country_id', 'left');
			$this->db->where('a.id',$id);        
			$query = $this->db->get();
			
			if($query->num_rows() != 0)
			{
			    return $query->row_array();
			}
			else
			{
			    return false;
			}
		    
		}
		
// function to retrive db saved profile pic
		function checkFileExist($id=0,$file){
			if ($file=='img')
			$file = 'usrimage';
			if ($file=='pdf')
			$file = 'usrpdf';
			if ($file=='excel')
			$file = 'usrexcel';
			$query = $this->db->query('SELECT '.$file.' FROM `schooldata` WHERE `srno`='.$id)->row_array();
		    return $query[$file];
		}
		
		
//function to  check email already exist at Add/Update page
		function checkUsername($username,$id=0){
			$this->db->select('username');
			$this->db->from(TBL_SCHOOLDATA);
		    $this->db->where('username',$username);
			$query = $this->db->where_not_in('srno', $id);
			if($query->get()->num_rows() != 0)
			{
			    return FALSE;
			}else
			{
				return true;
			}
			
		}
		
		// function to get all records for index page
		function getTable()                      
		{
		   
			$this->db->select('srno,name,username,class,country,state,city,DATE_FORMAT(dob,"%d-%m-%Y") as bdate');
			$this->db->from(TBL_SCHOOLDATA); 
			$query = $this->db->get()->result();
			return $query;
		}
		
//function for ordering, filtering and searching in list page,ajax 
		function search($query_string=NULL,$limit=NULL,$offset=NULL,$orderCol='srno',$val='asc',$fromDate=NULL,$toDate=NULL){
	
			$fields = array('d.name'=> $query_string,
							'd.username'=> $query_string,
							'a.name'=>$query_string,
							'b.name'=>$query_string,
							'c.name'=>$query_string,
							'hobbies'=>$query_string,
							'class'=>$query_string,
							'srno'=>$query_string,
							'gender'=>$query_string);		
		
		$this->db->select('srno,d.name,username,class,c.name AS country,b.name AS state ,a.name AS city,DATE_FORMAT(dob,"%d-%m-%Y") as dob,hobbies, gender ');
			$this->db->select('IF(status = 1 , "Active" , "Inactive") as status',FALSE);
			$this->db->from(TBL_SCHOOLDATA.' d'); 
			$this->db->join(TBL_CITIES.' a', 'a.id=d.city', 'left');
			$this->db->join(TBL_STATES.' b', 'b.id=d.state', 'left');
			$this->db->join(TBL_COUNTRIES.' c', 'c.id=d.country', 'left');
			
			if(!empty($query_string))
			{
			$this->db->group_start();		
			$this->db->or_like($fields,$query_string,'both');
			$this->db->group_end();
			}
			if(!empty($fromDate))
			$this->db->where('dob BETWEEN "'. date('Y-m-d', strtotime($fromDate)). '" and "'. date('Y-m-d', strtotime($toDate)).'"');
			
			$this->db->order_by('d.'.$orderCol, $val);
			$this->db->limit($limit,$offset);
			$query = $this->db->get();
			$data = $query->result_array();
			return $data;
		}
		
//function to get user details for tcpdf page
		function getUserDetails($id){	 
			 
			    $this->db->select('srno,s.name,username,class,c.name AS country,b.name AS state ,a.name AS city,DATE_FORMAT(dob,"%d-%m-%Y") as dob,hobbies, gender');
			    $this->db->from(TBL_SCHOOLDATA.' s');
				$this->db->join(TBL_CITIES.' a', 'a.id=s.city', 'left');
				$this->db->join(TBL_STATES.' b', 'b.id=s.state','left');
				$this->db->join(TBL_COUNTRIES.' c','c.id=s.country','left');
			    $this->db->where('srno',$id);
			    return( $this->db->get()->row_array());
			
			
		}
//function to get all uploaded files for zip operation
		function getAllFiles($id)
		{
			$this->db->select('usrimage,usrpdf,usrexcel');
			$this->db->from(TBL_SCHOOLDATA);
			$this->db->where('srno',$id);
			return $this->db->get()->row_array();
		}
//Function to toggle status of user using ajax
		function changeUserStatus($id,$status){
			$status = ($status==1)?0:1;
		$this->db->set('status',$status);	
		$this->db->where('srno',$id);
		$this->db->update(TBL_SCHOOLDATA);
		return $this->basicDetails($id);		
		
		}
//function to get name of the user
		function basicDetails($id){
			$this->db->select('name');
			$this->db->from(TBL_SCHOOLDATA);
			return $this->db->where('srno',$id)->get()->result_array();
			
		}
//function to get the list of active employees for case assign operation
		function getActiveEmployees(){
			$this->db->select('srno,name');
			$this->db->from(TBL_SCHOOLDATA);
			return $this->db->where('status',1)->get()->result_array();
			
		}
// function to save case information into database
		function assignCase($data){
			return $this->db->insert('user_case',$data);
		}
		
//function to get country,state and city with their ids.
		function getCountryStateCity(){
		
			$list = array();
		    $tempst="";
			$statelist = array();
			$citieslist = array();
			$this->db->select('a.name AS country, b.name AS state ,a.id as country_id ,b.id as state_id, c.name as city, c.id as city_id');
			$this->db->from(TBL_COUNTRIES.' a'); 
			$this->db->join(TBL_STATES.' b', 'b.country_id=a.id', 'left');
			$this->db->join(TBL_CITIES.' c', 'c.state_id=b.id', 'right');
			$this->db->where('a.id IN (1,58)',NULL,FALSE);
			$this->db->order_by('a.name,b.name,c.name');
			$query = $this->db->get()->result_array();			
			return $query;
		}
		
//function to get all records of case assign for assign list page
		function getCases(){
			$this->db->select('e.id as id,e.empid as empid,a.name AS country, b.name AS state , c.name as city, d.name,DATE_FORMAT(e.created_at,"%d-%m-%Y") as created_at ,username');
			$this->db->from(TBL_USER_CASE.' e'); 
			$this->db->join(TBL_STATES.' b', 'b.id=e.state', 'left');
			$this->db->join(TBL_CITIES.' c', 'c.id=e.city', 'left');
			$this->db->join(TBL_COUNTRIES.' a', 'a.id=e.country', 'left');
			$this->db->join(TBL_SCHOOLDATA.' d','d.srno=e.empid','left');
			$this->db->group_by('e.empid');
			$this->db->order_by('e.id');
			$query = $this->db->get()->result_array();
			return $query;
			
		}
		
//function to delete record from case assign table
		function assignDelete($id){
			$this->db->where(TBL_USER_CASE.'.empid',$id);
			return $this->db->delete(TBL_USER_CASE);
			
		}
//function to get all assigned records for an employee
		function getAssignedDetails($id){
			$list = array();
			    $this->db->select('*');
			    $this->db->from(TBL_USER_CASE);
			    $this->db->where('empid',$id);
			    return $this->db->get()->result_array();
		}
		
//function to update case assign details
		function updateAssignedDetails($id,$data){
			    $this->db->where(TBL_USER_CASE.'.id',$id);
			    $this->db->update(TBL_USER_CASE, $data);
		    
		}
//function to check any case is assigned to employee 
		function userExist($id){
				$this->db->select('*');
			    $this->db->from(TBL_USER_CASE);
				$query=   $this->db->where('empid',$id);
			   //$query = $this->db->where_not_in('srno', $id);
			   if($query->get()->num_rows() != 0)
			   {
				   return FALSE;
			   }else
			   {
				   return true;
			   }
		}
		
    }	// End of Model 'schoolmodel'
?>