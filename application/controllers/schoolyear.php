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

class SchoolYear extends CI_Controller
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

		$this->load->model('schoolyear_model');
		$this->load->model('dbfunctions_model');

		$this->breadcrumbcomponent->add('School Years','/schoolyear');
	}
	function _remap($method, $params = array()){
    	if (method_exists($this, $method))
    	{
        	return call_user_func_array(array($this, $method), $params);
    	}else{
        	$this->index($method);
        }
	}
	
	function index()
	{
		if($this->session->userdata('logged_in')) // user is logged in
		{
			if(!$this->load->model('schoolyear_model','',TRUE))
			{
				$this->lang->load('setup'); // default language option taken from config.php file 	
				$this->viewdata['query'] = $this->schoolyear_model->listing($this->viewdata['currentschoolid']);
				//$this->viewdata['gradelevels'] = $this->schoolyear_model->GetSchoolYears($this->viewdata['currentschoolid']);
			}

			$this->load->view('templates/header', $this->viewdata);
			$this->load->view('templates/sidenav', $this->viewdata);
			$this->load->view('schoolyear/schoolyear_view', $this->viewdata);

			$this->load->view('templates/footer');
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
			
			
			$this->load->helper(array('form', 'url')); // load the html form helper
			$this->lang->load('setup'); // default language option taken from config.php file 
			
			
			$this->viewdata['page_title'] 	= "Add School Year";
			
		    $this->load->view('templates/header',$this->viewdata);
		    $this->load->view('templates/sidenav',$this->viewdata);
			$this->load->view('schoolyear/add_schoolyear_view', $this->viewdata);
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
			$syear = $this->input->post('syear');
			
			if($this->form_validation->run() == FALSE) // authentication failed - display the login form 
   			{
		
				// set the data associative array that is sent to the home view (and display/send)
					
				/*$this->load->helper(array('form', 'url')); // load the html form helper
				$this->lang->load('setup'); // default language option taken from config.php file 
				$this->viewdata['title'] = $title;
				$this->viewdata['short_name'] = $short_name;
				$this->viewdata['start_date'] = $start_date;
				$this->viewdata['end_date'] = $end_date;
				$yearoptions ="";
				$cdate =  date("Y");
				$i=0;
				for($x=$cdate-2;$x<=$cdate+5;$x++)
				{
				
					$yearoptions = $yearoptions . $x . ",";
					$i++;
				}
				$this->viewdata['years'] =$yearoptions;*/
				$this->add();
				  
				}else{
					
					$sdate = strtotime($start_date);
					$newsdate = date('Y-m-d',$sdate);
					$edate = strtotime($end_date);
					
					$newedate = date('Y-m-d',$edate);
					
					$markingperiodid = $this->dbfunctions_model->getMarkingPeriodId();
					$cdate = date("Y", $sdate);
					
					$newdata = array(
						'marking_period_id' => $markingperiodid,
						'syear' => $cdate,
						'title' => $title,
						'short_name' => $short_name,
						'school_id' => $this->viewdata['currentschoolid'],
						'start_date' => $newsdate,
						'end_date' => $newedate
						
					);
					
				$this->schoolyear_model->addschoolyear($newdata);
				$this->session->set_flashdata('msgsuccess','Record Saved');	
				redirect('schoolyear', 'refresh');
				
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
			if(!$this->load->model('schoolyear_model','',TRUE))
			{
				$schoolyear = $this->schoolyear_model->GetSchoolYearById($id);
				
				
				$this->viewdata['schoolyearobj'] = $schoolyear;
				$this->viewdata['page_title'] = "Edit School Year";

				
			}

			$this->breadcrumbcomponent->add('Edit','/schoolyear/edit/'.$id);

			$this->load->view('templates/header',$this->viewdata);
			$this->load->view('templates/sidenav', $this->viewdata);
			$this->load->view('schoolyear/edit_schoolyear_view', $this->viewdata);
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
		$this->load->library('form_validation');

		if($this->session->userdata('logged_in')) // user is logged in
		{			
			$this->form_validation->set_rules('title', 'Title', 'trim|required|xss_clean');
		
		// apply rules and then callback to validate_password method below
   		
   		$this->form_validation->set_rules('start_date', 'Start Date', 'trim|required|xss_clean|callback_Startdate_check');
		$this->form_validation->set_rules('end_date', 'End Date', 'trim|required|xss_clean|callback_Enddate_check');
		$this->form_validation->set_rules('short_name', 'Short Name', 'trim|required|xss_clean');

			//Set the id that should be updated
			$id = $this->input->post('schoolyear_id');
			$school_id = $this->input->post('school_id');
			$title =$this->input->post('title');
			
			$short_name = $this->input->post('short_name');
			$start_date=$this->input->post('start_date');
			$end_date=$this->input->post('end_date');
			$syear = $this->input->post('syear');

			if($this->form_validation->run() == FALSE) 
   			{
   				$this->edit($id);
			}else{
					$sdate = strtotime($start_date);
					$newsdate = date('Y-m-d',$sdate);
					$edate = strtotime($end_date);
					
					$newedate = date('Y-m-d',$edate);
					
					
					$cdate = date("Y", $sdate);
					
					$newdata = array(
						
						'syear' => $cdate,
						'title' => $title,
						'short_name' => $short_name,
						'school_id' => $school_id,
						'start_date' => $newsdate,
						'end_date' => $newedate
						
					);
					
					$this->schoolyear_model->UpdateSchoolYear($id,$newdata);
					$updmsg = $title . " Update";
					$this->session->set_flashdata('msgsuccess',$updmsg);	
					redirect('schoolyear', 'refresh');
			}
				
			
		}
		else // not logged in - redirect to login controller (login page)
		{
			redirect('login','refresh');
		}
	}
}

?>