<?php if (!defined('BASEPATH')) exit('No direct script access allowed.');

/* nextSIS person controller
 *
 * PURPOSE 
 * This is the controller which handles the functionality related to people stored by the system.
 * 
 * LICENCE 
 * This file is part of nextSIS.
 * 
 * nextSIS is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as
 * published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
 * 
 * nextSIS is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License along with nextSIS. If not, see
 * <http://www.gnu.org/licenses/>.
 * 
 * Copyright 2012 http://nextsis.org
 */

session_start();

class Person extends CI_Controller
{


	var $viewdata = null;



	function _remap($method, $params = array()){
    	if (method_exists($this, $method))
    	{
        	return call_user_func_array(array($this, $method), $params);
    	}else{
        	$this->index($method);
        }
	}

	function __construct()
	{
		parent::__construct();
		$this->load->model('person_model');
		$this->load->model('schoolclass_model');
		$this->lang->load('person');

		$session_data = $this->session->userdata('logged_in');

		$this->viewdata['username'] 		= $session_data['username'];
		$this->viewdata['school_id'] 		= $session_data['currentschoolid'];
		$this->viewdata['currentsyear'] 	= $session_data['currentsyear'];
		$this->viewdata['defaultschoolid']  = $session_data['defaultschoolid'];
		$this->viewdata['id']  				= $session_data['id'];
		$this->viewdata['nav'] 				= $this->navigation->load('people');
		
		$this->breadcrumbcomponent->add('People', '/person');

		
		$this->sidemenu = array
		(
			0 => 	array(
				'text'		=> 	'All People',	
				'link'		=> 	base_url() . 'person',
				'show_condition'=>	1,
				'icon-class'=>	'icon-list-alt',
				'parent'	=>	0
			),
			3 => 	array(
				'text'		=> 	'List Students',	
				'link'		=> 	base_url().'person/3',
				'show_condition'=>	1,
				'icon-class'=>	'icon-home',
				'parent'	=>	0
			),
			2 => 	array(
				'text'		=> 	'List Teachers',	
				'link'		=> 	base_url() . 'person/2',
				'show_condition'=>	1,
				'icon-class'=>	'icon-user',
				'parent'	=>	0
			),							
			4 => 	array(
				'text'		=> 	'List Parents',	
				'link'		=> 	base_url() . 'person/4',
				'show_condition'=>	1,
				'icon-class'=>	'icon-book',
				'parent'	=>	0
			),
			1 => 	array(
				'text'		=> 	'Administrators',	
				'link'		=> 	base_url() . 'person/1',
				'show_condition'=>	1,
				'icon-class'=>	'icon-list-alt',
				'parent'	=>	0
			)
			
		);
	}

	function index($filter = FALSE)
	{
		if($this->session->userdata('logged_in')) // user is logged in
		{	
			
			$this->lang->load('person'); // default language option taken from config.php file

			$this->viewdata['query'] 	 = $this->person_model->listing($filter, $this->viewdata['school_id']);

			$this->viewdata['sidenav'] 	 = $this->navigation->load_side_nav($filter, $this->sidemenu);
			
			$this->viewdata['filter']	 = $filter;

			$this->load->view('templates/header', $this->viewdata);
			$this->load->view('templates/sidenav', $this->viewdata);			
			$this->load->view('person_view', $this->viewdata);

			$this->load->view('templates/footer');	
			$this->breadcrumbcomponent->add('People', '/people/'.$filter);
		}
		else // not logged in - redirect to login controller (login page)
		{
			redirect('login','refresh');
		}
	}
	
	// The add function adds a person
	function add($role = FALSE)
	{
		
		if($this->session->userdata('logged_in')) // user is logged in
		{
			// get session data
			$session_data 			= $this->session->userdata('logged_in');
			$this->load->model('udf_model');
			
			// set the data associative array that is sent to the home view (and display/send)
			
			$this->viewdata['username'] 		= $session_data['username'];
			$this->load->helper(array('form', 'url')); // load the html form helper

			$this->lang->load('person'); // default language option taken from config.php file 
			
			$result 							= $this->person_model->GetPersonGender(1);
			$genders[""]						= "Select Gender";
			foreach($result as $row){
            	$genders[$row->id]=$row->label;
        	}

			$this->viewdata['genders'] 		= $genders;

			$result 				= $this->person_model->GetPersonTitles(1);

			$titles[""]				="Select Title";
			foreach($result as $row){
            	$titles[$row->id]	= $row->label;
        	}

			$this->viewdata['page_title']	= "Add New User";

			//UDF setup
			$this->viewdata['school_id'] 			= $session_data['currentschoolid'];
			$this->viewdata['udf'] 						= $this->udf_model->GetUdfs($session_data['currentschoolid'],1);

			$this->viewdata['titles'] 	= $titles;
			$this->viewdata['role_id'] 	= $role;
			$this->viewdata['roles'] 	= $this->person_model->GetPersonRoles();
			$this->viewdata['nav'] 		= $this->navigation->load('people');

			$this->breadcrumbcomponent->add('Add','/people/add/'.$role);
			$this->load->view('templates/header', $this->viewdata);
			$this->load->view('templates/sidenav', $this->viewdata);
			$this->load->view('person/add', $this->viewdata);
			$this->load->view('templates/footer');
			
		}
		else // not logged in - redirect to login controller (login page)
		{
			redirect('login','refresh');
		}
	}
	//This will save entry to the database
	function addrecord()
	{		
		//$this->load->model('person_model','',TRUE);
		if($this->session->userdata('logged_in')) // user is logged in
		{
			$this->load->library('form_validation');

			// get session data
			$session_data = $this->session->userdata('logged_in');

			// set the data associative array that is sent to the home view (and display/send)
			$data['username'] = $session_data['username'];
			$this->lang->load('person'); // default language option taken from config.php file 	
			
			//Set the id that should be updated
			$id= $this->input->post('pid');
			$gid = $this->input->post('gender');
			
			// load our tcrypt class and create a new object to work with
			$this->load->library('tcrypt');
 			$tcrypt = new Tcrypt;
			$upwd = $tcrypt->password_hash('g66k2q2@d');

			$this->form_validation->set_rules('fname', 'First Name', 'trim|required|xss_clean');
			$this->form_validation->set_rules('lname', 'Last Name', 'trim|required|xss_clean');
			$this->form_validation->set_rules('mname', 'Middle Name', 'trim|xss_clean');
			$this->form_validation->set_rules('cname', 'Common Name', 'trim|xss_clean');
			$this->form_validation->set_rules('Gender', 'Gender', 'trim|required|xss_clean');
			$this->form_validation->set_rules('email', 'Email Address', 'trim|xss_clean');
			$this->form_validation->set_rules('Title', 'Title', 'trim|required|xss_clean');
			$this->form_validation->set_rules('uname', 'User Name', 'trim|required|xss_clean|is_unique[person.username]');
			$this->form_validation->set_rules('userrole[]', 'User Roles', 'trim|required|xss_clean');
			$this->form_validation->set_rules('dob', 'Date of Birth', 'trim|required|xss_clean');
			

			$this->UDF_Validation();

			if($this->form_validation->run() == FALSE) 
   			{
				$this->add();
			}else{
				$dateArr = explode('/', $this->input->post('dob'));
				$data = array(
					'middle_name' => $this->input->post('mname'),
					'first_name' => $this->input->post('fname'),
					'surname' => $this->input->post('lname'),
					'common_name' => $this->input->post('cname'),
					'gender_id' => $this->input->post('Gender'),
					'title_id' => $this->input->post('Title'),
					'username' => $this->input->post('uname'),
					'password' => $upwd,
					'email'=>$this->input->post('email'),
					'default_schoolid' => $session_data["currentschoolid"],
					'dob' => $dateArr[2] . '-'. $dateArr[1] . '-' . $dateArr[0]
				);
				$roledata 		= $this->input->post('userrole');
				$person_id 		= $this->person_model->addperson($data,$roledata,$session_data["currentschoolid"]);

				$this->Insert_Update_UDF($person_id);
				
				$this->session->set_flashdata('msgsuccess','Record Saved');	
				redirect('person/' . $this->input->post('personrole'));
			}
		}
		else // not logged in - redirect to login controller (login page)
		{
			redirect('login','refresh');
		}
	}
	
	// The editrecord function edits a person
	function editrecord()
	{
		//$this->load->model('person_model','',TRUE);
		if($this->session->userdata('logged_in')) // user is logged in
		{
			// get session data
			$session_data = $this->session->userdata('logged_in');
			$this->load->library('form_validation');

			// set the data associative array that is sent to the home view (and display/send)
			$data['username'] = $session_data['username'];
			
			$this->lang->load('person'); // default language option taken from config.php file 				
			
			//Set the id that should be updated
			$id= $this->input->post('pid');
			$gid = $this->input->post('gender');
			
			$this->form_validation->set_rules('fname', 'First Name', 'trim|required|xss_clean');
			$this->form_validation->set_rules('lname', 'Last Name', 'trim|required|xss_clean');
			$this->form_validation->set_rules('mname', 'Middle Name', 'trim|xss_clean');
			$this->form_validation->set_rules('cname', 'Common Name', 'trim|xss_clean');
			$this->form_validation->set_rules('Gender', 'Gender', 'trim|required|xss_clean');
			$this->form_validation->set_rules('Title', 'Title', 'trim|required|xss_clean');
			$this->form_validation->set_rules('uname', 'User Name', 'trim|required|xss_clean');
			$this->form_validation->set_rules('email', 'Email Adrress', 'trim|xss_clean');
			$this->form_validation->set_rules('userrole[]', 'User Roles', 'trim|required|xss_clean');
			$this->form_validation->set_rules('dob', 'Date of Birth', 'trim|required|xss_clean');


			$this->UDF_Validation();

			if($this->form_validation->run() == FALSE) 
   			{
				$this->edit($id);
			}else{
				$dateArr = explode('/', $this->input->post('dob'));
				$data = array(
					'middle_name' => $this->input->post('mname'),
					'first_name' => $this->input->post('fname'),
					'surname' => $this->input->post('lname'),
					'common_name' => $this->input->post('cname'),
					'email' => $this->input->post('email'),
					'gender_id' => $this->input->post('Gender'),
					'title_id' => $this->input->post('Title'),
					'dob' => $dateArr[2] . '-'. $dateArr[1] . '-' . $dateArr[0]
				);

				$roledata = $this->input->post('userrole');
				
				$this->person_model->updateperson($id,$data,$roledata,$session_data["currentschoolid"]);
				$this->Insert_Update_UDF($id);

				$this->session->set_flashdata('msgsuccess','Record Updated');	
				redirect('person/' . $this->input->post('personrole'));
			}
		}
		else // not logged in - redirect to login controller (login page)
		{
			redirect('login','refresh');
		}
	}
	
	function addclass()
	{
		//$this->load->model('person_model','',TRUE);
		if($this->session->userdata('logged_in')) // user is logged in
		{
			// get session data
			$session_data = $this->session->userdata('logged_in');
			$this->load->library('form_validation');

			// set the data associative array that is sent to the home view (and display/send)
			
			
			$this->lang->load('person'); // default language option taken from config.php file 				
			
			//Set the id that should be updated
			$syear= $this->input->post('syear');
			$class_id = $this->input->post('class_id');
			$person_id = $this->input->post('person_id');
					
			$this->form_validation->set_rules('class_id', 'class_id', 'trim|required|xss_clean');
			

			if($this->form_validation->run() == FALSE) 
   			{
				$this->assignclass($id);
			}else{
				
				$data = array(
					'person_id' => $person_id,
					'class_id' => $class_id,
					'year' => $syear
					
				);
				
				
				$this->person_model->updatepersonclass($person_id,$syear,$data);
				$this->session->set_flashdata('msgsuccess','Record Saved');	
				redirect('person/' . $this->input->post('personrole'));
			}
		}
		else // not logged in - redirect to login controller (login page)
		{
			redirect('login','refresh');
		}
	}
	 // The add function is used to load a person record for edit
	function assignclass($id,$personrole = "none")
	{
		    if($this->session->userdata('logged_in')) // user is logged in
			{
				// get session data
				$session_data 				= $this->session->userdata('logged_in');
				
				// set the data associative array that is sent to the home view (and display/send)
				$this->load->helper(array('form', 'url')); // load the html form helper
				$this->viewdata['username'] 			= $session_data['username'];
				$this->lang->load('person'); // default language option taken from config.php file 	
				//$this->load->view('person_view', $data);
				
				// if the person model returns TRUE then call the view
				if(!$this->load->model('person_model','',TRUE))
				{
					$this->lang->load('person'); // default language option taken from config.php file 	
					$rows 					= $this->person_model->getpersonbyid($id, $this->viewdata['school_id']);
					foreach($rows as $row)
					{
						$this->viewdata['fname'] 		= $row->first_name;
						$this->viewdata['mname'] 		= $row->middle_name;
						$this->viewdata['lname']		= $row->surname;
						$this->viewdata['cname'] 		= $row->common_name;
						$this->viewdata['genderid']		= $row->gender_id;
						$this->viewdata['titleid'] 		= $row->title_id;
						$this->viewdata['uname'] 		= $row->username;
						$this->viewdata['personid'] 	= $row->id;
						$this->viewdata['dob'] 			= $row->dob;
						$this->viewdata['fullname']  = $row->first_name . " " . $row->middle_name . " " . $row->surname;
					}
					$result 				= $this->schoolclass_model->GetSchoolClasses($this->viewdata['school_id']);
					$classes[""]			="Select Class";
					foreach($result as $row){
		            	$classes[$row->id]=$row->title;
		        	}
					$this->viewdata['classes'] 		= $classes;

					
					$result1 = $this->person_model->GetStudentClassByStudent($id,$this->viewdata['currentsyear'],$this->viewdata['school_id']);					
					if($result1)
					{
						$this->viewdata['classid'] 	= $result1->class_id;
					}else{
						$this->viewdata['classid']="";
					}
		        	
				}	
				$this->viewdata['personrole']       = $personrole;
				$this->viewdata['nav'] 				= $this->navigation->load('people');
				$this->viewdata['page_title']		= "Assign Class";				

				//UDF setup
				$this->load->model('udf_model');
				$this->viewdata['school_id'] 	= $session_data['currentschoolid'];
				$this->viewdata['udf'] 				= $this->udf_model->GetUdfs($this->viewdata['school_id'],1,$id);
				$this->breadcrumbcomponent->add('Assign Class','/people/assignclass/'.$id);
				$this->load->view('templates/header', $this->viewdata);
				$this->load->view('templates/sidenav');	
				$this->load->view('person/edit_studentclass_view', $this->viewdata);
				$this->load->view('templates/footer');
			}
			else // not logged in - redirect to login controller (login page)
			{
				redirect('login','refresh');
			}
	}
	
	
    // The add function is used to load a person record for edit
	function edit($id, $personrole = FALSE)
	{
		    if($this->session->userdata('logged_in')) // user is logged in
			{
				// get session data
				$session_data 				= $this->session->userdata('logged_in');
				
				// set the data associative array that is sent to the home view (and display/send)
				$this->load->helper(array('form', 'url')); // load the html form helper
				$this->viewdata['username'] 			= $session_data['username'];
				$this->lang->load('person'); // default language option taken from config.php file 	
				//$this->load->view('person_view', $data);
				
				// if the person model returns TRUE then call the view
				if(!$this->load->model('person_model','',TRUE))
				{
					$this->lang->load('person'); // default language option taken from config.php file 	
					
					$rows 					= $this->person_model->getpersonbyid($id,$this->viewdata['school_id']);
					if($rows){
						foreach($rows as $row)
						{
							$this->viewdata['fname'] 		= $row->first_name;
							$this->viewdata['mname'] 		= $row->middle_name;
							$this->viewdata['lname']		= $row->surname;
							$this->viewdata['cname'] 		= $row->common_name;
							$this->viewdata['genderid']		= $row->gender_id;
							$this->viewdata['titleid'] 		= $row->title_id;
							$this->viewdata['uname'] 		= $row->username;
							$this->viewdata['personid'] 	= $row->id;
							$this->viewdata['dob'] 			= $row->dob;
							$this->viewdata['email'] 		= $row->email;
						}
						$result 				= $this->person_model->GetPersonGender(1);
						$genders[""]			= "Select Gender";
						foreach($result as $row){
			            	$genders[$row->id]=$row->label;
			        	}
						$this->viewdata['genders'] 		= $genders;

						$result 						= $this->person_model->GetPersonTitles(1);
						$titles[""]						="Select Title";
						foreach($result as $row){
			            	$titles[$row->id]	= $row->label;
			        	}
						$this->viewdata['titles'] 		= $titles;

						$this->viewdata['roles'] 		= $this->person_model->GetPersonRoles();

						$result 						= $this->person_model->getpersonrolesbypersonid($id, $this->viewdata['school_id'] );					
						
						foreach($result as $row){
			            	$personroles[$row->role_id]	= $row->role_id;
			        	}

			        	$this->viewdata['personroles'] 	= $personroles;
		        	}
		        	else
		        	{
		        		$this->session->set_flashdata('msgerr', 'Error user details');
		        		redirect("/person/");
		        	}
				}	
				
				$this->viewdata['nav'] 				= $this->navigation->load('people');
				$this->viewdata['page_title']		= "Edit User";				
				$this->viewdata['personrole']       = $personrole;
				//UDF setup
				$this->load->model('udf_model');
				$this->viewdata['school_id'] 	= $session_data['currentschoolid'];
				$this->viewdata['udf'] 				= $this->udf_model->GetUdfs($this->viewdata['school_id'],1,$id);
				$this->breadcrumbcomponent->add('Edit','/person/edit/'.$id);
				$this->load->view('templates/header', $this->viewdata);
				$this->load->view('templates/sidenav');	
				$this->load->view('person/edit', $this->viewdata);
				$this->load->view('templates/footer');
			}
			else // not logged in - redirect to login controller (login page)
			{
				redirect('login','refresh');
			}
	}

	// The add function is used to load a person record for edit
	function profile()
	{
		    if($this->session->userdata('logged_in')) // user is logged in
			{				
				$id 									= $this->viewdata['id'];
				$userProfile 							= $this->person_model->GetUserProfileInfo($id, $this->viewdata['school_id']);
				//$this->load->helper(array('form', 'url'));
				if($userProfile)
				{					
					$this->viewdata['profile']			= $userProfile;					
				
					$this->viewdata['nav'] 				= $this->navigation->load('people');
					$this->viewdata['page_title']		= "User Profile";				

					//UDF setup
					$this->load->model('udf_model');
					$this->viewdata['udf'] 				= $this->udf_model->GetUdfs($this->viewdata['school_id'],1,$id);
					$this->viewdata['udfDisplay']		= TRUE;
					$this->viewdata['age']				= "";//$this->ago(new DateTime($userProfile->dob));
					$this->load->view('templates/header', $this->viewdata);
					$this->load->view('templates/sidenav');	
					$this->load->view('person/profile', $this->viewdata);
					$this->load->view('templates/footer');
				}else{
					$this->session->set_flashdata('msgerr', 'Error retreiving user profile');
			    
			    	redirect('/home/');
				}
			}
			else // not logged in - redirect to login controller (login page)
			{
				redirect('login','refresh');
			}
	}

	// The logout function logs out a person from the database
	function logout()
	{
		// log the user out by destroying the session flag, then the session, then redirecting to the login controller		
		$this->session->unset_userdata('logged_in');
		session_destroy();
		
		$current_school = $this->input->cookie('nextsis',TRUE);
		
		if(isset($current_school))
			redirect('login/'.$current_school, 'refresh');
			printer_draw_elipse(printer_handle, ul_x, ul_y, lr_x, lr_y);
			redirect('login', 'refresh');
	}

	//UDF Validation 
	function UDF_Validation(){
		$udf_field  		= $this->input->post('udf_field', TRUE);
		$udf_types	 		= $this->input->post('udf_types', TRUE);
		$udf_validations	= $this->input->post("udf_validations", TRUE);
		$udf_titles 		= $this->input->post("udf_titles", TRUE);
		

		foreach ($udf_field as $key => $value) {
			$this->form_validation->set_rules('udf_field[' . $key . ']', $udf_titles[$key], $udf_validations[$key]);
		}
	}


	function Insert_Update_UDF($person_id){
		$this->load->model('udf_model');
		$udf_field  		= $this->input->post('udf_field', TRUE);
		$udf_types	 		= $this->input->post('udf_types', TRUE);
		$udf_validations	= $this->input->post("udf_validations", TRUE);
		$udf_titles 		= $this->input->post("udf_titles", TRUE);
		$udf_ids 			= $this->input->post("udf_ids", TRUE);
		$udf_data_ids 		= $this->input->post("udf_data_ids", TRUE);
		$insertData			= array();		
		$updateData			= array();

		foreach ($udf_field as $key => $value) {
			$isAdd = empty($udf_data_ids[$key]);
			switch ($udf_types[$key]) {				
				default:
					if ($isAdd){
						$insertData[count($insertData)] = array(							
							'udf_id' 		=> $udf_ids[$key],
							'udf_value' 	=> $value,
							'fk_id' 		=> $person_id					
						);
					}else{
						$updateData[count($updateData)] = array(							
							'udf_data_id' 	=> $udf_data_ids[$key],
							'udf_id' 		=> $udf_ids[$key],
							'udf_value' 	=> $value,
							'fk_id' 		=> $person_id					
						);
					}
					break;
			}			
		}

		if(count($insertData) > 0)
			$this->udf_model->AddUDFValues($insertData);
		
		if(count($updateData) > 0)
			$this->udf_model->UpdateUDFValues($updateData);
	}

	/*function ago( $datetime )
	{
	    $interval = date_create('now')->diff( $datetime );
	    $suffix = ( $interval->invert ? ' old' : '' );
	    if ( $v = $interval->y >= 1 ) return $this->pluralize( $interval->y, 'year' ) . $suffix;
	    if ( $v = $interval->m >= 1 ) return $this->pluralize( $interval->m, 'month' ) . $suffix;
	    if ( $v = $interval->d >= 1 ) return $this->pluralize( $interval->d, 'day' ) . $suffix;
	    if ( $v = $interval->h >= 1 ) return $this->pluralize( $interval->h, 'hour' ) . $suffix;
	    if ( $v = $interval->i >= 1 ) return $this->pluralize( $interval->i, 'minute' ) . $suffix;
	    
	    return $this->pluralize( $interval->s, 'second' ) . $suffix;
	}*/

	function pluralize( $count, $text ) 
	{ 
	    return $count . ( ( $count == 1 ) ? ( " $text" ) : ( " ${text}s" ) );
	}
}

?>