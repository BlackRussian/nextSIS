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
	var $viewdata = null;
	function __construct()
	{
		parent::__construct();
		$this->load->model('schoolterms_model');
		$this->load->model('schoolyear_model');
		$this->load->model('dbfunctions_model');
		$session_data = $this->session->userdata('logged_in');
		// set the data associative array common values that is sent to the views of this controller
		$this->viewdata['username'] 		= $session_data['username'];
		$this->viewdata['currentschoolid'] 	= $session_data['currentschoolid'];
		$this->viewdata['currentsyear'] 	= $session_data['currentsyear'];
		$this->viewdata['nav'] 				= $this->navigation->load('courses');
		
		$this->breadcrumbcomponent->add('School Years','/schoolyear');
		//$this->breadcrumbcomponent->add('School Terms', '/schoolterms');
	}
	function _remap($method, $params = array()){
    	if (method_exists($this, $method))
    	{
        	return call_user_func_array(array($this, $method), $params);
    	}else{
        	$this->index($method);
        }
	}
	
	function addSemesterBreadCrumb($yearid)
	{
		//$result = $this->schoolquarter_model->GetSchoolTermById($semesterid);
		$this->breadcrumbcomponent->add('School Terms', '/schoolterms/'.$yearid);
		//$this->breadcrumbcomponent->add('School Quarter','/schoolquarter/'.$semesterid);
	}
	
	function index($filter = null)
	{
		if($this->session->userdata('logged_in')) // user is logged in
		{
			
			// set the data associative array that is sent to the home view (and display/send)
			//$data['username'] = $session_data['username'];
			//$data['currentschoolid'] = $session_data['currentschoolid'];
			//$data['currentsyear'] = $session_data['currentsyear'];
			$this->lang->load('setup'); // default language option taken from config.php file 	
			
			
			// if the person model returns TRUE then call the view
			if(!$this->load->model('schoolterms_model','',TRUE))
			{
				//echo "this is a test";
				$this->lang->load('setup'); // default language option taken from config.php file 	
				if($filter)
				{
					$this->viewdata['query'] = $this->schoolterms_model->listing($filter, $this->viewdata['currentschoolid']);
					$this->viewdata['yearid'] = $filter;	
					$this->addSemesterBreadCrumb($filter);
				}else{
					$this->session->set_flashdata('msgerr','Please select the year to manage');	
					redirect('schoolyear','refresh');
				}
				
				
				if($filter && $this->viewdata['query']){
				$this->breadcrumbcomponent->add($this->viewdata['query'][0]->syeartitle,'schoolterms/'.$filter);
				$this->viewdata['syeartitle'] = $this->viewdata['query'][0]->syeartitle;
				}
				
					
			}	
			$this->load->view('templates/header',$this->viewdata);	
			$this->load->view('templates/sidenav', $this->viewdata);
			$this->load->view('schoolterms/schoolterms_view', $this->viewdata);
			$this->load->view('shared/display_notification', $this->viewdata);
			$this->load->view('templates/footer',$this->viewdata);	
		}
		else // not logged in - redirect to login controller (login page)
		{
			redirect('login','refresh');
		}
	}
	
	// The add function returns the view used to add a new period
	function add($yearid = null)
	{
		
		if($this->session->userdata('logged_in')) // user is logged in
		{
			// get session data
			
			
			
			$this->load->helper(array('form', 'url')); // load the html form helper
			$this->lang->load('setup'); // default language option taken from config.php file 
			
			$year = $this->schoolterms_model->GetSchoolYearById($yearid);
			$this->viewdata['page_title'] 	= "Add Semester/Term for - " . $year->syear;
			
			$this->viewdata['year_id'] = $year->marking_period_id;
			$this->viewdata['schoolyear'] = $year->syear;
			$this->addSemesterBreadCrumb($yearid);
			$this->breadcrumbcomponent->add('Add','/schoolterm/add');
			
		    $this->load->view('templates/header',$this->viewdata);
		    $this->load->view('templates/sidenav',$this->viewdata);
			$this->load->view('schoolterms/add_schoolterms_view', $this->viewdata);
			$this->load->view('templates/footer',$this->viewdata);
			
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
			
		
		// field is trimmed, required and xss cleaned respectively
   		$this->form_validation->set_rules('title', 'Title', 'trim|required|xss_clean');
		$this->form_validation->set_rules('short_name', 'Short Name', 'trim|required|xss_clean');
		// apply rules and then callback to validate_password method below
   		
   		$this->form_validation->set_rules('start_date', 'Start Date', 'trim|required|xss_clean|callback_Startdate_check');
		$this->form_validation->set_rules('end_date', 'End Date', 'trim|required|xss_clean|callback_Enddate_check');
			
			// set the data associative array that is sent to the home view (and display/send)
			
			$this->lang->load('setup'); // default language option taken from config.php file 	
			//$this->load->view('person_view', $data);
			
			$syear=$this->input->post('schoolyear');
			$school_id=$this->input->post('school_id');
			
			$title=$this->input->post('title');
			$year_id = $this->input->post('year_id');
			
			$startdate=$this->input->post('start_date');
			$enddate=$this->input->post('end_date');
			$short_name = $this->input->post('short_name');
			
			
			if($this->form_validation->run() == FALSE) // authentication failed - display the login form 
   			{
				
				$this->add($year_id);
			}else{
				
				$sdate = strtotime($startdate);
				$newsdate = date('Y-m-d',$sdate);
				$edate = strtotime($enddate);
				$newedate = date('Y-m-d',$edate);
				$markingperiodid = $this->dbfunctions_model->getMarkingPeriodId();
					$newdata = array(
					'marking_period_id' => $markingperiodid,
					'syear' => $syear,
					'title' => $title,
					'short_name' => $short_name,
					'year_id' => $year_id,
					'school_id' => $school_id,
					'start_date' => $newsdate,
					'end_date' => $newedate
					
				);
				
				$this->schoolterms_model->addschoolterms($newdata);
			
				$msg = "Record Saved - " . $title;
				$this->session->set_flashdata('msgsuccess', $msg);	
			    redirect('schoolterms/' . $year_id);
			}
				
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
		$this->form_validation->set_rules('short_name', 'Short Name', 'trim|required|xss_clean');
		// apply rules and then callback to validate_password method below
   		
   		$this->form_validation->set_rules('start_date', 'Start Date', 'trim|required|xss_clean|callback_Startdate_check');
		$this->form_validation->set_rules('end_date', 'End Date', 'trim|required|xss_clean|callback_Enddate_check');
			
			// set the data associative array that is sent to the home view (and display/send)
			
			$this->lang->load('setup'); // default language option taken from config.php file 	
			//$this->load->view('person_view', $data);
			
			$syear=$this->input->post('schoolyear');
			$school_id=$this->input->post('school_id');
			
			$title=$this->input->post('title');
			$year_id = $this->input->post('year_id');
			$semesterid = $this->input->post('semesterid');
			$startdate=$this->input->post('start_date');
			$enddate=$this->input->post('end_date');
			$short_name = $this->input->post('short_name');
			
			
								
			if($this->form_validation->run() == FALSE) // authentication failed - display the login form 
   			{
				$this->edit($semesterid);
			}else{
				
						
				$sdate = strtotime($startdate);
				$newsdate = date('Y-m-d',$sdate);
				$edate = strtotime($enddate);
				$newedate = date('Y-m-d',$edate);
				
					$newdata = array(
					
					'syear' => $syear,
					'title' => $title,
					'short_name' => $short_name,
					'year_id' => $year_id,
					'school_id' => $school_id,
					'start_date' => $newsdate,
					'end_date' => $newedate
					
				);
				
				$this->schoolterms_model->updateschoolterm($semesterid,$newdata);
			    $msg = "Record Updated - " . $title;
				$this->session->set_flashdata('msgsuccess', $msg);
			    redirect('schoolterms/'.$year_id);
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
			    
				// set the data associative array that is sent to the home view (and display/send)
				$this->load->helper(array('form', 'url')); // load the html form helper
				
				$this->lang->load('setup'); // default language option taken from config.php file 	
				//$this->load->view('person_view', $data);
				
				
				
				
				//$this->breadcrumbcomponent->add('Add','/schoolterm/add');
			
		    
				// if the person model returns TRUE then call the view
				if(!$this->load->model('schoolterms_model','',TRUE))
				{
					
						
					$rows = $this->schoolterms_model->GetSchoolTermById($id);
					$this->viewdata['semesterobj'] = $rows;
					$this->viewdata['page_title'] = "Edit School Semester/Term";
					$this->addSemesterBreadCrumb($rows->year_id);
					$this->breadcrumbcomponent->add('Edit','/schoolterm/edit');
					//$data['gradelevels'] = $this->gradelevels_model->GetGradeLevelsExceptCurrent($session_data['currentschoolid'],$id);	
				}
				
				$this->load->view('templates/header',$this->viewdata);
		    $this->load->view('templates/sidenav',$this->viewdata);
			$this->load->view('schoolterms/edit_schoolterms_view', $this->viewdata);
			$this->load->view('templates/footer',$this->viewdata);
				
				
				
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
				$this->viewdata['query'] = $this->schoolterms_model->listing($this->viewdata['currentschoolid'],$this->viewdata['currentsyear']);
				
			}	
			$this->load->view('templates/header',$this->viewdata);	
			$this->load->view('schoolterms/schoolterms_view', $this->viewdata);
			$this->load->view('templates/footer',$this->viewdata);	
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