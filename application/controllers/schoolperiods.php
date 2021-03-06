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

class Schoolperiods extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('schoolperiods_model');
		$this->lang->load('setup'); // default language option taken from config.php file 	
		
		// get session data
		$session_data = $this->session->userdata('logged_in');
			
		// set the data associative array that is sent to the home view (and display/send)
		$this->data['username'] 			= $session_data['username'];
		$this->data['currentschoolid'] 		= $session_data['currentschoolid'];
		$this->data['currentsyear'] 		= $session_data['currentsyear'];		
		$this->data['roles'] 				= $session_data['role'];	
		$this->data['id'] 					= $session_data['id'];	
		$this->data['nav'] 					= $this->navigation->load('schoolperiods');
		
		$this->breadcrumbcomponent->add('School Periods', '/schoolperiods');
		
	}
	
	function index()
	{
		if($this->session->userdata('logged_in')) // user is logged in
		{
			
			// set the data associative array that is sent to the home view (and display/send)
			
			$this->data['query'] = $this->schoolperiods_model->listing($this->data['currentschoolid'], $this->data['currentsyear']);	
			
			$this->load->view('templates/header', $this->data);
			$this->load->view('templates/sidenav');
			$this->load->view('schoolperiods/schoolperiods_view',  $this->data);
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
			$this->data['username'] = $session_data['username'];
			$this->data['currentschoolid'] = $session_data['currentschoolid'];
			$this->data['currentsyear'] = $session_data['currentsyear'];
			echo "current school year is" .$session_data['currentsyear'] . $session_data['currentschoolid'];
			$this->load->helper(array('form', 'url')); // load the html form helper
			
			$this->data['page_title'] = "Add Period";
			$this->lang->load('setup'); // default language option taken from config.php file 
			$availabletimedata = $this->schoolperiods_model->GetAvailableTimes();
			$availablesortopts = $this->schoolperiods_model->GetSortOrder($session_data['currentschoolid'],$session_data['currentsyear']);
			$this->data['hoursopts'] = 	$availabletimedata['hour'];
			$this->data['minutesopts'] = 	$availabletimedata['minutes'];
			$this->data['allsortopts'] = $availablesortopts['sortopts'];
			
		    $this->load->view('templates/header',$this->data);
			$this->load->view('templates/sidenav');	
			$this->load->view('schoolperiods/add', $this->data);
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
   		$this->form_validation->set_rules('start_time_hr', 'Start Time', 'trim|required|xss_clean|callback_DropDownListHaveValueSelectedstart_check');
		$this->form_validation->set_rules('end_time_hr', 'End Time', 'trim|required|xss_clean|callback_DropDownListHaveValueSelectedend_check');
			
			// set the data associative array that is sent to the home view (and display/send)
			$data['username'] = $session_data['username'];
			$this->lang->load('setup'); // default language option taken from config.php file 	
			//$this->load->view('person_view', $data);
			
			$syear=$this->input->post('syear');
			$school_id=$this->input->post('school_id');
			$sort_order="0";
			if($this->input->post('sort_order') != 'n/a')
			{
				$sort_order=$this->input->post('sort_order');
			}
			$title=$this->input->post('title');
			$short_name=$this->input->post('short_name');
			$start_time=$this->input->post('start_time_hr').":".$this->input->post('start_time_mins')." ".$this->input->post('start_time_ampm');
			$end_time=$this->input->post('end_time_hr').":".$this->input->post('end_time_mins')." ".$this->input->post('end_time_ampm');
			
			//echo strtotime(date('m/d/y'). ' ' .$end_time) . " - " . strtotime(date('m/d/y'). ' ' .$start_time). " " . $length;
			$ignore_scheduling=$this->input->post('ignore_scheduling');
			$attendance=$this->input->post('attendance');
			
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
				$availabletimedata = $this->schoolperiods_model->GetAvailableTimes();
				$data['hoursopts'] = 	$availabletimedata['hour'];
				$data['minutesopts'] = 	$availabletimedata['minutes'];
				$data['title'] = $title;
				$data['start_time'] = $start_time;
				$data['end_time'] = $end_time;
				$data['short_name'] = $short_name;
			    $this->load->view('templates/header',$data);
				$this->load->view('schoolperiods/add', $data);
			}else{
				$time1 = strtotime(date('m/d/y'). ' ' .$end_time);
				$time2 = strtotime(date('m/d/y'). ' ' .$start_time);
				
				//$length=(strtotime(date('m/d/y'). ' ' .$end_time) - (strtotime(date('m/d/y'). ' ' .$start_time))) / 60;
				$length =round(abs($time2 - $time1) / 60,2);
				//$length = $time1->diff($time2);
				//echo $length;
				$newdata = array(
					'syear' => $syear,
					'title' => $title,
					'school_id' => $school_id,
					
					'sort_order' => $sort_order,
					'short_name' => $short_name,
					'start_time' => $start_time,
					'end_time' => $end_time,
					'length' => $length,
					'ignore_scheduling' => $ignore_scheduling,
					'attendance' => $attendance
				);
				
				$this->schoolperiods_model->addschoolperiod($newdata);
			    redirect('schoolperiods/');
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
   		$this->form_validation->set_rules('start_time_hr', 'Start Time', 'trim|required|xss_clean|callback_DropDownListHaveValueSelectedstart_check');
		$this->form_validation->set_rules('end_time_hr', 'End Time', 'trim|required|xss_clean|callback_DropDownListHaveValueSelectedend_check');
		
		
			// set the data associative array that is sent to the home view (and display/send)
			$data['username'] = $session_data['username'];
			
			
			//Set the id that should be updated
			$id= $this->input->post('period_id');
			
			$syear=$this->input->post('syear');
			$school_id=$this->input->post('school_id');
			$sort_order="0";
			if($this->input->post('sort_order') != 'n/a')
			{
				$sort_order=$this->input->post('sort_order');
			}
			$title=$this->input->post('title');
			$short_name=$this->input->post('short_name');
			$start_time=$this->input->post('start_time_hr').":".$this->input->post('start_time_mins')." ".$this->input->post('start_time_ampm');
			$end_time=$this->input->post('end_time_hr').":".$this->input->post('end_time_mins')." ".$this->input->post('end_time_ampm');
			
			//echo strtotime(date('m/d/y'). ' ' .$end_time) . " - " . strtotime(date('m/d/y'). ' ' .$start_time). " " . $length;
			$ignore_scheduling=$this->input->post('ignore_scheduling');
			$attendance=$this->input->post('attendance');
			$period_id = $this->input->post('period_id');
			$db_stime = $this->input->post('db_stime');
			$db_etime = $this->input->post('db_etime');
			
								
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
				$availabletimedata = $this->schoolperiods_model->GetAvailableTimes();
				$data['hoursopts'] = 	$availabletimedata['hour'];
				$data['minutesopts'] = 	$availabletimedata['minutes'];
				$data['title'] = $title;
				$data['start_time'] = $start_time;
				$data['end_time'] = $end_time;
				$data['db_stime'] = $db_stime;
				$data['db_etime'] = $db_etime;
				$data['short_name'] = $short_name;
				$data['attendance'] = $attendance;
				$data['ignore_scheduling']= $ignore_scheduling;
				$data['period_id'] = $period_id;
			    $availablesortopts = $this->schoolperiods_model->GetSortOrder($session_data['currentschoolid'],$session_data['currentsyear']);
			    $data['allsortopts'] = $availablesortopts['sortopts'];
							
			    $this->load->view('templates/header',$data);
				$this->load->view('schoolperiods/edit', $data);
			}else{
				$length=(strtotime(date('m/d/y'). ' ' .$end_time) - (strtotime(date('m/d/y'). ' ' .$start_time))) / 60;
						
				$newdata = array(
					'syear' => $syear,
					'title' => $title,
					'school_id' => $school_id,
					'sort_order' => $sort_order,
					'short_name' => $short_name,
					'start_time' => $start_time,
					'end_time' => $end_time,
					'length' => $length,
					'ignore_scheduling' => $ignore_scheduling,
					'attendance' => $attendance
				);
				
				$this->schoolperiods_model->updateperiodlevel($id,$newdata);
			    redirect('schoolperiods/');
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
				
				$this->data['page_title'] = "Edit School Period";
				$this->lang->load('setup'); // default language option taken from config.php file 	
				//$this->load->view('person_view', $data);
				
				// if the person model returns TRUE then call the view
				if(!$this->load->model('schoolperiods_model','',TRUE))
				{
					
						
					$rows = $this->schoolperiods_model->GetSchoolPeriodById($id);
					foreach($rows as $row)
					{
						$this->data['title'] = $row->title;
						$this->data['school_id'] = $row->school_id;
						$this->data['syear'] = $row->syear;
						$this->data['period_id'] = $row->period_id;
						$this->data['sort_order'] = $row->sort_order;
						$this->data['short_name'] = $row->short_name;
						$this->data['start_time'] = $row->start_time;
						$this->data['end_time'] = $row->end_time;
						$this->data['db_stime'] = $row->start_time;
						$this->data['db_etime'] = $row->end_time;
						$this->data['ignore_scheduling'] = $row->ignore_scheduling;
						$this->data['attendance'] = $row->attendance;
					}
					//$data['gradelevels'] = $this->gradelevels_model->GetGradeLevelsExceptCurrent($session_data['currentschoolid'],$id);	
				}
				$this->breadcrumbcomponent->add('Edit','/schoolperiods/edit/'.$id);
				$availablesortopts = $this->schoolperiods_model->GetSortOrder($session_data['currentschoolid'],$session_data['currentsyear']);
				$availabletimedata = $this->schoolperiods_model->GetAvailableTimes();
				$this->data['hoursopts'] = 	$availabletimedata['hour'];
				$this->data['minutesopts'] = 	$availabletimedata['minutes'];	
				$this->data['allsortopts'] = $availablesortopts['sortopts'];
				$this->load->view('templates/header',$this->data);
				$this->load->view('templates/sidenav');	
				$this->load->view('schoolperiods/edit', $this->data);
				$this->load->view('templates/footer');
				
				
				
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
			if(!$this->load->model('schoolperiods_model','',TRUE))
			{
				//echo "this is a test";
				$this->lang->load('setup'); // default language option taken from config.php file 	
				$data['query'] = $this->schoolperiods_model->listing($data['currentschoolid'],$data['currentsyear']);
				
			}	
			$this->load->view('templates/header', $data);	
			$this->load->view('schoolperiods/schoolperiods_view', $data);
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