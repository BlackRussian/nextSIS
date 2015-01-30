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
class Schoolclasses extends CI_Controller
{

	var $viewdata = null;

	function __construct()
	{
		parent::__construct();
		$this->load->model('schoolclass_model');
		$this->load->model('gradelevels_model');

		//$this->output->enable_profiler(TRUE);
		$session_data = $this->session->userdata('logged_in');
		
		// set the data associative array common values that is sent to the views of this controller
		$this->viewdata['username'] 		= $session_data['username'];
		$this->viewdata['currentschoolid'] 	= $session_data['currentschoolid'];
		$this->viewdata['currentsyear'] 	= $session_data['currentsyear'];
		$this->viewdata['nav'] 				= $this->navigation->load('setup');

		$this->breadcrumbcomponent->add('Grade Levels','/gradelevels');
		$this->breadcrumbcomponent->add('Classes','/schoolclasses');
	}
	
	function _remap($method, $params = array()){
    	if (method_exists($this, $method))
    	{
        	return call_user_func_array(array($this, $method), $params);
    	}else{
        	$this->index($method);
        }
	}

	function index($filter=FALSE)
	{
		if($this->session->userdata('logged_in')) // user is logged in
		{

			$this->lang->load('gradelevels'); // default language option taken from config.php file 	

			$this->viewdata['query'] = $this->schoolclass_model->listing($filter, $this->viewdata['currentschoolid']);

			if($filter && $this->viewdata['query']){
				$this->breadcrumbcomponent->add($this->viewdata['query'][0]->grade_title,'schoolclasses/'.$filter);
			}


			$this->load->view('templates/header', $this->viewdata);
			$this->load->view('templates/sidenav', $this->viewdata);
			$this->load->view('schoolclasses/schoolclass_view', $this->viewdata);
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
			$this->lang->load('setup'); // default language option taken from config.php file 
			
			$result		= $this->gradelevels_model->GetGradeLevels($this->viewdata['currentschoolid']);
			$gradelevels[""] = "Select Grade";

			foreach($result as $row){
            	$gradelevels[$row->id] = $row->title;
        	}

			$this->viewdata['gradelevels'] 	= $gradelevels;	
			$this->viewdata['page_title'] = 'Add Class';

			$this->viewdata['gradelevels'] = $gradelevels;

		    $this->load->view('templates/header',$this->viewdata);
		    $this->load->view('templates/sidenav',$this->viewdata);
			$this->load->view('schoolclasses/add_schoolclass_view', $this->viewdata);
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

		$this->load->library('form_validation');
		
		if($this->session->userdata('logged_in')) // user is logged in
		{
			// get session data
			$session_data = $this->session->userdata('logged_in');
		
			// field is trimmed, required and xss cleaned respectively
   			$this->form_validation->set_rules('title', 'Title', 'trim|required|xss_clean');
			
			// field is trimmed, required and xss cleaned respectively
			$this->form_validation->set_rules('selGradeLevel', 'Grade Level', 'trim|required|xss_clean');
			
			if($this->form_validation->run() == FALSE) 
   			{
				$this->add($this->input->post('subject_id'));
			}else{	

				$newdata = array(
					'school_id' => $this->input->post('school_id'),
					'title' => $this->input->post('title'),
					'gradelevel_id' => $this->input->post('selGradeLevel')
					
				);
				
				$this->schoolclass_model->AddSchoolClass($newdata);

				$this->session->set_flashdata('msgsuccess', 'Class added successfully.');
			    
			    redirect('schoolclasses/' . $this->input->post('selGradeLevel'));
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
				// if the person model returns TRUE then call the view
				if(!$this->load->model('schoolclass_model','',TRUE))
				{					

					$class 	= $this->schoolclass_model->GetSchoolClassesById($id, $this->viewdata['currentschoolid']);
					$result	= $this->gradelevels_model->GetGradeLevels($this->viewdata['currentschoolid']);
					
					$gradelevels[""] = "Select Grade";

					foreach($result as $row){
		            	$gradelevels[$row->id] = $row->title;
		        	}

					$this->viewdata["classobj"] 	= $class;
					$this->viewdata["page_title"] 	= "Edit Class";
					$this->viewdata['gradelevels'] 	= $gradelevels;
				

					$this->load->view('templates/header',$this->viewdata);
					$this->load->view('templates/sidenav', $this->viewdata);
					$this->load->view('schoolclasses/edit_schoolclass_view', $this->viewdata);
					$this->load->view('templates/footer');
				}else{

					$this->session->set_flashdata('msgerr', 'System Error. Run for the hills!!');
					redirect('schoolclasses/','refresh');
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
		$this->load->library('form_validation');
		
		if($this->session->userdata('logged_in')) // user is logged in
		{
		
			// field is trimmed, required and xss cleaned respectively
   			$this->form_validation->set_rules('title', 'Title', 'trim|required|xss_clean');
			
			// field is trimmed, required and xss cleaned respectively
			$this->form_validation->set_rules('selGradeLevel', 'Grade Level', 'trim|required|xss_clean');
			$glevelid = $this->input->post('gradelevel_id');
			if($this->form_validation->run() == FALSE) 
   			{
				$this->edit($this->input->post('class_id'));
			}else{	
				
				$id  = $this->input->post('class_id');

				$data = array(
					'title' => $this->input->post('title'),
					'gradelevel_id' => $this->input->post('selGradeLevel')
					
				);
				
				$this->schoolclass_model->UpdateSchoolClass($id, $data);

				$this->session->set_flashdata('msgsuccess', 'Class updated successfully.');
			    
			    redirect('schoolclasses/' . $glevelid);
			}
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
		redirect('login', 'refresh');
	}
}

?>