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

class Grades extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('grades_model');
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
		// use the CodeIgniter form validation library
   		$this->load->library('form_validation');
		
		//$this->load->model('person_model','',TRUE);
		if($this->session->userdata('logged_in')) // user is logged in
		{
			// get session data
			$session_data = $this->session->userdata('logged_in');

			// apply rules and then callback to validate_password method below
			   		
	   		$this->form_validation->set_rules('weight', 'Weighting', 'trim|required|decimal|xss_clean|');
			//$this->form_validation->set_rules('enddate', 'End Date', 'trim|required|xss_clean|callback_Enddate_check');
			
			// set the data associative array that is sent to the home view (and display/send)
			$data['username'] = $session_data['username'];
			$this->lang->load('setup'); // default language option taken from config.php file 	
			$this->load->view('grades/edit', $data);
			
			//Set the id that should be updated
			$id= $this->input->post('gradeid');
			$courseid = $this->input->post('course_id');
			$gradetypeid = $this->input->post('gradetype_id');
			$studentid = $this->input->post('student_id');
			$gradetitle = $this->input->post('grade_title');
			$actualscore = $this->input->post('actualscore');
			$weight = $this->input->post('weight');
			$grade = $this->input->post('grade');
			if($this->form_validation->run() == FALSE) // authentication failed - display the login form 
   			{
   				$data['id'] = $id;
				$data['courseid'] = $courseid;
				$cid = $courseid;
				$data['gradetypeid'] = $gradetypeid;
				$data['studentid'] = $studentid;
				$data['grade_title'] = $gradetitle;
				$data['grade'] = $grade;
				$data['actualscore'] = $actualscore;
				$data['weight'] = $weight;
			}else{
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
				if(!$this->load->model('grades_model','',TRUE))
				{
					echo "this is a test edit";
					$this->lang->load('person'); // default language option taken from config.php file 	
					
					$rows = $this->grades_model->GetGradeById($id);
					$cid = '';
					foreach($rows as $row)
					{
						$data['id'] = $row->id;
						$data['courseid'] = $row->course_id;
						$cid = $row->course_id;
						$data['gradetypeid'] = $row->gradetype_id;
						$data['studentid'] = $row->student_id;
						$data['grade_title'] = $row->grade_title;
						$data['grade'] = $row->grade;
						$data['actualscore'] = $row->actualscore;
						$data['weight'] = $row->weight;
					}
					
					$data['teachercourses'] = $this->grades_model->GetTeacherCoursesByYear($session_data['id'],$session_data['currentsyear']);
					$data['gradetypes'] = $this->grades_model->GetGradeTypes();
					$data['availablestudents'] = $this->grades_model->GetStudentsWhoSitCourse($cid);
				//	$data['roles'] = $this->person_model->GetPersonRoles();
					//$data['personroles'] = $this->person_model->getpersonrolesbypersonid($id);
				}		
				$this->load->view('grades/edit', $data);
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
			$this->load->helper(array('form', 'url')); // load the html form helper
			// set the data associative array that is sent to the home view (and display/send)
			$data['username'] = $session_data['username'];
			$data['currentsyear'] = $session_data['currentsyear'];
			$data['currentuserid'] = $session_data['id'];
			$this->lang->load('setup'); // default language option taken from config.php file 	
			//$this->load->view('person_view', $data);
			
			$courseid = $this->input->post('course');
			if($courseid <= '0')
			{
				$courseid = '0';
			}
			
			
			// if the person model returns TRUE then call the view
			if(!$this->load->model('grades_model','',TRUE))
			{
				//echo "this is a test, courseid is:" . $courseid;
				$this->lang->load('person'); // default language option taken from config.php file 	
				$data['query'] = $this->grades_model->listing($courseid);
				$data['courses'] = $this->grades_model->GetTeacherCoursesByYear($data['currentuserid'],$data['currentsyear']);
				$data['courseid'] = $courseid;

			}	
			$data['nav'] = $this->navigation->load('courses');
			$this->load->view('templates/header', $data);		
			$this->load->view('grades/view', $data);
		}
		else // not logged in - redirect to login controller (login page)
		{
			redirect('login','refresh');
		}
	}
	
	// The logout function logs out a person from the database
	function logout()
	{
		$session_data = $this->session->userdata('logged_in');
		$defaultschoolid = $session_data['defaultschoolid'];
		// log the user out by destroying the session flag, then the session, then redirecting to the login controller		
		$this->session->unset_userdata('logged_in');
		session_destroy();
		redirect('login', 'refresh');
	}
}

?>