<?php if (!defined('BASEPATH')) exit('No direct script access allowed.');

/* nextSIS person model
 *
 * PURPOSE 
 * This creates a person class with methods for retrieving information from the database about people.
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

class Person_model extends CI_Model
{
	// The listing method takes gets a list of people in the database 
	public function listing()
 	{
		// select all the information from the table we want to use with a 10 row limit (for display)
		$this->db->select('id,surname,first_name,middle_name,common_name,title_id,gender_id,local_id')->from('person')->limit(10);

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
 	//Update person model
 	public function updateperson($id,$data)
 	{
 		$this->db->where('id', $id);
		$this->db->update('person', $data);
 	}
 	//Get Person by person id
	public function getpersonbyid($personid)
 	{
 		
		// select all the information from the table we want to use with a 10 row limit (for display)
		$this->db->select('id,surname,first_name,middle_name,common_name,title_id,gender_id,local_id,username')->from('person')->where('id',$personid);

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
 	
 	//Get all Person Genders
	public function GetPersonGender($langid)
 	{
		// select all the information from the table we want to use with a 10 row limit (for display)
		$this->db->select('id,language_id,label')->from('person_gender')->where('language_id',$langid)->limit(10);

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
	//Get all Person Titles
	public function GetPersonTitles($langid)
 	{
		// select all the information from the table we want to use with a 10 row limit (for display)
		$this->db->select('id,language_id,label')->from('person_title')->where('language_id',$langid)->limit(10);

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

?>