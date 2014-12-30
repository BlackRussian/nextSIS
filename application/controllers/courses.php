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

class Courses extends CI_Controller
{

	var $viewdata = null;

	function __construct()
	{
		parent::__construct();
		
		$session_data = $this->session->userdata('logged_in');
		//$this->data = array();
		
		// set the data associative array common values that is sent to the views of this controller
		$this->viewdata['username'] 		= $session_data['username'];
		$this->viewdata['currentschoolid'] 	= $session_data['currentschoolid'];
		$this->viewdata['currentsyear'] 	= $session_data['currentsyear'];
		$this->viewdata['nav'] 				= $this->navigation->load('courses');
	}
	
	function index()
	{
		if($this->session->userdata('logged_in')) // user is logged in
		{
			
			$this->lang->load('course'); // load language file
			
			$this->load->view('templates/header', $this->viewdata);
			$this->load->view('templates/sidenav');
			$this->load->view('courses_view', $this->viewdata);
			$this->load->view('templates/footer');
		}
		else // not logged in - redirect to login controller (login page)
		{
			redirect('login','refresh');
		}
	}
	
	// The add function adds a person
	function add($subject_id)
	{
		if($this->session->userdata('logged_in')) // user is logged in
		{

			//load models needed
			$this->load->model('gradelevels_model');
			$this->load->model('subjects_model');
			
			// set the data associative array that is sent to the home view (and display/send)
			//$this->session->userdata('currentschoolid')
			$this->viewdata['subject_id'] 		= $subject_id;

			
			$result		= $this->gradelevels_model->GetGradeLevels($this->viewdata['currentschoolid']);
			$subject 	= $this->subjects_model->GetSubjectById($subject_id, $this->viewdata['currentschoolid']);

			$gradelevels["-1"] = "Select Grade";

			foreach($result as $row){
            	$gradelevels[$row->id] = $row->title;
        	}

			$this->viewdata['gradelevels'] 	= $gradelevels;
			$this->viewdata['page_title'] 	= "Adding Course for \"". $subject->title . "\"";

			
		    $this->load->view('templates/header',$this->viewdata);
		    $this->load->view('templates/sidenav',$this->viewdata);
			$this->load->view('subjects/add_course_view', $this->viewdata);
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
		
		if($this->session->userdata('logged_in')) // user is logged in
		{
			// get session data
			$session_data = $this->session->userdata('logged_in');
		
			// field is trimmed, required and xss cleaned respectively
   			$this->form_validation->set_rules('title', 'Title', 'trim|required|xss_clean');

			// field is trimmed, required and xss cleaned respectively
   			$this->form_validation->set_rules('short_name', 'Short Name', 'trim|required|xss_clean');
			
			// field is trimmed, required and xss cleaned respectively
			$this->form_validation->set_rules('selGradeLevel', 'Short Name', 'trim|required|xss_clean');
			
			
			if($this->form_validation->run() == FALSE) 
   			{

				$this->add();
			}else{		
				$newdata = array(
					
					'title' => $title,
					'grade_level' => $school_id,
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
	
	// The edit function is used to load a course record for edit
	function edit($id)
	{
		    if($this->session->userdata('logged_in')) // user is logged in
			{

			}
			else // not logged in - redirect to login controller (login page)
			{
				redirect('login','refresh');
			}
	}

	// The editrecord function updates a course
	function editrecord()
	{
		//$this->load->model('person_model','',TRUE);
		if($this->session->userdata('logged_in')) // user is logged in
		{

		}
		else // not logged in - redirect to login controller (login page)
		{
			redirect('login','refresh');
		}
	}

	// The editrecord function updates a course
	function termcourses()
	{
		//$this->load->model('person_model','',TRUE);
		if($this->session->userdata('logged_in')) // user is logged in
		{

		}
		else // not logged in - redirect to login controller (login page)
		{
			redirect('login','refresh');
		}
	}
}

?>