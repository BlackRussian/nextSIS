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

class Student_model extends CI_Model
{
	function __construct()
	{
		// Call the Model constructor
    		parent::__construct();
	}


	public function GetStudentByClass($classid){

		// select all the information from the table we want to use with a 10 row limit (for display)
		$this->db->select('id,surname,first_name,common_name')->from('person')->where('classid', $classid);

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
}