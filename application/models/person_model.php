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
	public function listing($filter)
 	{
 		$sql = "select person.id, first_name, surname,username, GROUP_CONCAT(role.label SEPARATOR ', ') as roles
	 					from person inner join person_role on person.id = person_role.person_id
						inner join role on person_role.role_id = role.id
						group by first_name,surname,person.id";

 		if($filter){
			$sql = "select person.id, first_name, surname,username, GROUP_CONCAT(role.label SEPARATOR ', ') as roles
	 					from person inner join person_role on person.id = person_role.person_id
						inner join role on person_role.role_id = role.id
						where person_role.role_id = $filter
						group by first_name,surname,person.id";
		}
   		
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
	//Add person model
 	public function addperson($data,$roledata)
 	{
 		//This section will be used to add the person data
 		
		$this->db->insert('person', $data);
		$id = $this->db->insert_id();
		$this->db->flush_cache();
		
		
		//Add the new roles
		if(is_array($roledata))
		{
			foreach($roledata as $itm)
			{
				$rdata = array(
				'person_id' => $id,
				'role_id' => $itm);
				$this->db->insert('person_role',$rdata);
				$this->db->flush_cache();
				
			}
		}
		
		return $id;
 	}
	
	
	
 	//Update person model
 	public function updateperson($id,$data,$roledata)
 	{
 		//This section will be used to update the person data
 		$this->db->where('id', $id);
		$this->db->update('person', $data);
		$this->db->flush_cache();
		
		//Clear the current roles associated with the person
		$this->db->where('person_id', $id);
        $this->db->delete('person_role'); 
		$this->db->flush_cache();
		
		//Add the new roles
		if(is_array($roledata))
		{
			foreach($roledata as $itm)
			{
				$rdata = array(
				'person_id' => $id,
				'role_id' => $itm);
				$this->db->insert('person_role',$rdata);
				$this->db->flush_cache();
				
			}
		}
		
		
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
 	//Get current Person Roles
 	public function getpersonrolesbypersonid($personid)
	{
		// select all the information from the table we want to use with a 10 row limit (for display)
		$this->db->select('person_id,role_id')->from('person_role')->where('person_id',$personid);

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
	
	//Get all Person Roles
	public function GetPersonRoles()
 	{
		// select all the information from the table we want to use with a 10 row limit (for display)
		$this->db->select('id,label')->from('role');

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