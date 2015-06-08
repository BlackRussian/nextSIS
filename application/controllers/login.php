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
      $this->load->model('user','',TRUE);
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
	   							'expire' => '604800'); //Creates cookie array for storing anchor

				$this->input->set_cookie($cookie); //Store anchor cookie

				//Create view data array
				$data["schid"] = $school->id;
				$data["school_title"] = $school->title;
        $data["school_anchor"] = $param;

				$this->lang->load('login'); // load the login language file - the default language option (unused second parameter) is taken from config.php file 		
				$this->load->view('login_view', $data); // load the standard login form
			}else{
				//redirect('http://www.google.com', 'refresh');
        show_404(); //Shows 404 page if no valid school is found for url anchor
			}
		}
 	}

  public function retreive_password($school_anchor =  "none"){
      $school = $this->school_model->GetSchoolByAnchor($school_anchor); // Get school details using anchor passed in parameter
      
      if($school){
        //Create view data array
        $data["schid"] = $school->id;
        $data["school_title"] = $school->title;
        $data["school_anchor"] = $school_anchor;

        $this->lang->load('login'); // load the login language file - the default language option (unused second parameter) is taken from config.php file     
        $this->load->view('retreive_password', $data); // load the standard login form
      
      }else{
        //redirect('http://www.google.com', 'refresh');
        show_404(); //Shows 404 page if no valid school is found for url anchor
      }
  }

  public function resetpassword(){
      // use the CodeIgniter form validation library
      $this->load->library('form_validation');

      $this->form_validation->set_rules('username', 'login name', 'trim|required|xss_clean');
      
      $this->form_validation->set_rules('email', 'email address', 'trim|required|xss_clean|callback_validate_email');
    
      if($this->form_validation->run() == FALSE) // email and username validation failed
      {
        
        //$this->session->set_flashdata('msgerr', 'Email address and username pair not valid!!');
        
        $stored_anchor = $this->input->cookie("nextsis");

        $this->retreive_password($stored_anchor);
      }
      else{// email and username validation passed - display login page
        
        // generate and update user account with new password
        $newpassword = $this->user->setUserPassword($this->input->post('username'), $this->input->post('schid'), $this->input->post('email'));
        
        $config = Array(
            'protocol' => 'smtp',
            'smtp_host' => 'localhost',
            'smtp_port' => 25,
            //'smtp_user' => 'support@tumpit.com',
            //'smtp_pass' => 'Donotenter.1',
            'mailtype'  => 'html', 
            'charset'   => 'iso-8859-1'
        );
        $this->load->library('email', $config);
        $this->email->from('support@tumpit.com', 'qSIS Support');
        $this->email->to($this->input->post('email'));
        $this->email->subject('qSIS Password Retreival');
        $this->email->message('New Password :'.$newpassword);   
        $this->email->send();

        log_message('debug', $this->email->print_debugger());

        $this->session->set_flashdata('msgerr', 'New password sent. Please check your email.');
        redirect('/login', 'refresh'); //Redirects a default login page
      }
  }

public function validate_email($email)
  {
    $schid = $this->input->post('schid');
    $username = $this->input->post('username');
    
      // return the result of the user model login method (an array if true)
    $result = $this->user->retreivepasswordvalidation($username, $email, $schid);

    if($result)
    {
        return TRUE;
    }
    else
    {
      // load in the login language file (login_lang)
      $this->lang->load('login');
      
      // set the validation message as 'login incorrect' 
        $this->form_validation->set_message('validate_email', "Invalid email and username pair!!");
            
        return FALSE; // validation failed
      } 
  }


  public function chooserole(){
      if($this->session->userdata('choose_role'))
      {
        $session_data = $this->session->userdata('choose_role');
        $role = $this->input->post('role');

        if($role){
          $session_data['role'] = $role;

          $this->session->set_userdata('logged_in', $session_data);
          
          $this->session->unset_userdata('choose_role');

          redirect('home','refresh');
        }else{
          $school               = $this->school_model->GetSchoolById($session_data['currentschoolid']);
          
          //Create view data array
          $data["schid"]        = $school->id;
          $data["school_title"] = $school->title;
          $roles                = $this->user->GetRolesByIds($session_data['role']);
          $data["query"]        = $roles;

          $this->load->view('choose_role_view', $data);
        }
      }else{
        redirect('login','refresh');
      }
  }

	public function authenticate()
	{		
   		 

      // use the CodeIgniter form validation library
   		$this->load->library('form_validation');
   		// field is trimmed, required and xss cleaned respectively
   		$this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
		
		// apply rules and then callback to validate_password method below
   		$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|callback_validate_password');
   		if($this->form_validation->run() == FALSE) // authentication failed - display the login form 
   		{
        
   			$this->session->set_flashdata('msgerr', 'Login Failed!!');
         
        $school = $this->school_model->GetSchoolById($this->input->post('schid'));
        if($school){
          $data["schid"] = $school->id;
          $data["school_title"] = $school->title;
          $data["school_anchor"] = $school->anchor;

   			  $this->load->view('login_view', $data); // load the standard login form
        }else{
          show_404();
        }
   		}
		else{// authentication succeeded - display the homepage

        if($this->session->userdata('logged_in')){
          redirect('home', 'refresh');
        }else{
          redirect('login/chooserole', 'refresh');
        }
   		}
	}
	
 	public function validate_password($password)
 	{
   		// take the posted username
   		$username = $this->input->post('username');

		  $schid = $this->input->post('schid');
   		
   		// return the result of the user model login method (an array if true)
   		$result = $this->user->login($username, $password, $schid);

   		if($result)
   		{
     		$session = null;
     		foreach($result as $row)
     		{
       			$sresult = $this->user->GetSchoolYear($row->default_schoolId);
    				
            $myyear="";
    				
            foreach($sresult as $srow)
    				{
    					
    					$myyear= $srow->syear;
    				}
            
    				$arrResult = $this->user->GetRoles($row->id);
            
            foreach($arrResult as $role){
              $rolearr[] = $role->role_id;
            }

            $rolelist = implode(',', $rolearr);

           	$session = array( 'id'=>$row->id,
                              'fullname'=> $row->first_name.' '.$row->surname,
                              'username' => $row->username,
                              'defaultschoolid' => $row->default_schoolId,
                              'currentschoolid' => $row->default_schoolId,
                              'currentsyear' => $myyear,
                              'role' => $rolelist);
           	
            if(count($rolearr) > 1)
              $this->session->set_userdata('choose_role', $session);
            else
              $this->session->set_userdata('logged_in', $session);
     		}

        return TRUE;
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