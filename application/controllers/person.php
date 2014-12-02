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
	function __construct()
	{
		parent::__construct();
		$this->load->model('person_model');
	}
	
	function index()
	{
		if($this->session->userdata('logged_in')) // user is logged in
		{
			// get session data
			$session_data = $this->session->userdata('logged_in');
			
			// set the data associative array that is sent to the home view (and display/send)
			
			$data['username'] = $session_data['username'];
			$this->lang->load('person'); // default language option taken from config.php file 	
			$this->load->view('person_view', $data);
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
			$data['genders'] = $this->person_model->GetPersonGender(1);
					$data['titles'] = $this->person_model->GetPersonTitles(1);
					$data['roles'] = $this->person_model->GetPersonRoles();	
			$this->load->view('person/add', $data);
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
					echo "this is a test edit";
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
						$data['username'] = $row->username;
						$data['personid'] = $row->id;
					}
					$data['genders'] = $this->person_model->GetPersonGender(1);
					$data['titles'] = $this->person_model->GetPersonTitles(1);
					$data['roles'] = $this->person_model->GetPersonRoles();
					$data['personroles'] = $this->person_model->getpersonrolesbypersonid($id);
				}		
				$this->load->view('person/edit', $data);
			}
			else // not logged in - redirect to login controller (login page)
			{
				redirect('login','refresh');
			}
	}
	
	// The listing function displays a list of people in the database
	function listing()
	{
		if($this->session->userdata('logged_in')) // user is logged in
		{
			// get session data
			$session_data = $this->session->userdata('logged_in');
			
			// set the data associative array that is sent to the home view (and display/send)
			$data['username'] = $session_data['username'];
			$this->lang->load('person'); // default language option taken from config.php file 	
			//$this->load->view('person_view', $data);
			
			// if the person model returns TRUE then call the view
			if(!$this->load->model('person_model','',TRUE))
			{
				echo "this is a test";
				$this->lang->load('person'); // default language option taken from config.php file 	
				$data['query'] = $this->person_model->listing();

			}	
			$this->load->view('templates/header', $data);		
			$this->load->view('person_view', $data);
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
		redirect('login', 'refresh');
	}
}

?>