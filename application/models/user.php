<?php if (!defined('BASEPATH')) exit('No direct script access allowed.');

/* nextSIS user model
 *
 * PURPOSE 
 * This creates a user class with a login method which retrieves user account information from the database.
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

class User extends CI_Model
{
	// The user login method - takes the username and password ultimately passed from the login screen
	public function login($username, $password, $dschid)
 	{
		// first try to match the username
		$this->db->select('id,username,password,default_schoolId, first_name, surname')->from('person')->where('username',$username)->limit(1);
		$this->db->where('default_schoolId',$dschid)->limit(1);

   		// run the query and return the result
   		$query = $this->db->get();
		
		// if there is one result we have a matching username
   		if($query->num_rows()==1)
   		{
   			// get the correcthash from the database
   			$array = $query->row_array();
   			$correcthash = $array['password'];
			
			// load our tcrypt class and create a new object to work with
			$this->load->library('tcrypt');
 			$tcrypt = new Tcrypt;
			
			// call the password_validate method of the tcrypt class to hash the password and compare it to the correct hash
			// - the method returns true if there is an exact match
			if($tcrypt->password_validate($password,$correcthash))
			{
				// the user-supplied password hash is a match for the correct hash so return the query as an array
				return $query->result();
			}
			else
			{
     			// no soup for you
     			return FALSE;
			}
   		}
		else
		{
			// the username doesn't exist in the database - we won't tell the visitor that - simply return FALSE
			return FALSE;
		}
 	}

	public function GetSchoolYear($schoolid)
	{
		
		// select all the information from the table we want to use with a 10 row limit (for display)
		$this->db->select('id,syear')->from('school')->where('id',$schoolid)->limit(1);

   		// run the query and return the result
   		$query = $this->db->get();
		
		// proceed if records are found
   		if($query->num_rows()>0)
   		{
			// return the data (to the calling controller)
			return $query->result();
   		}
		else
		{
			// there are no records
			return FALSE;
		}
		
	}

	public function GetRoles($person_id)
	{
		
		// select all the information from the table we want to use with a 10 row limit (for display)
		$this->db->select('role_id')->from('person_role')->where('person_id',$person_id);

   		// run the query and return the result
   		$query = $this->db->get();
		
		// proceed if records are found
   		if($query->num_rows()>0)
   		{
			// return the data (to the calling controller)
			return $query->result();
   		}
		else
		{
			// there are no records
			return FALSE;
		}
		
	}
	public function GetRolesByIds($id_list)
	{
		
		// select all the information from the table we want to use with a 10 row limit (for display)
		$sql = "select id,label from role where id in ($id_list)";

		$query = $this->db->query($sql);
		
		// proceed if records are found
   		if($query->num_rows()>0)
   		{
			// return the data (to the calling controller)
			return $query->result();
   		}
		else
		{
			// there are no records
			return FALSE;
		}
		
	}

}

?>