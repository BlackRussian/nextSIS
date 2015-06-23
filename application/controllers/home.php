<?php if (!defined('BASEPATH')) exit('No direct script access allowed.');

/* nextSIS home controller
 *
 * PURPOSE 
 * This is the controller which handles the homepage functionality.
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

class Home extends CI_Controller
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
			$this->load->model('dashboard_model');
			// set the data associative array that is sent to the home view (and display/send)
			
			$this->data['currentschoolid'] 		= $session_data['currentschoolid'];
			$this->data['currentsyear'] 		= $session_data['currentsyear'];		
			$this->data['roles'] 				= $session_data['role'];	
			$this->data['id'] 					= $session_data['id'];	
			$data['username'] = $session_data['username'];
			$data['nav'] = $this->navigation->load('home');
			$this->lang->load('home'); // default language option taken from config.php file 
			
			$results = $this->dashboard_model->GetSubjectRegisteredStudentCount($this->getCUrrentPeriodId(), $this->data['id']);	
			
			$data['subjectgradecount'] = $results;
			
			$results = $this->dashboard_model->GetTeacherSubjectList($this->getCUrrentPeriodId(), $this->data['id']);	
			
			$subjects = "";
			if($results)
			{
				$subjects = $results;
			}
			
			$data['teachercourses'] = $subjects;
			$data['roles'] = $this->data['roles'];
			
			$this->load->view('templates/header', $data);	
			$this->load->view('templates/sidenav');
			$this->load->view('home_view', $data);
			$this->load->view('templates/footer', $data);
		}
		else // not logged in - redirect to login controller (login page)
		{
			redirect('login','refresh');
		}
	}
	
	function logout() 
	{
		// log the user out by destroying the session flag, then the session, then redirecting to the login controller		
		$this->session->unset_userdata('logged_in');
		session_destroy();
		redirect('login', 'refresh');
	}

	public function getCUrrentPeriodId()
	{
		return 4;
	}
}

?>