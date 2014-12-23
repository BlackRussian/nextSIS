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

class Reports extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		
	}

	function index()
	{
		if($this->session->userdata('logged_in')) // user is logged in
		{
			redirect('reports/dashboard','refresh');
		}
		else // not logged in - redirect to login controller (login page)
		{
			redirect('login','refresh');
		}
	}


	function dashboard()
	{
		if($this->session->userdata('logged_in')) // user is logged in
		{
			// get session data
			$session_data = $this->session->userdata('logged_in');
			
			// set the data associative array that is sent to the header view for navigation and current user information
			$data['username'] = $session_data['username'];
			$data['nav'] = $this->navigation->load('reports');
			$this->load->model('gradelevels_model');

			$result = $this->gradelevels_model->GetGradeLevels($session_data['currentschoolid']);
			
			$gradelevels["-1"]="Select Grade";
			foreach($result as $row){
            	$gradelevels[$row->id]=$row->title;
        	}

			$data['gradelevels'] = $gradelevels;

			//TODO: define language  $this->lang->load('reports'); // default language option taken from config.php file 	
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidenav');
			$this->load->view('report/report_dashboard');
			$this->load->view('templates/footer');
		}
		else // not logged in - redirect to login controller (login page)
		{
			redirect('login','refresh');
		}
	}

	//Generate report card based on values selected
	function reportcard(){
		if($this->session->userdata('logged_in')) // user is logged in
		{
			$gradelvl_id = $this->input->post('selGradeLevel');
			$class_id = $this->input->post('selClass');
			$student_id = $this->input->post('selStudent');

			//$this->load->view('report/report_card');

			$this->load->library('word');

			$document = $this->word->engine->loadTemplate(APPPATH.'views/report/templates/PBHSReportCard.docx');


			// Variables on different parts of document
			//$document->setValue('weekday', date('l')); // On section/content
			//$document->setValue('time', date('H:i')); // On footer
			//$document->setValue('serverName', realpath(__DIR__)); // On header

			// Simple table
			$document->cloneRow('subjectName', 10);
			$document->cloneRow('attr', 10);
			$document->cloneRow('commenter', 2);

			/*$document->setValue('rowValue#1', 'Sun');
			$document->setValue('rowValue#2', 'Mercury');
			$document->setValue('rowValue#3', 'Venus');
			$document->setValue('rowValue#4', 'Earth');
			$document->setValue('rowValue#5', 'Mars');
			$document->setValue('rowValue#6', 'Jupiter');
			$document->setValue('rowValue#7', 'Saturn');
			$document->setValue('rowValue#8', 'Uranus');
			$document->setValue('rowValue#9', 'Neptun');
			$document->setValue('rowValue#10', 'Pluto');

			$document->setValue('rowNumber#1', '1');
			$document->setValue('rowNumber#2', '2');
			$document->setValue('rowNumber#3', '3');
			$document->setValue('rowNumber#4', '4');
			$document->setValue('rowNumber#5', '5');
			$document->setValue('rowNumber#6', '6');
			$document->setValue('rowNumber#7', '7');
			$document->setValue('rowNumber#8', '8');
			$document->setValue('rowNumber#9', '9');
			$document->setValue('rowNumber#10', '10');

			// Table with a spanned cell
			$document->cloneRow('userId', 3);

			$document->setValue('userId#1', '1');
			$document->setValue('userFirstName#1', 'James');
			$document->setValue('userName#1', 'Taylor');
			$document->setValue('userPhone#1', '+1 428 889 773');

			$document->setValue('userId#2', '2');
			$document->setValue('userFirstName#2', 'Robert');
			$document->setValue('userName#2', 'Bell');
			$document->setValue('userPhone#2', '+1 428 889 774');

			$document->setValue('userId#3', '3');
			$document->setValue('userFirstName#3', 'Michael');
			$document->setValue('userName#3', 'Ray');
			$document->setValue('userPhone#3', '+1 428 889 775');*/

			//Set file name for report
			$name = 'CompletedTemplate.docx';

			//Set path to store temporary report befor download
			$path = APPPATH.'views/report/templates/'.$name;
			
			//Save completed file to server before downloading
			$document->saveAs($path);

			//Download and clean up file
			header('Content-Description: File Transfer');
			header('Content-Type: application/octet-stream');
			header('Content-Disposition: attachment; filename='.$name);
			header('Content-Transfer-Encoding: binary');
			header('Expires: 0');
			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			header('Pragma: public');
			header('Content-Length: ' . filesize($path));
			
			flush();
			readfile($path);

			unlink($path); // deletes the temporary file
		}else{
			redirect('login','refresh');
		}
		
	}
}