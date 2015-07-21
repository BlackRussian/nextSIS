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

		$this->viewdata['username'] 		= $session_data['username'];
		$this->viewdata['currentschoolid'] 	= $session_data['currentschoolid'];
		$this->viewdata['currentsyear'] 	= $session_data['currentsyear'];
		$this->viewdata['nav'] 				= $this->navigation->load('courses');

		$this->load->model('subjects_model');

		$this->breadcrumbcomponent->add('Subjects', '/subjects');
	}
	
	function _remap($method, $params = array()){
    	if (method_exists($this, $method))
    	{
        	return call_user_func_array(array($this, $method), $params);
    	}else{
        	$this->index($method);
        }
	}

	function index($filter = FALSE)
	{
		if($this->session->userdata('logged_in')) // user is logged in
		{

			$course = $this->subjects_model->GetSubjectCourseById($filter);

			$this->breadcrumbcomponent->add($course->subject_title, '/subjects/courses/'.$course->subject_id);
			$this->breadcrumbcomponent->add($course->course_title, '/courses/'.$course->course_id);

			if($filter)
				$this->viewdata['page_title'] = "Teachers assigned to \"$course->course_title\"";
			else
				$this->viewdata['page_title'] = "All Current Courses";

			$this->viewdata['query']		= $this->subjects_model->GetTermCourses($this->viewdata['currentsyear'], $this->viewdata['currentschoolid'], $filter);
			
			$this->viewdata['course_id'] = $course->course_id;
			
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
			
			
			$subject 					= $this->subjects_model->GetSubjectById($subject_id, $this->viewdata['currentschoolid']);
			$result						= $this->gradelevels_model->GetGradeLevels($this->viewdata['currentschoolid']);
			$gradelevels[""]			= "Select Grade";
			$this->viewdata['subject'] 	= $subject;

			foreach($result as $row){
            	$gradelevels[$row->id] = $row->title;
        	}


        	$this->breadcrumbcomponent->add($subject->title, '/subjects/courses/'.$subject->subject_id);
			$this->breadcrumbcomponent->add('Add', '/courses/add/'.$subject->subject_id);

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
			$this->form_validation->set_rules('selGradeLevel', 'Grade Level', 'trim|required|xss_clean');
			
			if($this->form_validation->run() == FALSE) 
   			{
				$this->add($this->input->post('subject_id'));
			}else{		
				$newdata = array(
					
					'title' => 			$this->input->post('title'),
					'grade_level' =>	$this->input->post('selGradeLevel'),
					'short_name' => 	$this->input->post('short_name'),
					'subject_id' => 	$this->input->post('subject_id'),
					'syear' =>			$this->viewdata['currentsyear']
					
				);
				
				$this->subjects_model->AddSubjectCourse($newdata);
			    redirect('subjects/courses/' . $this->input->post('subject_id'));
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
				
				$this->load->model('gradelevels_model');

				$course = $this->subjects_model->GetSubjectCourseById($id);
				
				if($course){
					$result		= $this->gradelevels_model->GetGradeLevels($this->viewdata['currentschoolid']);
					$gradelevels[""] = "Select Grade";

					foreach($result as $row){
		            	$gradelevels[$row->id] = $row->title;
		        	}

					$this->viewdata['gradelevels'] 	= $gradelevels;


					$this->viewdata['page_title'] 	= "Edit";

					$this->viewdata['title']		= $course->course_title;
					$this->viewdata['grade_level']	= $course->grade_level;
					$this->viewdata['short_name'] 	= $course->short_name;
					$this->viewdata['subject_id'] 	= $course->subject_id;
					$this->viewdata['course_id'] 	= $course->course_id;

					$this->load->view('templates/header',$this->viewdata);
					$this->load->view('templates/sidenav', $this->viewdata);
					$this->load->view('subjects/edit_course_view', $this->viewdata);
					$this->load->view('templates/footer');

				}else{

					$this->session->set_flashdata('msgerr', 'Record not found!!');
					redirect('subjects','refresh');
				}
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

			// field is trimmed, required and xss cleaned respectively
   			$this->form_validation->set_rules('short_name', 'Short Name', 'trim|required|xss_clean');
			
			// field is trimmed, required and xss cleaned respectively
			$this->form_validation->set_rules('selGradeLevel', 'Grade Level', 'trim|required|xss_clean');

			//Set the id that should be updated
			$title 			= $this->input->post('title');
			$short_name 	= $this->input->post('short_name');
			$grade_level 	= $this->input->post('selGradeLevel');
			$subject_id 	= $this->input->post('subject_id');
			$course_id		= $this->input->post('course_id');
			if($this->form_validation->run() == FALSE) // authentication failed - display the login form 
   			{
				$this->edit($subject_id);
			}else{
				
			
				$newdata = array(
					'title' => $title,
					'short_name' => $short_name,
					'grade_level' => $grade_level
				);
				
				$this->subjects_model->UpdateSubjectCourse($course_id, $newdata);
			    redirect('subjects/courses/'.$subject_id);
			}
		}
		else // not logged in - redirect to login controller (login page)
		{
			redirect('login','refresh');
		}
	}

	// The editrecord function updates a course
	function assignteacher($course_id)
	{
		//$this->load->model('person_model','',TRUE);
		if($this->session->userdata('logged_in')) // user is logged in
		{
			$this->load->model('school_model');
			$this->load->model('person_model');

			//load course details for use in view
			$course = $this->subjects_model->GetSubjectCourseById($course_id);

			$result = $this->school_model->GetSchoolTerms($this->viewdata['currentschoolid'], $this->viewdata['currentsyear']);

			$markingperiod[""] = "Select a Term";

			foreach ($result as $row) {
				$markingperiod[$row->marking_period_id."|".$row->short_name] = $row->title; 
			}

			$result = $this->person_model->GetPersonsWithRole(2, $this->viewdata['currentschoolid']);

			$teachers[""] = "Select a Teacher";

			foreach ($result as $row) {
				$teachers[$row->id] = $row->first_name . " " . $row->surname; 
			}

			//construct page title
			$this->viewdata["page_title"] 		= "Assign teacher to \"" .$course->course_title ." - " . $course->short_name . "\"";
			$this->viewdata["course"] 			= $course;
			$this->viewdata["subject_id"] 		= $course->subject_id;
			$this->viewdata["markingperiod"] 	= $markingperiod;
			$this->viewdata["teachers"] 		= $teachers;

			$this->load->view('templates/header', $this->viewdata);
			$this->load->view('templates/sidenav');
			$this->load->view('subjects/assign_teacher_view', $this->viewdata);
			$this->load->view('templates/footer');
		}
		else // not logged in - redirect to login controller (login page)
		{
			redirect('login','refresh');
		}
	}

	// The editrecord function updates a course
		function reassignteacher($term_course_id)
		{
			//$this->load->model('person_model','',TRUE);
			if($this->session->userdata('logged_in')) // user is logged in
			{
				$this->load->model('school_model');
				$this->load->model('person_model');

				//load course details for use in view
				$course = $this->subjects_model->GetTermCourseById($term_course_id);

				$result = $this->school_model->GetSchoolTerms($this->viewdata['currentschoolid'], $this->viewdata['currentsyear']);

				$markingperiod[""] = "Select a Term";

				foreach ($result as $row) {
					$markingperiod[$row->marking_period_id."|".$row->short_name] = $row->title; 
				}

				$result = $this->person_model->GetPersonsWithRole(2, $this->viewdata['currentschoolid']);

				$teachers[""] = "Select a Teacher";

				foreach ($result as $row) {
					$teachers[$row->id] = $row->first_name . " " . $row->surname; 
				}

				//construct page title
				$this->viewdata["page_title"] 		= "Ressign teacher for \"" .$course->course_title ." - " . $course->short_name . "\"";
				$this->viewdata["course"] 			= $course;
				$this->viewdata["subject_id"] 		= $course->subject_id;
				$this->viewdata["markingperiod"] 	= $markingperiod;
				$this->viewdata["teachers"] 		= $teachers;

				$this->load->view('templates/header', $this->viewdata);
				$this->load->view('templates/sidenav');
				$this->load->view('subjects/reassign_teacher_view', $this->viewdata);
				$this->load->view('templates/footer');
			}
			else // not logged in - redirect to login controller (login page)
			{
				redirect('login','refresh');
			}
		}


	function addtermcourse(){
		// use the CodeIgniter form validation library
   		$this->load->library('form_validation');
		
		if($this->session->userdata('logged_in')) // user is logged in
		{
			// get session data
			$session_data = $this->session->userdata('logged_in');
			
			// field is trimmed, required and xss cleaned respectively
			$this->form_validation->set_rules('selTerm', 'Term', 'trim|required|xss_clean');
			
			// field is trimmed, required and xss cleaned respectively
   			$this->form_validation->set_rules('selTeacher', 'Teacher Name', 'trim|required|xss_clean');

			if($this->form_validation->run() == FALSE) 
   			{
				$this->assignteacher($this->input->post('course_id'));
			}else{
				$term = explode ("|", $this->input->post('selTerm'));

				$newdata = array(
					'marking_period_id' => $term[0],
					'mp' 				=> $term[1],
					'course_id' 		=> $this->input->post('course_id'),
					'teacher_id' 		=> $this->input->post('selTeacher')
				);
				
				$this->subjects_model->AddTermCourse($newdata);
			    
			    redirect('subjects/courses/' . $this->input->post('subject_id'));
			}
		}
		else // not logged in - redirect to login controller (login page)
		{
			redirect('login','refresh');
		}
	}

	function edittermcourse(){
		// use the CodeIgniter form validation library
   		$this->load->library('form_validation');
		
		if($this->session->userdata('logged_in')) // user is logged in
		{
			// get session data
			$session_data = $this->session->userdata('logged_in');
			
			// field is trimmed, required and xss cleaned respectively
			$this->form_validation->set_rules('selTerm', 'Term', 'trim|required|xss_clean');
			
			// field is trimmed, required and xss cleaned respectively
   			$this->form_validation->set_rules('selTeacher', 'Teacher Name', 'trim|required|xss_clean');

			if($this->form_validation->run() == FALSE) 
   			{
				$this->reassignteacher($this->input->post('term_course_id'));
			}else{
				$term 		= explode ("|", $this->input->post('selTerm'));
				$id 		= $this->input->post('term_course_id');

				$data 	= array(
										'marking_period_id' => $term[0],
										'mp' 				=> $term[1],
										'teacher_id' 		=> $this->input->post('selTeacher')
				);
				
				$this->subjects_model->EditTermCourse($id, $data);
			    
			    redirect('courses/' . $this->input->post('subject_id'));
			}
		}
		else // not logged in - redirect to login controller (login page)
		{
			redirect('login','refresh');
		}
	}
}
?>