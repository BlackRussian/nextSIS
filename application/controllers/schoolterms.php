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

class Schoolterms extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('schoolterms_model');
	}
	
	function index()
	{
		if($this->session->userdata('logged_in')) // user is logged in
		{
			// get session data
			$session_data = $this->session->userdata('logged_in');
			
			// set the data associative array that is sent to the home view (and display/send)
			
			$data['username'] = $session_data['username'];
			$this->lang->load('setup'); // default language option taken from config.php file 	
			$this->load->view('templates/header', $data);
			$this->load->view('schoolterms/schoolterms_view', $data);
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
			echo "current school year is" .$session_data['currentsyear'] . $session_data['currentschoolid'];
			$this->load->helper(array('form', 'url')); // load the html form helper
			$this->lang->load('setup'); // default language option taken from config.php file 
			
			$yearoptions ="";
			$cdate =  date("Y");
			$i=0;
			for($x=$cdate-2;$x<=$cdate+5;$x++)
			{
			
				$yearoptions = $yearoptions . $x . ",";
				$i++;
			}
			//$yearoptions = rtrim($yearoptions,',');
			//$options = array($yearoptions);
			//echo $options;
			$data['years'] =$yearoptions;
			
		    $this->load->view('templates/header',$data);
			$this->load->view('schoolterms/add', $data);
			$this->load->view('templates/footer',$data);
			
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
   		
   		$this->form_validation->set_rules('startdate', 'Start Date', 'trim|required|xss_clean|callback_Startdate_check');
		$this->form_validation->set_rules('enddate', 'End Date', 'trim|required|xss_clean|callback_Enddate_check');
			
			// set the data associative array that is sent to the home view (and display/send)
			$data['username'] = $session_data['username'];
			$this->lang->load('setup'); // default language option taken from config.php file 	
			//$this->load->view('person_view', $data);
			
			$syear=$this->input->post('syear');
			$school_id=$this->input->post('school_id');
			
			$title=$this->input->post('title');
			
			$startdate=$this->input->post('startdate');
			$enddate=$this->input->post('enddate');
			
			//echo strtotime(date('m/d/y'). ' ' .$end_time) . " - " . strtotime(date('m/d/y'). ' ' .$start_time). " " . $length;
			
			
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
				$data['startdate'] = $startdate;
				$data['enddate'] = $enddate;
				
			    $this->load->view('templates/header',$data);
				$this->load->view('schoolterms/add', $data);
			}else{
				
				$sdate = strtotime($startdate);
				$newsdate = date('Y-m-d',$sdate);
				$edate = strtotime($enddate);
				$newedate = date('Y-m-d',$edate);
				
				$newdata = array(
					'syear' => $syear,
					'title' => $title,
					'school_id' => $school_id,
					'startdate' => $newsdate,
					'enddate' => $newedate
					
				);
				
				$this->schoolterms_model->addschoolterms($newdata);
			    redirect('schoolterms/listing');
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
   		
   		$this->form_validation->set_rules('startdate', 'Start Date', 'trim|required|xss_clean|callback_Startdate_check');
		$this->form_validation->set_rules('enddate', 'End Date', 'trim|required|xss_clean|callback_Enddate_check');
		
		
			// set the data associative array that is sent to the home view (and display/send)
			$data['username'] = $session_data['username'];
			
			
			//Set the id that should be updated
			$id= $this->input->post('termid');
			
			$syear=$this->input->post('syear');
			$school_id=$this->input->post('school_id');
			
			$title=$this->input->post('title');
			
			
			$syear=$this->input->post('syear');
			$school_id=$this->input->post('school_id');
			
			
			
			$startdate=$this->input->post('startdate');
			$enddate=$this->input->post('enddate');
			$db_sdate = $this->input->post('db_sdate');
			$db_edate = $this->input->post('db_edate');
			
								
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
				$data['startdate'] = $startdate;
				$data['enddate'] = $enddate;
				$date['db_sdate'] = $db_sdate;
				$date['db_edate'] = $db_edate;
							
			    $this->load->view('templates/header',$data);
				$this->load->view('schoolterms/edit', $data);
			}else{
				
						
				$sdate = strtotime($startdate);
				$newsdate = date('Y-m-d',$sdate);
				$edate = strtotime($enddate);
				$newedate = date('Y-m-d',$edate);
				
				$newdata = array(
					'syear' => $syear,
					'title' => $title,
					'school_id' => $school_id,
					'startdate' => $newsdate,
					'enddate' => $newedate
				);
				
				$this->schoolterms_model->updateschoolterm($id,$newdata);
			    redirect('schoolterms/listing');
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
				if(!$this->load->model('schoolterms_model','',TRUE))
				{
					
						
					$rows = $this->schoolterms_model->GetSchoolTermById($id);
					foreach($rows as $row)
					{
						$data['title'] = $row->title;
						$data['school_id'] = $row->school_id;
						$data['syear'] = $row->syear;
						$data['termid'] = $row->id;
						
						$data['startdate'] = $row->startdate;
						$data['enddate'] = $row->enddate;
						$data['db_sdate'] = $row->startdate;
						$data['db_edate'] = $row->enddate;
						
					}
					//$data['gradelevels'] = $this->gradelevels_model->GetGradeLevelsExceptCurrent($session_data['currentschoolid'],$id);	
				}
				
				$this->load->view('templates/header',$data);
				$this->load->view('schoolterms/edit', $data);
				
				
				
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
			$data['currentsyear'] = $session_data['currentsyear'];
			$this->lang->load('setup'); // default language option taken from config.php file 	
			
			
			// if the person model returns TRUE then call the view
			if(!$this->load->model('schoolterms_model','',TRUE))
			{
				//echo "this is a test";
				$this->lang->load('setup'); // default language option taken from config.php file 	
				$data['query'] = $this->schoolterms_model->listing($data['currentschoolid'],$data['currentsyear']);
				
			}	
			$this->load->view('templates/header',$data);	
			$this->load->view('schoolterms/schoolterms_view', $data);
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