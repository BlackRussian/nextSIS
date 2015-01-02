<?php if (!defined('BASEPATH')) exit('No direct script access allowed.');

/* nextSIS login controller
 *
 * PURPOSE 
 * This is the default controller as defined by /application/config/routes.php. It creates a login class with methods which
 * handle the authentication and login form.
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
  
class Login extends CI_Controller
{
	function _remap($method, $params = array()){
    	if (method_exists($this, $method))
    	{
        	return call_user_func_array(array($this, $method), $params);
    	}else{
        	$this->index($method);
        }
	}

	public function __construct()
 	{
   		parent::__construct();
   		$this->load->model('school_model','',TRUE); //Load school model
 	}

 	public function index($param = "none")
 	{
 		$stored_anchor = $this->input->cookie("nextsis");//Gets school anchor form cookie set last time valid login page was loaded

 		if($stored_anchor != '' && $param == "none"){ 
 			redirect('login/'.$stored_anchor, 'refresh'); //Redirects a default login page to stored anchor page
 		}

 		if($this->session->userdata('logged_in')) { //Checks if user is already logged
 			redirect('home', 'refresh'); //Redirects to home if user is already logged in
 		}
 		else{
			$school = $this->school_model->GetSchoolByAnchor($param); // Get school details using anchor passed in parameter
			
			if(isset($school)){ //check if valid school is found

	       		$cookie = array(
	   							'name' => 'nextsis',
	   							'value'  => $school->anchor,
	   							'expire' => '86500'); //Creates cookie array for storing anchor

				$this->input->set_cookie($cookie); //Store anchor cookie

				//Create view data array
				$data["schid"] = $school->id;
				$data["school_title"] = $school->title;

				$this->load->helper(array('form', 'url')); // load the html form helper
				$this->lang->load('login'); // load the login language file - the default language option (unused second parameter) is taken from config.php file 		
				$this->load->view('login_view', $data); // load the standard login form
			}else{
				show_404(); //Shows 404 page if no valid school is found for url anchor
			}
		}
 	}

	public function authenticate()
	{
		$this->load->model('user','',TRUE);
   		
   		// use the CodeIgniter form validation library
   		$this->load->library('form_validation');
   		// field is trimmed, required and xss cleaned respectively
   		$this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
		
		// apply rules and then callback to validate_password method below
   		$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|callback_validate_password');
   		if($this->form_validation->run() == FALSE) // authentication failed - display the login form 
   		{
   			$this->session->set_flashdata('msgerr', 'Login Failed!!');
   			$this->load->view('login_view'); // load the standard login form
   		}
		else // authentication succeeded - display the homepage
   		{
     		redirect('home', 'refresh');
   		}
	}
	
 	public function validate_password($password)
 	{
   		// take the posted username
   		$username = $this->input->post('username');

		$schid = $this->input->post('schid');
   		
   		// return the result of the user model login method (an array if true)
   		$result = $this->user->login($username, $password, 1);

   		if($result)
   		{
     		$session = array();
     		foreach($result as $row)
     		{
       			$sresult = $this->user->GetSchoolYear($row->default_schoolId);
				$myyear="";
				foreach($sresult as $srow)
				{
					
					$myyear= $srow->syear;
				}

				$arrResult = $this->user->GetRoles($row->id);
				
       			$session = array('id'=>$row->id,'username'=>$row->username,'defaultschoolid'=>$row->default_schoolId,'currentschoolid'=>$row->default_schoolId,'currentsyear'=>$myyear,'roles'=>$arrResult);
       			$this->session->set_userdata('logged_in', $session);
     		}
     		log_message('error', "Failed authentication");
     		return TRUE; // validation succeeded
   		}
   		else
   		{
   			// load in the login language file (login_lang)
			$this->lang->load('login');
			
			// set the validation message as 'login incorrect' 
     		$this->form_validation->set_message('validate_password', $this->lang->line('login_incorrect'));
						
     		return FALSE; // validation failed
   		}	
	}
	
}

?>