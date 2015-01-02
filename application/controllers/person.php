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
		$this->viewdata['nav'] = $this->navigation->load('people');
		
		
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
			// get session data
			$session_data = $this->session->userdata('logged_in');
			
			// set the data associative array that is sent to the home view (and display/send)
			$this->viewdata['username'] = $session_data['username'];

			$this->lang->load('person'); // default language option taken from config.php file 	
			//$this->load->view('person_view', $data);
			
			// if the person model returns TRUE then call the view
			if(!$this->load->model('person_model','',TRUE))
			{
				$this->lang->load('person'); // default language option taken from config.php file

				$this->viewdata['query'] = $this->person_model->listing($filter);
			}

			$this->viewdata['sidenav'] = $this->navigation->load_side_nav($filter, $this->sidemenu);
			
			$this->load->view('templates/header', $this->viewdata);
			$this->load->view('templates/sidenav', $this->viewdata);			
			$this->load->view('person_view', $this->viewdata);
			$this->load->view('templates/footer');	
		}
		else // not logged in - redirect to login controller (login page)
		{
			redirect('login','refresh');
		}
	}
	
	// The add function adds a person
	function add()
	{
		
		if($this->session->userdata('logged_in')) // user is logged in
		{
			// get session data
			$session_data = $this->session->userdata('logged_in');
			
			// set the data associative array that is sent to the home view (and display/send)
			
			$data['username'] = $session_data['username'];
			$this->load->helper(array('form', 'url')); // load the html form helper
			$this->lang->load('person'); // default language option taken from config.php file 
			
			$result = $this->person_model->GetPersonGender(1);
			$genders[""]="Select Gender";
			foreach($result as $row){
            	$genders[$row->id]=$row->label;
        	}

			$data['genders'] = $genders;

			$result = $this->person_model->GetPersonTitles(1);

			$titles[""]="Select Title";
			foreach($result as $row){
            	$titles[$row->id]=$row->label;
        	}

			$data['titles'] = $titles;

			$data['roles'] = $this->person_model->GetPersonRoles();	

			$data['nav'] = $this->navigation->load('people');

			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidenav');	
			$this->load->view('person/add', $data);
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
			// get session data
			$session_data = $this->session->userdata('logged_in');

			// set the data associative array that is sent to the home view (and display/send)
			$data['username'] = $session_data['username'];
			$this->lang->load('person'); // default language option taken from config.php file 	
			$this->load->view('person_view', $data);
			
			//Set the id that should be updated
			$id= $this->input->post('pid');
			$gid = $this->input->post('gender');
			
			// load our tcrypt class and create a new object to work with
			$this->load->library('tcrypt');
 			$tcrypt = new Tcrypt;
			$upwd = $tcrypt->password_hash('g66k2q2@d');
			
			
			$data = array(
				'middle_name' => $this->input->post('mname'),
				'first_name' => $this->input->post('fname'),
				'surname' => $this->input->post('lname'),
				'common_name' => $this->input->post('cname'),
				'gender_id' => $this->input->post('Gender'),
				'title_id' => $this->input->post('Title'),
				'username' => $this->input->post('uname'),
				'password' => $upwd
			);
			$roledata = $this->input->post('userrole');
			
			$this->person_model->addperson($data,$roledata);
			redirect('person','listing');
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

			// set the data associative array that is sent to the home view (and display/send)
			$data['username'] = $session_data['username'];
			
			$this->lang->load('person'); // default language option taken from config.php file 	
			$this->load->view('person_view', $data);
			
			//Set the id that should be updated
			$id= $this->input->post('pid');
			$gid = $this->input->post('gender');
			
			$data = array(
				'middle_name' => $this->input->post('mname'),
				'first_name' => $this->input->post('fname'),
				'surname' => $this->input->post('lname'),
				'common_name' => $this->input->post('cname'),
				'gender_id' => $this->input->post('Gender'),
				'title_id' => $this->input->post('Title')
			);
			$roledata = $this->input->post('userrole');
			
			$this->person_model->updateperson($id,$data,$roledata);
			redirect('person/listing');
		}
		else // not logged in - redirect to login controller (login page)
		{
			redirect('login','refresh');
		}
	}
	
	
    // The add function is used to load a person record for edit
	function edit($id)
	{
		    if($this->session->userdata('logged_in')) // user is logged in
			{
				// get session data
				$session_data = $this->session->userdata('logged_in');
				
				// set the data associative array that is sent to the home view (and display/send)
				$this->load->helper(array('form', 'url')); // load the html form helper
				$data['username'] = $session_data['username'];
				$this->lang->load('person'); // default language option taken from config.php file 	
				//$this->load->view('person_view', $data);
				
				// if the person model returns TRUE then call the view
				if(!$this->load->model('person_model','',TRUE))
				{
					$this->lang->load('person'); // default language option taken from config.php file 	
					$rows = $this->person_model->getpersonbyid($id);
					foreach($rows as $row)
					{
						$data['fname'] = $row->first_name;
						$data['mname'] = $row->middle_name;
						$data['lname'] = $row->surname;
						$data['cname'] = $row->common_name;
						$data['genderid'] = $row->gender_id;
						$data['titleid'] = $row->title_id;
						$data['uname'] = $row->username;
						$data['personid'] = $row->id;
					}
					$data['genders'] = $this->person_model->GetPersonGender(1);
					$data['titles'] = $this->person_model->GetPersonTitles(1);
					$data['roles'] = $this->person_model->GetPersonRoles();
					$data['personroles'] = $this->person_model->getpersonrolesbypersonid($id);
				}	
				
				$data['nav'] = $this->navigation->load('people');

				$this->load->view('templates/header', $data);
				$this->load->view('templates/sidenav');	
				$this->load->view('person/edit', $data);
				$this->load->view('templates/footer');
			}
			else // not logged in - redirect to login controller (login page)
			{
				redirect('login','refresh');
			}
	}
	
	// The listing function displays a list of people in the database
	function listing()
	{
		
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
		else
			redirect('login', 'refresh');
	}
}

?>