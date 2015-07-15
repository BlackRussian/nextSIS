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
			$data['currentschoolid'] = $this->data['currentschoolid'] ;
			$data['currentsyear'] = $this->data['currentsyear'] ;
			
			$this->lang->load('home'); // default language option taken from config.php file 
			
			
			
			
			$data = $this->getDashBoardData($data);
			
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
	
	public function getDashBoardData($curdata)
	{
		$curdata = $curdata;
		$currperiod = $this->getCUrrentPeriodId($curdata['currentschoolid'],$curdata['currentsyear']);
		$results = $this->dashboard_model->GetSubjectRegisteredStudentCount($currperiod, $this->data['id']);	
		$curdata['subjectgradecount'] = $results;
		$results = $this->dashboard_model->GetTeacherSubjectList($currperiod, $this->data['id']);	
		$subjects = "";
		if($results)
		{
			$subjects = $results;
		}
		$curdata['teachercourses'] = $subjects;
		
		
		$results = $this->dashboard_model->GetCoursesforSemester($currperiod);
		$termcoursecount = "";
		$gradebookcount ="";
		if($results)
		{
			$termcoursecount = count($results);
			$termcourseids = array();
			foreach($results as $result)
			{
					$termcourseids[] = $result->term_course_id;
			}
			if($termcourseids)
			{
				$results = $this->dashboard_model->GetCreatedGradeBooks($termcourseids);
				if($results)
				{
					$gradebookcount = count($results);
				}
			}
		}
		$curdata['termcoursecount'] = $termcoursecount;
		$curdata['gradebookcount'] = $gradebookcount;
		return $curdata;
		
	}
	
	public function getCUrrentPeriodId($schoolId, $syear)
	{
		$this->load->model('schoolsemester_model');
		$periodid = 0;
		$result = $this->schoolsemester_model->GetCurrentSchoolSemester($schoolId,$syear);
		$mydate_timestamp = strtotime("+ 10 days");
		$mydate = date("Y-m-d", $mydate_timestamp);
		$focusid = 0;
		$focusd = "";
		$diff = 1000;
		$mpid = "";
		foreach($result as $r)
		{
			$focusid = $r->marking_period_id;
			$focusd = $r->end_date;
			if($r->start_date <= $mydate && $mydate <= $r->end_date)
			{
				
				$mpid =$r->marking_period_id;
				
			}else{
			
				if($mydate > $r->end_date)
				{
					$mydate = new DateTime();
					//$difval =      $mydate->diff(new DateTime($r->end_date))->format("%a");
					$sdate = new DateTime($r->end_date);
					$difval = round(($mydate->format('U') - $sdate->format('U')) / (60*60*24));
					if( $difval  < $diff)
					{
						$diff = $difval;
						$focusid =$r->marking_period_id;
					}
				}
			}
		}
		
		$myid="";
		if($mpid)
		{
			$myid = $mpid;
		}else{
			$myid  = $focusid;
		}
		
		
		return $myid;
	}
}

?>