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

class SchoolQuarter extends CI_Controller
{

	var $viewdata = null;

	function __construct()
	{
		parent::__construct();
		//$this->output->enable_profiler(TRUE);
		$session_data = $this->session->userdata('logged_in');
		//$this->data = array();
		
		// set the data associative array common values that is sent to the views of this controller
		$this->viewdata['username'] 		= $session_data['username'];
		$this->viewdata['currentschoolid'] 	= $session_data['currentschoolid'];
		$this->viewdata['currentsyear'] 	= $session_data['currentsyear'];
		$this->viewdata['nav'] 				= $this->navigation->load('setup');

		$this->load->model('schoolquarter_model');
		$this->load->model('dbfunctions_model');

		$this->breadcrumbcomponent->add('School Quarter','/schoolquarter');
	}
	
	function _remap($method, $params = array()){
    	if (method_exists($this, $method))
    	{
        	return call_user_func_array(array($this, $method), $params);
    	}else{
        	$this->index($method);
        }
	}
	function index($semesterid = null)
	{
		if($this->session->userdata('logged_in')) // user is logged in
		{
			
			$this->lang->load('setup'); // default language option taken from config.php file 
			if($semesterid)	
			{
				$this->viewdata['query'] = $this->schoolquarter_model->listing($semesterid,$this->viewdata['currentschoolid']);
			}else{
				$this->session->set_flashdata('msgerr','Please select the year to manage');	
				redirect('schoolyear','refresh');
			}
			
			
		
			$this->viewdata['semesterid'] = $semesterid;
			
			
			$this->load->view('templates/header', $this->viewdata);
			$this->load->view('templates/sidenav', $this->viewdata);
			$this->load->view('schoolquarter/schoolquarter_view', $this->viewdata);
			$this->load->view('shared/display_notification', $this->viewdata);
			$this->load->view('templates/footer');
		}
		else // not logged in - redirect to login controller (login page)
		{
			redirect('login','refresh');
		}
	}
	
	// The add function adds a person
	function add($semesterid = null)
	{
		
		if($this->session->userdata('logged_in')) // user is logged in
		{

			/*$result				= $this->schoolquarter_model->GetGradeLevels($this->viewdata['currentschoolid']);
			$gradelevels[""] 	= "Select Grade";

			if($result){
				foreach($result as $row){
            		$gradelevels[$row->id] = $row->title;
        		}
			}
			
			$this->viewdata['gradelevels'] 	= $gradelevels;	*/
			$term = $this->schoolquarter_model->GetSemesterBySemesterId($semesterid);
			$this->viewdata['page_title'] 	= "Add Quarter for - " . $term->syear. " " . $term->title;
			$this->viewdata['semester_id'] = $term->marking_period_id;
			$this->viewdata['year_id'] = $term->year_id;
			$this->viewdata['schoolyear'] = $term->syear;
			
			$this->breadcrumbcomponent->add('Add','/schoolquarter/add');

		    $this->load->view('templates/header',$this->viewdata);
		    $this->load->view('templates/sidenav',$this->viewdata);
			$this->load->view('schoolquarter/add_schoolquarter_view', $this->viewdata);
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
		
		// field is trimmed, required and xss cleaned respectively
   		$this->form_validation->set_rules('title', 'Title', 'trim|required|xss_clean');
		
		// apply rules and then callback to validate_password method below
   		
   		$this->form_validation->set_rules('start_date', 'Start Date', 'trim|required|xss_clean|callback_Startdate_check');
		$this->form_validation->set_rules('end_date', 'End Date', 'trim|required|xss_clean|callback_Enddate_check');
		$this->form_validation->set_rules('short_name', 'Short Name', 'trim|required|xss_clean');
		
			
			// set the data associative array that is sent to the home view (and display/send)
			
			$this->lang->load('setup'); // default language option taken from config.php file 	
				
			$title =$this->input->post('title');
			$short_name = $this->input->post('short_name');
			$start_date=$this->input->post('start_date');
			$end_date=$this->input->post('end_date');
			$syear = $this->input->post('schoolyear');
			$semesterid = $this->input->post('semester_id');
			$yearid = $this->input->post('year_id');
			
			if($this->form_validation->run() == FALSE) // authentication failed - display the login form 
   			{
		
				
				$this->add($semesterid);
				  
				}else{
					
					$sdate = strtotime($start_date);
					$newsdate = date('Y-m-d',$sdate);
					$edate = strtotime($end_date);
					
					$newedate = date('Y-m-d',$edate);
					
					$markingperiodid = $this->dbfunctions_model->getMarkingPeriodId();
					$cdate = date("Y", $sdate);
					
					$newdata = array(
						'marking_period_id' => $markingperiodid,
						'syear' => $syear,
						'title' => $title,
						'semester_id' => $semesterid,
						'year_id' => $yearid,
						'short_name' => $short_name,
						'school_id' => $this->viewdata['currentschoolid'],
						'start_date' => $newsdate,
						'end_date' => $newedate
						
					);
					
				$this->schoolquarter_model->addschoolquarter($newdata);
				$msg = "Record Saved - " . $title;
				$this->session->set_flashdata('msgsuccess', $msg);	
				redirect('schoolquarter/' . $semesterid);
				
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
			if(!$this->load->model('schoolquarter_model','',TRUE))
			{
				$schoolquarter = $this->schoolquarter_model->GetSchoolQuarterById($id);
				
				
				$this->viewdata['schoolquarterobj'] = $schoolquarter;
				$this->viewdata['page_title'] = "Edit School Quarter";

				
			}

			$this->breadcrumbcomponent->add('Edit','/schoolquarter/edit/'.$id);

			$this->load->view('templates/header',$this->viewdata);
			$this->load->view('templates/sidenav', $this->viewdata);
			$this->load->view('schoolquarter/edit_schoolquarter_view', $this->viewdata);
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
		// use the CodeIgniter form validation library
   		$this->load->library('form_validation');
		
		//$this->load->model('person_model','',TRUE);
		if($this->session->userdata('logged_in')) // user is logged in
		{
			
			// get session data
		
		// field is trimmed, required and xss cleaned respectively
   		$this->form_validation->set_rules('title', 'Title', 'trim|required|xss_clean');
		
		// apply rules and then callback to validate_password method below
   		
   		$this->form_validation->set_rules('start_date', 'Start Date', 'trim|required|xss_clean|callback_Startdate_check');
		$this->form_validation->set_rules('end_date', 'End Date', 'trim|required|xss_clean|callback_Enddate_check');
		$this->form_validation->set_rules('short_name', 'Short Name', 'trim|required|xss_clean');
		
			
			// set the data associative array that is sent to the home view (and display/send)
			
			$this->lang->load('setup'); // default language option taken from config.php file 	
				
			$title =$this->input->post('title');
			$short_name = $this->input->post('short_name');
			$start_date=$this->input->post('start_date');
			$end_date=$this->input->post('end_date');
			$syear = $this->input->post('schoolyear');
			$semesterid = $this->input->post('semester_id');
			$yearid = $this->input->post('year_id');
			$markingperiodid = $this->input->post('schoolquarter_id');
			$schoolid = $this->input->post('school_id');
			echo $syear;
			if($this->form_validation->run() == FALSE) // authentication failed - display the login form 
   			{
		
				
				$this->edit($markingperiodid);
				  
				}else{
					
					$sdate = strtotime($start_date);
					$newsdate = date('Y-m-d',$sdate);
					$edate = strtotime($end_date);
					
					$newedate = date('Y-m-d',$edate);
					
					$cdate = date("Y", $sdate);
					
					$newdata = array(
						
						'syear' => $syear,
						'title' => $title,
						'semester_id' => $semesterid,
						'year_id' => $yearid,
						'short_name' => $short_name,
						'school_id' => $schoolid,
						'start_date' => $newsdate,
						'end_date' => $newedate
						
					);
					
				$this->schoolquarter_model->UpdateSchoolQuarter($markingperiodid,$newdata);
				$msg = "Record Updated - " . $title;
				$this->session->set_flashdata('msgsuccess', $msg);	
				redirect('schoolquarter/' . $semesterid);
				
			}
			
		}

		else // not logged in - redirect to login controller (login page)
		{
			redirect('login','refresh');
		}
	}
}

?>