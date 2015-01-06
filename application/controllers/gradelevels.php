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

class Gradelevels extends CI_Controller
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

		$this->load->model('gradelevels_model');

		$this->breadcrumbcomponent->add('Grade Levels','/gradelevels');
	}
	
	function index()
	{
		if($this->session->userdata('logged_in')) // user is logged in
		{
			if(!$this->load->model('gradelevels_model','',TRUE))
			{
				$this->lang->load('setup'); // default language option taken from config.php file 	
				$this->viewdata['query'] = $this->gradelevels_model->listing($this->viewdata['currentschoolid']);
				$this->viewdata['gradelevels'] = $this->gradelevels_model->GetGradeLevels($this->viewdata['currentschoolid']);
			}

			$this->load->view('templates/header', $this->viewdata);
			$this->load->view('templates/sidenav', $this->viewdata);
			$this->load->view('gradelevels/gradelevels_view', $this->viewdata);
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

			$result				= $this->gradelevels_model->GetGradeLevels($this->viewdata['currentschoolid']);
			$gradelevels[""] 	= "Select Grade";

			foreach($result as $row){
            	$gradelevels[$row->id] = $row->title;
        	}

			$this->viewdata['gradelevels'] 	= $gradelevels;	
			$this->viewdata['page_title'] 	= "Add Grade Level";
			
			$this->breadcrumbcomponent->add('Add','/gradelevels/add');

		    $this->load->view('templates/header',$this->viewdata);
		    $this->load->view('templates/sidenav',$this->viewdata);
			$this->load->view('gradelevels/add_gradelevel_view', $this->viewdata);
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
		$this->load->library('form_validation');

		if($this->session->userdata('logged_in')) // user is logged in
		{			
			// field is trimmed, required and xss cleaned respectively
   			$this->form_validation->set_rules('title', 'Title', 'trim|required|xss_clean');

			if($this->form_validation->run() == FALSE) 
   			{
   				$this->add();
			}else{
				if($this->input->post('selGradeLevel') == "")
				{
					$data = array(
						'title' => $this->input->post('title'),
						'school_id' => $this->input->post('school_id')
					);

				}else{
					$data = array(
						'title' => $this->input->post('title'),
						'next_grade_id' => $this->input->post('selGradeLevel'),
						'school_id' => $this->input->post('school_id')
					);
				}

				$this->gradelevels_model->AddGradeLevel($data);
				redirect('gradelevels', 'refresh');
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
			if(!$this->load->model('gradelevels_model','',TRUE))
			{
				$gradelevel = $this->gradelevels_model->GetGradeLevelById($id);
				
				$this->viewdata['gradelevelobj'] = $gradelevel;
				$this->viewdata['page_title'] = "Edit Grade Level";

				$result		= $this->gradelevels_model->GetGradeLevelsExceptCurrent($this->viewdata['currentschoolid'], $id);
				$gradelevels[""] = "Select Grade";

				foreach($result as $row){
	            	$gradelevels[$row->id] = $row->title;
	        	}

				$this->viewdata['gradelevels'] = $gradelevels;	
			}

			$this->breadcrumbcomponent->add('Edit','/gradelevels/edit/'.$id);

			$this->load->view('templates/header',$this->viewdata);
			$this->load->view('templates/sidenav', $this->viewdata);
			$this->load->view('gradelevels/edit_gradelevel_view', $this->viewdata);
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
			// field is trimmed, required and xss cleaned respectively
   			$this->form_validation->set_rules('title', 'Title', 'trim|required|xss_clean');

			//Set the id that should be updated
			$id = $this->input->post('gradelevel_id');

			if($this->form_validation->run() == FALSE) 
   			{
   				$this->edit($id);
			}else{
				if($this->input->post('selGradeLevel') == "")
				{
					$data = array(
						'title' => $this->input->post('title')
					);

				}else{
					$data = array(
						'title' => $this->input->post('title'),
						'next_grade_id' => $this->input->post('selGradeLevel')
					);
				}
			}
				
			$this->gradelevels_model->UpdateGradeLevel($id,$data);

			redirect('gradelevels', 'refresh');
		}
		else // not logged in - redirect to login controller (login page)
		{
			redirect('login','refresh');
		}
	}
}

?>