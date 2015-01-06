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

class UDF extends CI_Controller
{
	var $data = null;
	var $types = array(
        		"text"				=>"text",
        		"select"			=>"select"
        	);

    var $validations = array(
				"required" 			=> "required",
				"alpha" 			=> "alpha",
				"alpha_numeric" 	=> "alpha_numeric",
				"alpha_dash" 		=> "alpha_dash",
				"numeric" 			=> "numeric",
				"integer" 			=> "integer",
				"decimal" 			=> "decimal",
				"is_natural" 		=> "is_natural",
				"is_natural_no_zero" => "is_natural_no_zero",
				"valid_email" 		=> "valid_email",
				"valid_emails" 		=> "valid_emails",
				"valid_ip" 			=> "valid_ip",
				"valid_base64" 		=> "valid_base64"
			);
	function __construct()
	{
		parent::__construct();
		$this->load->model('udf_model');
		$this->lang->load('setup');


		// get session data
		$session_data = $this->session->userdata('logged_in');
			
		// set the data associative array that is sent to the home view (and display/send)
		$this->data['username'] 			= $session_data['username'];
		$this->data['currentschoolid'] 		= $session_data['currentschoolid'];
		$this->data['currentsyear'] 		= $session_data['currentsyear'];
		$this->data['id'] 					= $session_data['id'];	
		$this->data['nav'] 					= $this->navigation->load('setup');
	}
	
	function index()
	{
		if($this->session->userdata('logged_in')) // user is logged in
		{

			$this->data['query'] = $this->udf_model->listing($this->data['currentschoolid']);	

			$this->load->view('templates/header', $this->data);
			$this->load->view('templates/sidenav');
			$this->load->view('udf/list_udf_view', $this->data);
			$this->load->view('templates/footer');
		}
		else // not logged in - redirect to login controller (login page)
		{
			redirect('login','refresh');
		}
	}

	
	// The add function returns the view used to add new grades
	function add()
	{
		
		if($this->session->userdata('logged_in')) // user is logged in
		{	
			$result = $this->udf_model->GetUdfCategories();
			$categories[""] 		= "Select Category";

			foreach($result as $row){
            	$categories[$row->category_id] = $row->title;
        	}
        	

			$this->data['categories'] 		= $categories;
			$this->data['types'] 			= $this->types;
			$this->data['validations'] 		= $this->validations;
			$this->data['page_title'] 		= "Adding new User Defined Field";

		    $this->load->view('templates/header',$this->data);
		    $this->load->view('templates/sidenav');
			$this->load->view('udf/add_udf_view', $this->data);
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
		
		//$this->load->model('person_model','',TRUE);
		if($this->session->userdata('logged_in')) // user is logged in
		{
			// get session data
			$session_data 		= $this->session->userdata('logged_in');
			
			$hid_school_id 		= $this->input->post('currentschoolid', TRUE);
			$sel_category  		= $this->input->post('sel_category', TRUE);
			$txt_title  		= $this->input->post('txt_title', TRUE);
			$txt_description 	= $this->input->post("txt_description", TRUE);
			$sel_type 			= $this->input->post("sel_type", TRUE);
			$txt_sort 			= $this->input->post("txt_sort", TRUE);
			$txt_selectoptions 	= $this->input->post("txt_selectoptions", TRUE);
			$sel_validation 	= $this->input->post("sel_validation", TRUE);
			$txt_default 		= $this->input->post("txt_default", TRUE);
			$chk_hidden 		= $this->input->post("chk_hidden", TRUE);
			
			
			$this->form_validation->set_rules('sel_category', 'Category', 'required|xss_clean');
			$this->form_validation->set_rules('txt_title', 'Title', 'trim|required|xss_clean');
			$this->form_validation->set_rules('txt_description', 'Description', 'trim|required|xss_clean');
			$this->form_validation->set_rules('sel_type', 'Select options', 'trim|xss_clean');
			$this->form_validation->set_rules('txt_sort', 'Sort order', 'trim|integer|required|xss_clean');
			$this->form_validation->set_rules('txt_selectoptions', 'Select options', 'trim|xss_clean');
			$this->form_validation->set_rules('sel_validation[]', 'Validation', 'trim|xss_clean');
			$this->form_validation->set_rules('txt_default', 'Default', 'trim|xss_clean');
			
			if($this->form_validation->run() == FALSE) 
   			{
				$this->add();
			}else{
				$data = array(
					'school_id' 		=> $hid_school_id,
					'type' 				=> $sel_type ,
					'title'				=> $txt_title,
					'description' 		=> $txt_description,
					'sort_order' 		=> $txt_sort,
					'select_options' 	=> implode("\r\n",array_unique(explode("\r\n", $txt_selectoptions))),
					'category_id' 		=> $sel_category,
					'validation' 		=> implode("|", $sel_validation),
					'default_selection'	=> $txt_default,
					'hide' 				=> (empty($chk_hidden) ? "0" : $chk_hidden)					
				);			
				
				$this->udf_model->AddUDF($data);

			    redirect('udf/');
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
			    $result = $this->udf_model->GetUdfCategories();
				$categories[""] 		= "Select Category";

				foreach($result as $row){
	            	$categories[$row->category_id] = $row->title;
	        	}

	        	$editudf = $this->udf_model->GetUdfByID($id);

	        	if ($editudf){
					$this->data['udf'] 				= $editudf;
					$this->data['udf_id'] 			= $id;
					$this->data['categories'] 		= $categories;
					$this->data['types'] 			= $this->types;
					$this->data['validations'] 		= $this->validations;
					$this->data['page_title'] 		= "Editing User Defined Field";

				    $this->load->view('templates/header',$this->data);
				    $this->load->view('templates/sidenav');
					$this->load->view('udf/edit_udf_view', $this->data);
					$this->load->view('templates/footer');	
				}else{
					$this->session->set_flashdata('msgerr', 'Error retrieving User Defined Field');
					redirect('udf','refresh');
				}
			}
			else // not logged in - redirect to login controller (login page)
			{
				redirect('login','refresh');
			}
	}
	
	// The editrecord function edits a person
	function editrecord()
	{
		
		if($this->session->userdata('logged_in')) // user is logged in
		{

			$this->load->library('form_validation');
		
			$session_data 		= $this->session->userdata('logged_in');
			
			$udf_id		 		= $this->input->post('udf_id', TRUE);
			$hid_school_id 		= $this->input->post('currentschoolid', TRUE);
			$sel_category  		= $this->input->post('sel_category', TRUE);
			$txt_title  		= $this->input->post('txt_title', TRUE);
			$txt_description 	= $this->input->post("txt_description", TRUE);
			$sel_type 			= $this->input->post("sel_type", TRUE);
			$txt_sort 			= $this->input->post("txt_sort", TRUE);
			$txt_selectoptions 	= $this->input->post("txt_selectoptions", TRUE);
			$sel_validation 	= $this->input->post("sel_validation", TRUE);
			$txt_default 		= $this->input->post("txt_default", TRUE);
			$chk_hidden 		= $this->input->post("chk_hidden", TRUE);
			
			
			$this->form_validation->set_rules('sel_category', 'Category', 'required|xss_clean');
			$this->form_validation->set_rules('txt_title', 'Title', 'trim|required|xss_clean');
			$this->form_validation->set_rules('txt_description', 'Description', 'trim|required|xss_clean');
			$this->form_validation->set_rules('sel_type', 'Select options', 'trim|xss_clean');
			$this->form_validation->set_rules('txt_sort', 'Sort order', 'trim|integer|required|xss_clean');
			$this->form_validation->set_rules('txt_selectoptions', 'Select options', 'trim|xss_clean');
			$this->form_validation->set_rules('sel_validation[]', 'Validation', 'trim|xss_clean');
			$this->form_validation->set_rules('txt_default', 'Default', 'trim|xss_clean');
			
			if($this->form_validation->run() == FALSE) 
   			{
				$this->edit();
			}else{
				$data = array(
					'school_id' 		=> $hid_school_id,
					'type' 				=> $sel_type ,
					'title'				=> $txt_title,
					'description' 		=> $txt_description,
					'sort_order' 		=> $txt_sort,
					'select_options' 	=> implode("\r\n",array_unique(explode("\r\n", $txt_selectoptions))),
					'category_id' 		=> $sel_category,
					'validation' 		=> implode("|", $sel_validation),
					'default_selection'	=> $txt_default,
					'hide' 				=> (empty($chk_hidden) ? "0" : $chk_hidden)					
				);			
				
				$this->udf_model->UpdateUDF($data, $udf_id);

			    redirect('udf/');
			}			
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