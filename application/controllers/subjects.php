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

class Subjects extends CI_Controller
{

	var $viewdata = null;

	function __construct()
	{
		parent::__construct();

		$session_data = $this->session->userdata('logged_in');

		$this->viewdata['username'] 		= $session_data['username'];
		$this->viewdata['currentschoolid'] 	= $session_data['currentschoolid'];
		$this->viewdata['currentsyear'] 	= $session_data['currentsyear'];
		$this->viewdata['nav'] 				= $this->navigation->load('setup');

		$this->load->model('subjects_model');

		$this->breadcrumbcomponent->add('Subjects', '/subjects');		
	}
	
	function index()
	{
		if($this->session->userdata('logged_in')) // user is logged in
		{

			$this->viewdata['query'] = $this->subjects_model->listing($this->viewdata['currentschoolid']);	

			$this->load->view('templates/header', $this->viewdata);
			$this->load->view('templates/sidenav', $this->viewdata);
			$this->load->view('subjects/subjects_view', $this->viewdata);
			$this->load->view('templates/footer');
		}
		else // not logged in - redirect to login controller (login page)
		{
			redirect('login','refresh');
		}
	}

	
	// The add function returns the view used to add a new period
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
			$data['currentsyear'] = $session_data['currentsyear'];
			$data['nav'] = $this->navigation->load('setup');

			$this->load->helper(array('form', 'url')); // load the html form helper
			$this->lang->load('setup'); // default language option taken from config.php file 
			
			
			
		    $this->load->view('templates/header',$data);
		    $this->load->view('templates/sidenav',$data);
			$this->load->view('subjects/add_subject_view', $data);
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
		// use the CodeIgniter form validation library
   		$this->load->library('form_validation');
		
		//$this->load->model('person_model','',TRUE);
		if($this->session->userdata('logged_in')) // user is logged in
		{
			// get session data
			$session_data = $this->session->userdata('logged_in');
		
		// field is trimmed, required and xss cleaned respectively
   		$this->form_validation->set_rules('title', 'Title', 'trim|required|xss_clean');
		
		// apply rules and then callback to validate_password method below
   		
   		$this->form_validation->set_rules('short_name', 'Short Name', 'trim|required|xss_clean');
			
			// set the data associative array that is sent to the home view (and display/send)
			$data['username'] = $session_data['username'];
			$this->lang->load('setup'); // default language option taken from config.php file 	
			//$this->load->view('person_view', $data);
			
			$syear=$this->input->post('syear');
			$school_id=$this->input->post('school_id');
			
			$title=$this->input->post('title');
			
			$short_name=$this->input->post('short_name');
			
			
			if($this->form_validation->run() == FALSE) 
   			{
				$this-add();
			}else{
				
								
				$newdata = array(
					
					'title' => $title,
					'school_id' => $school_id,
					'short_name' => $short_name
					
				);
				
				$this->subjects_model->AddSubject($newdata);
			    redirect('subjects');
			}
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
				$data['currentsyear'] = $session_data['currentsyear'];
				$data['nav'] = $this->navigation->load('setup');

				$this->lang->load('setup'); // default language option taken from config.php file 	
				//$this->load->view('person_view', $data);
				
				// if the person model returns TRUE then call the view
				if(!$this->load->model('subjects_model','',TRUE))
				{
					
					$row = $this->subjects_model->GetSubjectById($id, $data['currentschoolid']);
					
					if($row){

						$data['title']		= $row->title;
						$data['school_id']	= $row->school_id;
						$data['short_name'] = $row->short_name;
						$data['subject_id'] = $row->subject_id;

						$this->load->view('templates/header',$data);
						$this->load->view('templates/sidenav', $data);
						$this->load->view('subjects/edit_subject_view', $data);
						$this->load->view('templates/footer');

					}else{

						$this->session->set_flashdata('msgerr', 'Record not found!!');
						redirect('subjects','refresh');
					}
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
			
			$data['username']			= $session_data['username'];
			$data['currentschoolid']	= $session_data['currentschoolid'];
			$data['currentsyear']		= $session_data['currentsyear'];
			$data['nav'] 				= $this->navigation->load('setup');

			// use the CodeIgniter form validation library
   			$this->load->library('form_validation');
		
			// field is trimmed, required and xss cleaned respectively
   			$this->form_validation->set_rules('title', 'Title', 'trim|required|xss_clean');
		
			// apply rules and then callback to validate_password method below
   			$this->form_validation->set_rules('short_name', 'Short Name', 'trim|required|xss_clean');

			//Set the id that should be updated
			$subject_id = $this->input->post('subject_id');
			$school_id 	= $this->input->post('school_id');
			$title 		= $this->input->post('title');
			$short_name = $this->input->post('short_name');
								
			if($this->form_validation->run() == FALSE) // authentication failed - display the login form 
   			{
				$this->edit($subject_id);
			}else{
				
			
				$newdata = array(
					'title' => $title,
					'short_name' => $short_name,
					'school_id' => $school_id
				);
				
				$this->subjects_model->UpdateSubject($subject_id, $newdata);
			    redirect('subjects');
			}
		}
		else // not logged in - redirect to login controller (login page)
		{
			redirect('login','refresh');
		}
	}
	
	
	function courses($subject_id){
		if($this->session->userdata('logged_in')) // user is logged in
		{
			// get session data
			$session_data = $this->session->userdata('logged_in');
			
			// set the data associative array that is sent to the home view (and display/send)
			
			// set the data associative array that is sent to the home view (and display/send)
			$data['username'] = $session_data['username'];
			$data['currentschoolid'] = $session_data['currentschoolid'];
			$data['currentsyear'] = $session_data['currentsyear'];
			$data['subject_id'] = $subject_id;

			$data['query'] = $this->subjects_model->GetSubjectCourses($subject_id, $data['currentschoolid']);
			
			$subject = $this->subjects_model->GetSubjectById($subject_id, $data['currentschoolid']);	
			
			$data['nav'] = $this->navigation->load('courses');
			$data['page_title'] = "Manage ". $subject->title . " Courses";

			$this->breadcrumbcomponent->add($subject->title, 'subjects/courses/'.$subject_id);
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidenav', $data);
			$this->load->view('subjects/subjectcourse_view', $data);
			$this->load->view('templates/footer');


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