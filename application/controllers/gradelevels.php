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

class Gradelevels extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('gradelevels_model');
	}
	
	function index()
	{
		if($this->session->userdata('logged_in')) // user is logged in
		{
			// get session data
			$session_data = $this->session->userdata('logged_in');
			
			// set the data associative array that is sent to the home view (and display/send)
			
			$data['username'] = $session_data['username'];
			$this->lang->load('gradelevels'); // default language option taken from config.php file 	
			$this->load->view('templates/setupheader', $data);
			$this->load->view('gradelevels/gradelevels_view', $data);
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
			//$this->session->userdata('currentschoolid')
			$data['username'] = $session_data['username'];
			$data['currentschoolid'] = $session_data['currentschoolid'];
			$this->load->helper(array('form', 'url')); // load the html form helper
			$this->lang->load('person'); // default language option taken from config.php file 
			$data['gradelevels'] = $this->gradelevels_model->GetGradeLevels($session_data['currentschoolid']);
			//	$data['titles'] = $this->gradelevels_model->GetPersonTitles(1);
			//	$data['roles'] = $this->gradelevels_model->GetPersonRoles();	
		    $this->load->view('templates/setupheader',$data);
			$this->load->view('gradelevels/add', $data);
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
			$this->lang->load('gradelevels'); // default language option taken from config.php file 	
			//$this->load->view('person_view', $data);
			
				
			if($this->input->post('next_grade_id') == "n/a")
			{
				$data = array(
					'school_id' => $this->input->post('school_id'),
					'title' => $this->input->post('title')
				);
				
			}else{
				$data = array(
					'school_id' => $this->input->post('school_id'),
					'title' => $this->input->post('title'),
					'next_grade' => $this->input->post('next_grade_id')
					
				);
			}
			
			
			$this->gradelevels_model->addgradelevel($data);
			redirect('gradelevels','listing');
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
			$id= $this->input->post('glid');
			
			
			
			if($this->input->post('next_grade_id') == "n/a")
			{
				$data = array(
					'school_id' => $this->input->post('school_id'),
					'title' => $this->input->post('title')
				);
				
			}else{
				$data = array(
					'school_id' => $this->input->post('school_id'),
					'title' => $this->input->post('title'),
					'next_grade' => $this->input->post('next_grade_id')
					
				);
			}
				
			$this->gradelevels_model->updategradelevel($id,$data);
			redirect('gradelevels/listing');
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
				$data['currentschoolid'] = $session_data['currentschoolid'];
				$this->lang->load('gradelevels'); // default language option taken from config.php file 	
				//$this->load->view('person_view', $data);
				
				// if the person model returns TRUE then call the view
				if(!$this->load->model('gradelevels_model','',TRUE))
				{
					echo "this is a test edit";
						
					$rows = $this->gradelevels_model->GetGradeLevelById($id);
					foreach($rows as $row)
					{
						$data['title'] = $row->title;
						$data['school_id'] = $row->school_id;
						$data['next_grade_id'] = $row->next_grade_id;
						$data['id'] = $row->id;
						
					}
					$data['gradelevels'] = $this->gradelevels_model->GetGradeLevelsExceptCurrent($session_data['currentschoolid'],$id);	
				}	
				$this->load->view('templates/setupheader',$data);
				$this->load->view('gradelevels/edit', $data);
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
			$data['currentschoolid'] = $session_data['currentschoolid'];
			$this->lang->load('gradelevels'); // default language option taken from config.php file 	
			//$this->load->view('person_view', $data);
			
			// if the person model returns TRUE then call the view
			if(!$this->load->model('gradelevels_model','',TRUE))
			{
				//echo "this is a test";
				$this->lang->load('setup'); // default language option taken from config.php file 	
				$data['query'] = $this->gradelevels_model->listing($data['currentschoolid']);
				$data['gradelevels'] = $this->gradelevels_model->GetGradeLevels($session_data['currentschoolid']);
			}	
			$this->load->view('templates/setupheader', $data);	
			$this->load->view('gradelevels/gradelevels_view', $data);
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