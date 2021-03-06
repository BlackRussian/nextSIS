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

class Reports extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		
	}

	function index()
	{
		if($this->session->userdata('logged_in')) // user is logged in
		{
			redirect('reports/dashboard','refresh');
		}
		else // not logged in - redirect to login controller (login page)
		{
			redirect('login','refresh');
		}
	}


	function dashboard()
	{
		if($this->session->userdata('logged_in')) // user is logged in
		{
			// get session data
			$session_data = $this->session->userdata('logged_in');
			
			// set the data associative array that is sent to the header view for navigation and current user information
			$data['username'] = $session_data['username'];
			$data['nav'] = $this->navigation->load('reports');
			$this->load->model('gradelevels_model');

			$result = $this->gradelevels_model->GetGradeLevels($session_data['currentschoolid']);
			
			$resultterms = $this->schoolsemester_model->GetGradeLevels($session_data['currentschoolid']);
			
			$gradelevels["-1"]="Select Grade";
			foreach($result as $row){
            	$gradelevels[$row->id]=$row->title;
        	}

			$data['gradelevels'] = $gradelevels;

			//TODO: define language  $this->lang->load('reports'); // default language option taken from config.php file 	
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidenav');
			$this->load->view('report/report_dashboard');
			$this->load->view('templates/footer');
		}
		else // not logged in - redirect to login controller (login page)
		{
			redirect('login','refresh');
		}
	}

	//Generate report card based on values selected
	function reportcard(){
		if($this->session->userdata('logged_in')) // user is logged in
		{
			$gradelvl_id = $this->input->post('selGradeLevel');
			$class_id = $this->input->post('selClass');
			$student_id = $this->input->post('selStudent');

			//$this->load->view('report/report_card');

			$this->load->library('word');

			$document = $this->word->engine->loadTemplate(APPPATH.'views/report/templates/PBHSReportCard.docx');


			// Variables on different parts of document
			//$document->setValue('weekday', date('l')); // On section/content
			//$document->setValue('time', date('H:i')); // On footer
			//$document->setValue('serverName', realpath(__DIR__)); // On header

			// Simple table
			$document->cloneRow('subjectName', 10);
			$document->cloneRow('attr', 10);
			$document->cloneRow('commenter', 2);

			/*$document->setValue('rowValue#1', 'Sun');
			$document->setValue('rowValue#2', 'Mercury');
			$document->setValue('rowValue#3', 'Venus');
			$document->setValue('rowValue#4', 'Earth');
			$document->setValue('rowValue#5', 'Mars');
			$document->setValue('rowValue#6', 'Jupiter');
			$document->setValue('rowValue#7', 'Saturn');
			$document->setValue('rowValue#8', 'Uranus');
			$document->setValue('rowValue#9', 'Neptun');
			$document->setValue('rowValue#10', 'Pluto');

			$document->setValue('rowNumber#1', '1');
			$document->setValue('rowNumber#2', '2');
			$document->setValue('rowNumber#3', '3');
			$document->setValue('rowNumber#4', '4');
			$document->setValue('rowNumber#5', '5');
			$document->setValue('rowNumber#6', '6');
			$document->setValue('rowNumber#7', '7');
			$document->setValue('rowNumber#8', '8');
			$document->setValue('rowNumber#9', '9');
			$document->setValue('rowNumber#10', '10');

			// Table with a spanned cell
			$document->cloneRow('userId', 3);

			$document->setValue('userId#1', '1');
			$document->setValue('userFirstName#1', 'James');
			$document->setValue('userName#1', 'Taylor');
			$document->setValue('userPhone#1', '+1 428 889 773');

			$document->setValue('userId#2', '2');
			$document->setValue('userFirstName#2', 'Robert');
			$document->setValue('userName#2', 'Bell');
			$document->setValue('userPhone#2', '+1 428 889 774');

			$document->setValue('userId#3', '3');
			$document->setValue('userFirstName#3', 'Michael');
			$document->setValue('userName#3', 'Ray');
			$document->setValue('userPhone#3', '+1 428 889 775');*/

			//Set file name for report
			$name = 'CompletedTemplate.docx';

			//Set path to store temporary report befor download
			$path = APPPATH.'views/report/templates/'.$name;
			
			//Save completed file to server before downloading
			$document->saveAs($path);

			//Download and clean up file
			header('Content-Description: File Transfer');
			header('Content-Type: application/octet-stream');
			header('Content-Disposition: attachment; filename='.$name);
			header('Content-Transfer-Encoding: binary');
			header('Expires: 0');
			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			header('Pragma: public');
			header('Content-Length: ' . filesize($path));
			
			flush();
			readfile($path);

			unlink($path); // deletes the temporary file
		}else{
			redirect('login','refresh');
		}
		
	}

	function class_list()
	{
		if($this->session->userdata('logged_in')) // user is logged in
		{
			// get session data
			$session_data = $this->session->userdata('logged_in');
				
			// set the data associative array that is sent to the home view (and display/send)
			$this->data['username'] 			= $session_data['username'];
			$this->data['currentschoolid'] 		= $session_data['currentschoolid'];
			$this->data['currentsyear'] 		= $session_data['currentsyear'];		
			$this->data['roles'] 				= $session_data['role'];	
			$this->data['id'] 					= $session_data['id'];	
			$this->data['nav'] 					= $this->navigation->load('Report Profile');

			$this->breadcrumbcomponent->add('Student Report Profile', '/reports/class_list');

			$this->load->model('report_model');
			$this->data['query'] = $this->report_model->listing($this->data['roles'], $this->data['id'], $this->data['currentsyear'], $this->data['currentschoolid']);	


			$this->load->view('templates/header', $this->data);
			$this->load->view('templates/sidenav');
			$this->load->view('report/list_class_view', $this->data);
			$this->load->view('templates/footer');
		}
		else // not logged in - redirect to login controller (login page)
		{
			redirect('login','refresh');
		}
	}

	function student_list($class_id)
	{
		if($this->session->userdata('logged_in')) // user is logged in
		{
			// get session data
			$session_data = $this->session->userdata('logged_in');
				
			// set the data associative array that is sent to the home view (and display/send)
			$this->data['username'] 			= $session_data['username'];
			$this->data['currentschoolid'] 		= $session_data['currentschoolid'];
			$this->data['currentsyear'] 		= $session_data['currentsyear'];		
			$this->data['roles'] 				= $session_data['role'];	
			$this->data['id'] 					= $session_data['id'];	
			$this->data['nav'] 					= $this->navigation->load('Report Profile');

			$this->breadcrumbcomponent->add('Student Report Profile', '/reports/class_list');
			$this->breadcrumbcomponent->add('Student List', '/reports/student_list');

			$this->load->model('report_model');
			$this->load->model('person_model');
			$student_listing					= $this->report_model->student_listing($class_id, $this->data['currentsyear'], $this->data['currentschoolid']);	
			
			$function = "";
					
			$results = $this->report_model->GetPersonFunctionByPersonId($this->data['id'],$this->data['currentschoolid']);
			if($results)
			{
				$function = $results->function;
			}
			$fteacher = "";
			$result = $this->person_model->GetStudentClassByStudent($this->data['id'],$this->data['currentsyear'],$this->data['currentschoolid']);
			if($result)
			{
				if($result->class_id == $class_id)
				{
					$fteacher = true;
				}
							
				if($result->class_id != $class_id && $function > 0)
				{
					$this->session->set_flashdata('msgerr','Sorry you do not have access to that class');	
					redirect('/reports/class_list');
				}
			}else{
				$this->session->set_flashdata('msgerr','Sorry you do not have access to that class');	
					redirect('/reports/class_list');
			}
			
			$this->data['query']				= $student_listing;


			$this->data['page_title']			= "";
			if (count($student_listing) > 0){
				$this->data['page_title']		= "Student List for class " . $student_listing[0]->class ;
			}
			
			$this->load->model('school_model');

			$result 							= $this->school_model->GetSchoolTerms($this->data['currentschoolid'], $this->data['currentsyear']);
			
			if($result){
				foreach($result as $row){
	            	$periods[$row->marking_period_id] = $row->title;
	        	}
        	}
			
			$results = $this->report_model->GetPersonFunctionByPersonId($this->data['id'],$this->data['currentschoolid']);
			//echo $results;
			$function="";
			if($results)
			{
				$function = $results->function;
				
			}

			$this->data['periods'] 				= $periods;
			$this->data['class_id'] 			= $class_id;
			$this->data['function'] = $function;
			$this->data['fteacher'] = $fteacher;

			$this->load->view('templates/header', $this->data);
			$this->load->view('templates/sidenav');
			$this->load->view('report/list_student_view', $this->data);
			$this->load->view('templates/footer');
		}
		else // not logged in - redirect to login controller (login page)
		{
			redirect('login','refresh');
		}
	}


	function report_profile($id,$period,$class_id)
	{
		
		if($this->session->userdata('logged_in')) // user is logged in
		{
			// get session data
			$session_data 						= $this->session->userdata('logged_in');
			$this->data['username'] 			= $session_data['username'];
			$this->data['currentschoolid'] 		= $session_data['currentschoolid'];
			$this->data['currentsyear'] 		= $session_data['currentsyear'];		
			$this->data['roles'] 				= $session_data['role'];	
			$this->data['id'] 					= $session_data['id'];	
			$this->data['nav'] 					= $this->navigation->load('Report Profile');

			$this->load->model('udf_model');
			
			// set the data associative array that is sent to the home view (and display/send)
			
			$this->load->helper(array('form', 'url')); // load the html form helper

			$this->lang->load('person'); // default language option taken from config.php file 
			$this->load->model('person_model','',TRUE);
							
			$rows 								= $this->person_model->getpersonbyid($id,$this->data['currentschoolid']);
			$student = "";
			foreach($rows as $row)
			{
				$student = $row->first_name . ((empty($row->middle_name))? "":" ".  strtoupper(substr($row->middle_name,1,1) . ".")). " " . $row->surname;
				//$this->viewdata['fname'] 		= $row->first_name;
				//$this->viewdata['mname'] 		= $row->middle_name;
				//$this->viewdata['lname']		= $row->surname;
				//$this->viewdata['cname'] 		= $row->common_name;
				//$this->viewdata['genderid']		= $row->gender_id;
				//$this->viewdata['titleid'] 		= $row->title_id;
				//$this->viewdata['uname'] 		= $row->username;
				//$this->viewdata['personid'] 	= $row->id;
				//$this->viewdata['dob'] 			= $row->dob;
			}
			
			
			
			$result = $this->person_model->GetStudentClassByStudent($this->data['id'],$this->data['currentsyear'],$this->data['currentschoolid']);
			if($result)
			{
							
				if($result->class_id != $class_id)
				{
					$this->session->set_flashdata('msgerr','Sorry you are not allowed to complete this student'."'".'s report profile');	
					redirect('/reports/student_list/' . $class_id);
				}
			}else{
				$this->session->set_flashdata('msgerr','Sorry you are not allowed to complete this student'."'".'s report profile');	
					redirect('/reports/student_list/'. $class_id);
			}
			
			

			$this->breadcrumbcomponent->add('Student Report Profile', '/reports/class_list');
			$this->breadcrumbcomponent->add('Student List', '/reports/student_list/' . $class_id);
			$this->breadcrumbcomponent->add('Report Profile', '/reports/report_profile');
			
			$this->data['page_title']		= "Report Profile for " . $student ;
			$this->data['student_id']		= $id;
			$this->data['period']			= $period;
			$this->data['class_id']			= $class_id;

			//UDF setup
			$this->data['udf'] 				= $this->udf_model->GetUdfs($this->data['currentschoolid'],2,$id,$period);


			$this->load->view('templates/header', $this->data);
			$this->load->view('templates/sidenav');
			$this->load->view('report/report_profile_view', $this->data);
			$this->load->view('templates/footer');
			
		}
		else // not logged in - redirect to login controller (login page)
		{
			redirect('login','refresh');
		}
	}

	// The editrecord function edits a person
	function updatereportcomments()
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
			$classid= $this->input->post('class_id');
			$periodid = $this->input->post('period');
			$studentid = $this->input->post('student_id');
			$teacherid = $this->input->post('teacherid');
			
			$this->form_validation->set_rules('Comments', 'Comments', 'trim|required|xss_clean');
	
			
			if($this->form_validation->run() == FALSE) 
   			{
				$this->report_comments($studentid,$periodid,$classid);
			}else{
				
				$data = array(
					'student_id' => $studentid,
					'teacher_id' => $teacherid,
					'marking_period_id' => $periodid,
					'comments' => $this->input->post('Comments')
				);

				$this->load->model('report_model');
				//		($data,$studentid,$teacherid,$periodid)		
				$this->report_model->updatepersonreportcomments($data,$studentid,$teacherid,$periodid);
				

				$this->session->set_flashdata('msgsuccess','Record Updated');	
				redirect('/reports/student_list/' . $this->input->post('class_id'));
			}
		}
		else // not logged in - redirect to login controller (login page)
		{
			redirect('login','refresh');
		}
	}

	function report_comments($id,$period,$class_id)
	{
		
		if(isset($id)&&isset($period)&&isset($class_id))
		{
			
		}else{
			redirect('reports/class_list');
		}
		if($this->session->userdata('logged_in')) // user is logged in
		{
			// get session data
			$session_data 						= $this->session->userdata('logged_in');
			$this->data['username'] 			= $session_data['username'];
			$this->data['currentschoolid'] 		= $session_data['currentschoolid'];
			$this->data['currentsyear'] 		= $session_data['currentsyear'];		
			$this->data['roles'] 				= $session_data['role'];	
			$this->data['id'] 					= $session_data['id'];	
			$this->data['nav'] 					= $this->navigation->load('Report Profile');

			$this->load->model('udf_model');
			$this->load->model('report_model');
			
			// set the data associative array that is sent to the home view (and display/send)
			
			$this->load->helper(array('form', 'url')); // load the html form helper

			$this->lang->load('person'); // default language option taken from config.php file 
			$this->load->model('person_model','',TRUE);
			
			$results = $this->report_model->GetPersonFunctionByPersonId($this->data['id'],$this->data['currentschoolid']);
			if($results)
			{
				$function = $results->function;
			}
			
			$result = $this->person_model->GetStudentClassByStudent($this->data['id'],$this->data['currentsyear'],$this->data['currentschoolid']);
			if($result)
			{
							
				if($function > 0)
				{
					$this->session->set_flashdata('msgerr','Sorry you are not allowed to add comments.');	
					redirect('/reports/student_list/'.$class_id);
				}
			}else{
				$this->session->set_flashdata('msgerr','Sorry you do not have access to that class');	
					redirect('/reports/class_list');
			}
			
			
			
				
			$rows 								= $this->person_model->getpersonbyid($id,$this->data['currentschoolid']);
			$student = "";
			foreach($rows as $row)
			{
				$student = $row->first_name . ((empty($row->middle_name))? "":" ".  strtoupper(substr($row->middle_name,1,1) . ".")). " " . $row->surname;
				//$this->viewdata['fname'] 		= $row->first_name;
				//$this->viewdata['mname'] 		= $row->middle_name;
				//$this->viewdata['lname']		= $row->surname;
				//$this->viewdata['cname'] 		= $row->common_name;
				//$this->viewdata['genderid']		= $row->gender_id;
				//$this->viewdata['titleid'] 		= $row->title_id;
				//$this->viewdata['uname'] 		= $row->username;
				//$this->viewdata['personid'] 	= $row->id;
				//$this->viewdata['dob'] 			= $row->dob;
			}
			
			

			$this->breadcrumbcomponent->add('Student Report Profile', '/reports/class_list');
			$this->breadcrumbcomponent->add('Student List', '/reports/student_list/' . $class_id);
			$this->breadcrumbcomponent->add('Comments', '/reports/reports_comments');
			$results = $this->report_model->GetStudentReportComments($id,$this->data['id'],$period);	
			$tcomments = "";
			if($results)
			{
				
				$tcomments = $results->comments;
			}
			$function = "";
			
			
			$results = $this->report_model->GetPersonFunctionByPersonId($this->data['id'],$this->data['currentschoolid']);
			//echo $results;
			$title = "Comments for ";
			if($results)
			{
				$function = $results->function;
				$title = $function."'s Comments for ";
			}
			
			$this->data['comments'] = $tcomments;
			
			$this->data['page_title']		= $title . $student ;
			$this->data['student_id']		= $id;
			$this->data['period']			= $period;
			$this->data['class_id']			= $class_id;
			$this->data['function']			= $function;

			//UDF setup
			//$this->data['udf'] 				= $this->udf_model->GetUdfs($session_data['currentschoolid'],2,$id,$period);


			$this->load->view('templates/header', $this->data);
			$this->load->view('templates/sidenav');
			$this->load->view('report/report_comments_view.php', $this->data);
			$this->load->view('templates/footer');
			
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
			$session_data 				= $this->session->userdata('logged_in');
			$this->load->library('form_validation');
			$this->load->helper('udf');

			// set the data associative array that is sent to the home view (and display/send)
			$data['username'] 			= $session_data['username'];
			
			$this->lang->load('person'); // default language option taken from config.php file 				
			
			//Set the id that should be updated
			$student_id 				= $this->input->post('student_id');
			$class_id 					= $this->input->post('class_id');
			$period 					= $this->input->post('period');
						
			UDF_Validation($this);

			if($this->form_validation->run() == FALSE) 
   			{
   				$this->report_profile($student_id,$period,$class_id);			
			}else{				
				Insert_Update_UDF($this, $student_id, $period);
				$this->session->set_flashdata('msgsuccess','Record Saved');	
				redirect('reports/student_list/'. $class_id,'refresh');
			}
		}
		else // not logged in - redirect to login controller (login page)
		{
			redirect('login','refresh');
		}
	}
}