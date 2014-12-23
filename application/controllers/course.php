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

class Course extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		
	}
	
	function index()
	{
		if($this->session->userdata('logged_in')) // user is logged in
		{
			// get session data
			$session_data = $this->session->userdata('logged_in');
			
			// set the data associative array that is sent to the home view (and display/send)
			
			$data['username'] = $session_data['username'];
			$data['nav'] = $this->navigation->load('courses');
			
			$this->lang->load('course'); // load language file
			
			$this->load->view('templates/header',$data);
			$this->load->view('templates/sidenav');
			$this->load->view('courses_view', $data);
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
		
		
	}
	//This will save entry to the database
	function addrecord()
	{
		
		
	}
	
	// The editrecord function edits a person
	function editrecord()
	{
		//$this->load->model('person_model','',TRUE);
		if($this->session->userdata('logged_in')) // user is logged in
		{

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

			}
			else // not logged in - redirect to login controller (login page)
			{
				redirect('login','refresh');
			}
	}
}

?>