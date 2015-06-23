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

class Gradebook extends CI_Controller
{
	var $data = null;

	function __construct()
	{
		parent::__construct();
		$this->load->model('gradebook_model');
		$this->lang->load('setup');


		// get session data
		$session_data = $this->session->userdata('logged_in');
			
		// set the data associative array that is sent to the home view (and display/send)
		$this->data['username'] 			= $session_data['username'];
		$this->data['currentschoolid'] 		= $session_data['currentschoolid'];
		$this->data['currentsyear'] 		= $session_data['currentsyear'];		
		$this->data['roles'] 				= $session_data['role'];	
		$this->data['id'] 					= $session_data['id'];	
		$this->data['nav'] 					= $this->navigation->load('gradebook');

		$this->breadcrumbcomponent->add('Grade Book Courses', '/gradebook');
	}
	
	function index()
	{
		if($this->session->userdata('logged_in')) // user is logged in
		{
			$this->data['query'] = $this->gradebook_model->listing($this->data['roles'], $this->data['id']);	


			$this->load->view('templates/header', $this->data);
			$this->load->view('templates/sidenav');
			$this->load->view('gradebook/list_course_view', $this->data);
			$this->load->view('templates/footer');
		}
		else // not logged in - redirect to login controller (login page)
		{
			redirect('login','refresh');
		}
	}

	
	// The add function returns the view used to add new grades
	function add($id)
	{
		
		if($this->session->userdata('logged_in')) // user is logged in
		{	
			$this->load->model('udf_model');
			$courses 						= $this->gradebook_model->GetGradeTypeInfo($id);
			$this->data['query'] 			= $this->gradebook_model->GetStudentList($id);			
			$this->data['grade_type_id'] 	= $id;
			$this->data['course_id'] 		= $courses->term_course_id;
			$this->data['page_title'] 		= "Adding Grades for \"". $courses->subject . " - " . $courses->title . "\"";
			


			//UDF setup		
			$udfs = array();
			foreach ($this->data['query'] as $student) {
				$udfs[$student->studentid] = $this->udf_model->GetUdfs($this->data['currentschoolid'],3,$student->studentid,$id);
			}				
			
			$this->data['udfs'] = $udfs;

			if($this->data['query']){
			    $this->load->view('templates/header',$this->data);
			    $this->load->view('templates/sidenav');
				$this->load->view('gradebook/add_grades_view', $this->data);
				$this->load->view('templates/footer');						

			}else{
				$this->session->set_flashdata('msgerr', 'No students registered');
				redirect('gradebook','refresh');
			}
			
		}
		else // not logged in - redirect to login controller (login page)
		{
			redirect('login','refresh');
		}
	}


	// The add function returns the view used to add new grade types
	function addgradetype($id)
	{
		
		if($this->session->userdata('logged_in')) // user is logged in
		{	
			$this->load->model('subjects_model');
			//$subject 					= $this->subjects_model->GetSubjectCourseById($id);
$subject = $this->subjects_model->GetSubjectCourseByTermCourseId($id);

			$this->data['page_title'] 	= "Adding Grade Type for \"". $subject->course_title . "\"";

			$this->data['course_id'] 	= $id;

		    $this->load->view('templates/header',$this->data);
		    $this->load->view('templates/sidenav');
			$this->load->view('gradebook/add_gradetype_view', $this->data);
			$this->load->view('templates/footer');						
		}
		else // not logged in - redirect to login controller (login page)
		{
			redirect('login','refresh');
		}
	}

	// The add function returns the view used to edit grade type
	function editgradetype($grade_type_id,$course_id)
	{
		
		if($this->session->userdata('logged_in')) // user is logged in
		{	
			//$grade_type_id = $this->uri->segment(3);
			//$course_id  = $this->uri->segment(4);

			$this->load->model('subjects_model');
			$subject 						= $this->subjects_model->GetSubjectCourseById($course_id);
			$grade_type 					= $this->gradebook_model->GetGradeTypeByID($grade_type_id);
			$this->data['page_title'] 		= "Editing Grade Type for \"". $subject->course_title . "\"";
			$this->data['grade_type'] 		= $grade_type;
			$this->data['course_id'] 		= $course_id;

		    $this->load->view('templates/header',$this->data);
		    $this->load->view('templates/sidenav');
			$this->load->view('gradebook/edit_gradetype_view', $this->data);
			$this->load->view('templates/footer');						
		}
		else // not logged in - redirect to login controller (login page)
		{
			redirect('login','refresh');
		}
	}


	//This will list all the grade type for the specified term course
	function gradetypelist($id)
	{
	
		//$this->load->model('person_model','',TRUE);
		if($this->session->userdata('logged_in')) // user is logged in
		{
			$this->load->model('subjects_model');
			$this->data['query'] 		= $this->gradebook_model->GetGradeTypes($id);	
			$this->data['course_id'] 	= $id;
			//$subject 					= $this->subjects_model->GetSubjectCourseById($id);
			$subject 					= $this->subjects_model->GetSubjectCourseByTermCourseId($id);
			$this->data['page_title'] 	= "Manage Grades for \"". $subject->course_title . "\"";

			$this->breadcrumbcomponent->add($subject->course_title." Grades", '/gradetypelist/'.$id);
			$this->load->view('templates/header', $this->data);
			$this->load->view('templates/sidenav');
			$this->load->view('gradebook/list_gradetypes_view', $this->data);
			$this->load->view('templates/footer');
		}
		else // not logged in - redirect to login controller (login page)
		{
			redirect('login','refresh');
		}
	}


	//This will save entries to the database
	function addrecord()
	{
		// use the CodeIgniter form validation library
   		$this->load->library('form_validation');
		$this->load->helper('udf');
		//$this->load->model('person_model','',TRUE);
		if($this->session->userdata('logged_in')) // user is logged in
		{
			// get session data
			$session_data 		= $this->session->userdata('logged_in');
			
			$grade_type_id  	= $this->input->post('grade_type_id', TRUE);
			$course_id  		= $this->input->post('course_id', TRUE);
			$grade 				= $this->input->post("grade", TRUE);
			$gradeid 			= $this->input->post("gradeid", TRUE);
			$studentid 			= $this->input->post("studentid", TRUE);
			$studentName 		= $this->input->post("studentName", TRUE);
			$oldgrade 			= $this->input->post("oldgrade", TRUE);
			

			foreach ($grade as $key => $value) {
				$this->form_validation->set_rules('grade[' . $key . ']', $studentName[$key] .' grade', 'trim|numeric|required|xss_clean');
				UDF_Validation($this,$studentid[$key]);
			}
			
			$insertData = array();
			$updateData = array();

			if($this->form_validation->run() == FALSE){
				$this->add($grade_type_id);
			}else{

				foreach ($grade as $key => $value) {					
					if (empty($gradeid[$key])){
						$insertData[count($insertData)] = array(							
							'grade_type_id' => $grade_type_id,
							'student_id' => $studentid[ $key],
							'points' => $value					
						);
					}else{
						if ($value != $oldgrade[$key]){
							$updateData[count($updateData)] = array(							
								'grade_id' => $gradeid[$key],
								'grade_type_id' => $grade_type_id,
								'student_id' => $studentid[$key],
								'points' => $value					
							);
						}
					}

					Insert_Update_UDF($this, $studentid[$key], $grade_type_id,$studentid[$key]);
				}
				//$_SESSION["insert"] = $insertData;
				//$_SESSION["update"] = $updateData;
				//$this->add($grade_type_id);
				if (count($insertData) > 0)
					$this->gradebook_model->AddGrades($insertData);

				if (count($updateData) > 0)
					$this->gradebook_model->UpdateGrades($updateData);

			    redirect('gradebook/gradetypelist/' . $course_id);
			}
		}
		else // not logged in - redirect to login controller (login page)
		{
			redirect('login','refresh');
		}
	}

	//This will save entries to the database
	function addgradetyperecord()
	{
		// use the CodeIgniter form validation library
   		$this->load->library('form_validation');
		
		//$this->load->model('person_model','',TRUE);
		if($this->session->userdata('logged_in')) // user is logged in
		{
			// get session data
			$session_data 		= $this->session->userdata('logged_in');
			
			$course_id  		= $this->input->post('course_id', TRUE);
			$title 				= $this->input->post("title", TRUE);
			$weight 			= $this->input->post("weight", TRUE);
			
			$this->form_validation->set_rules('title', 'Title', 'trim|required|xss_clean');

			$this->form_validation->set_rules('weight', 'Weight', 'trim|integer|required|xss_clean');
						
			
			if($this->form_validation->run() == FALSE) 
   			{
				$this->addgradetype($course_id);
			}else{		
				$data = array(
					
					'title' => $title,
					'weight' => $weight,
					'term_course_id' => $course_id 						
				);
		
				$this->gradebook_model->AddGradeType($data);
			    redirect('gradebook/gradetypelist/' . $course_id);
			}
		}
		else // not logged in - redirect to login controller (login page)
		{
			redirect('login','refresh');
		}
	}

	//This will save entries to the database
	function editgradetyperecord()
	{
		// use the CodeIgniter form validation library
   		$this->load->library('form_validation');
		
		//$this->load->model('person_model','',TRUE);
		if($this->session->userdata('logged_in')) // user is logged in
		{
			// get session data
			$session_data 		= $this->session->userdata('logged_in');
			
			$course_id  		= $this->input->post('course_id', TRUE);
			$title 				= $this->input->post("title", TRUE);
			$weight 			= $this->input->post("weight", TRUE);
			$grade_type_id		= $this->input->post("grade_type_id", TRUE);
			
			$this->form_validation->set_rules('title', 'Title', 'trim|required|xss_clean');

			$this->form_validation->set_rules('weight', 'Weight', 'trim|integer|required|xss_clean');
						
			
			if($this->form_validation->run() == FALSE) 
   			{
				$this->editgradetype($grade_type_id, $course_id);
			}else{		
				$data = array(					
					'title' => $title,
					'weight' => $weight,
					'term_course_id' => $course_id 						
				);
		
				$this->gradebook_model->UpdateGradeType($data, $grade_type_id);
				
			    redirect('gradebook/gradetypelist/' . $course_id);
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
			
			
		}
		else // not logged in - redirect to login controller (login page)
		{
			redirect('login','refresh');
		}
	}
	
	
	function courses($subject_id){
		if($this->session->userdata('logged_in')) // user is logged in
		{
			
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