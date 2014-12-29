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
	function __construct()
	{
		parent::__construct();
		$this->load->model('subjects_model');
		$this->lang->load('setup');
	}
	
	function index()
	{
		if($this->session->userdata('logged_in')) // user is logged in
		{
			// get session data
			$session_data = $this->session->userdata('logged_in');
			
			// set the data associative array that is sent to the home view (and display/send)
			
			// set the data associative array that is sent to the home view (and display/send)
			$data['username'] = $session_data['username'];
			$data['currentschoolid'] = $session_data['currentschoolid'];
			$data['currentsyear'] = $session_data['currentsyear'];
			$data['query'] = $this->subjects_model->listing($data['currentschoolid']);	
			$data['nav'] = $this->navigation->load('setup');

			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidenav', $data);
			$this->load->view('subjects/subjects_view', $data);
			$this->load->view('templates/footer', $data);
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
			$this->load->view('subjects/add', $data);
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
					// get session data
				$session_data = $this->session->userdata('logged_in');
				
				$data['username'] = $session_data['username'];
				$data['currentschoolid'] = $session_data['currentschoolid'];
				$data['currentsyear'] = $session_data['currentsyear'];
				$data['nav'] = $this->navigation->load('setup');

				$this->load->helper(array('form', 'url')); // load the html form helper
				$this->lang->load('setup');
				
			    $this->load->view('templates/header',$data);
			    $this->load->view('templates/sidenav',$data);
				$this->load->view('subjects/add', $data);
				$this->load->view('templates/footer');
			}else{
				
								
				$newdata = array(
					
					'title' => $title,
					'school_id' => $school_id,
					'short_name' => $short_name
					
				);
				
				$this->subjects_model->addschoolsubject($newdata);
			    redirect('subjects/listing');
			}

			//$this->gradelevels_model->addgradelevel($data);
			//redirect('gradelevels','listing');
		}
		else // not logged in - redirect to login controller (login page)
		{
			redirect('login','refresh');
		}
	}
	
	//validate start time
	public function DropDownListHaveValueSelectedstart_check($str)
	{
		//$session_data = $this->session->userdata('logged_in');
		//$data['username'] = $session_data['username'];
		$syear=$this->input->post('syear');
		$school_id=$this->input->post('school_id');
		
		$mins = $this->input->post('start_time_mins');
		$ampm = $this->input->post('start_time_ampm');
		if ($str == 'n/a' || $mins=='n/a' || $ampm == 'n/a')
		{
			$this->form_validation->set_message('DropDownListHaveValueSelectedstart_check', 'The %s field value not valid');
			return FALSE;
		}
		else
		{
			$start_time=$this->input->post('start_time_hr').":".$this->input->post('start_time_mins')." ".$this->input->post('start_time_ampm');
			//$end_time=$this->input->post('end_time_hr').":".$this->input->post('end_time_mins')." ".$this->input->post('end_time_ampm');
			$istimeuniq = $this->schoolperiods_model->IsUniqueStartTime($start_time,$syear,$school_id);
			
			if($this->input->post('db_stime') == $start_time)
			{
				return true;
			}
			
			if($istimeuniq == true)
			{
				return TRUE;
			}else{
				$this->form_validation->set_message('DropDownListHaveValueSelectedstart_check', 'Unique %s field is required');
				return FALSE;
			}
		}
		
		
			
	}
	//validate end time
	public function DropDownListHaveValueSelectedend_check($str)
	{
		$mins = $this->input->post('end_time_mins');
		$ampm = $this->input->post('end_time_ampm');
		
		$syear=$this->input->post('syear');
		$school_id=$this->input->post('school_id');
		if ($str == 'n/a' || $mins=='n/a' || $ampm == 'n/a')
		{
			$this->form_validation->set_message('DropDownListHaveValueSelectedend_check', 'The %s field value not valid');
			return FALSE;
		}
		else
		{
			//$end_time=$this->input->post('end_time_hr').":".$this->input->post('start_time_mins')." ".$this->input->post('start_time_ampm');
			$end_time=$this->input->post('end_time_hr').":".$this->input->post('end_time_mins')." ".$this->input->post('end_time_ampm');
			$istimeuniq = $this->schoolperiods_model->IsUniqueEndTime($end_time,$syear,$school_id);
			//echo $istimeuniq . " " . $syear . " " . $school_id . " " . $start_time;
			//echo is_array($istimeuniq);
			if($this->input->post('db_etime') == $end_time)
			{
				return true;
			}
			
			if($istimeuniq == true)
			{
				return TRUE;
			}else{
				$this->form_validation->set_message('DropDownListHaveValueSelectedend_check', 'Unique %s field is required');
				return FALSE;
			}
		}
	}
	// The editrecord function edits a person
	function editrecord()
	{
		//$this->load->model('person_model','',TRUE);
		
		if($this->session->userdata('logged_in')) // user is logged in
		{
			// use the CodeIgniter form validation library
   		$this->load->library('form_validation');
		
			// get session data
		$session_data = $this->session->userdata('logged_in');
			
		// field is trimmed, required and xss cleaned respectively
   		$this->form_validation->set_rules('title', 'Title', 'trim|required|xss_clean');
		
		// apply rules and then callback to validate_password method below
   		
   		$this->form_validation->set_rules('short_name', 'Short Name', 'trim|required|xss_clean');
		
		
		
			// set the data associative array that is sent to the home view (and display/send)
			$data['username'] = $session_data['username'];
			
			
			//Set the id that should be updated
			$id= $this->input->post('subjectid');
			
			
			$school_id=$this->input->post('school_id');
			
			$title=$this->input->post('title');
			
			
			$short_name=$this->input->post('short_name');
			
			
			
								
			if($this->form_validation->run() == FALSE) // authentication failed - display the login form 
   			{
					// get session data
				$session_data = $this->session->userdata('logged_in');
				
				// set the data associative array that is sent to the home view (and display/send)
				//$this->session->userdata('currentschoolid')
				$data['username'] = $session_data['username'];
				$data['currentschoolid'] = $session_data['currentschoolid'];
				$data['currentsyear'] = $session_data['currentsyear'];
				$this->load->helper(array('form', 'url')); // load the html form helper
				$this->lang->load('setup'); // default language option taken from config.php file 
				
				
				$data['title'] = $title;
				$data['school_id'] = $school_id;
				$data['id'] = $id;
				$date['short_name'] = $short_name;
			
							
			    $this->load->view('templates/header',$data);
				$this->load->view('subjects/edit', $data);
			}else{
				
			
				$newdata = array(
					
					'title' => $title,
					'short_name' => $short_name,
					'school_id' => $school_id
					
				);
				
				$this->subjects_model->updateschoolsubject($id,$newdata);
			    redirect('subjects/listing');
			}
			
			
			
				
			//$this->gradelevels_model->updategradelevel($id,$data);
			//redirect('gradelevels/listing');
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
				$this->lang->load('setup'); // default language option taken from config.php file 	
				//$this->load->view('person_view', $data);
				
				// if the person model returns TRUE then call the view
				if(!$this->load->model('subjects_model','',TRUE))
				{
					
						
					$rows = $this->subjects_model->GetSchoolSubjectById($id);
					foreach($rows as $row)
					{
						$data['title'] = $row->title;
						$data['school_id'] = $row->school_id;
						$data['short_name'] = $row->short_name;
						$data['id'] = $row->id;
						
						
						
					}
					//$data['gradelevels'] = $this->gradelevels_model->GetGradeLevelsExceptCurrent($session_data['currentschoolid'],$id);	
				}
				
				$this->load->view('templates/header',$data);
				$this->load->view('subjects/edit', $data);
				
				
				
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