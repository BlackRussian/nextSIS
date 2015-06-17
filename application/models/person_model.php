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
	public function listing($filter, $school_id, $ajax=FALSE)
 	{
 		if($ajax){
 			
 			if($filter != ""){
 				$this->datatables->select("person.id, first_name, surname, middle_name, common_name, username, GROUP_CONCAT(role.label SEPARATOR ', ') as roles,role.id as roleid", FALSE);
				$this->datatables->from('person');
				$this->datatables->join('person_role', 'person.id = person_role.person_id');
				$this->datatables->join('role', 'person_role.role_id = role.id');
				$this->datatables->where('school_id = default_schoolid');
				$this->datatables->where('default_schoolid', $school_id);
				$this->datatables->where('person_role.role_id', $filter);
				$this->datatables->group_by('first_name,surname,person.id,middle_name, common_name');
				$this->datatables->edit_column('edit', '<a href="/person/edit/$1">edit</a>', 'id');
				
				if($filter && ($filter=="3" || $filter=="2")){
					$this->datatables->edit_column('assign', '<a href="/person/assignclass/$1/$2">assign class</a>', 'id,roleid');	
				}
				if($filter && $filter=="3"){
					$this->datatables->edit_column('reports', '<a href="/person/assignclass/$1">reports</a>', 'id');		
				}

				return $this->datatables->generate();
 			}else{
	 			
	 			$this->datatables->select("person.id, first_name, surname, middle_name, common_name, username, GROUP_CONCAT(role.label SEPARATOR ', ') as roles", FALSE);
				$this->datatables->from('person');
				$this->datatables->join('person_role', 'person.id = person_role.person_id');
				$this->datatables->join('role', 'person_role.role_id = role.id');
				$this->datatables->where('school_id = default_schoolid');
				$this->datatables->where('default_schoolid', $school_id);
				$this->datatables->group_by('first_name,surname,person.id,middle_name, common_name');
				$this->datatables->edit_column('edit', '<a href="/person/edit/$1">edit</a>', 'id');
				
				return $this->datatables->generate();
			}
 		}
 		else
 		{
	 		$sql = "select person.id, first_name, surname, middle_name, common_name, username, GROUP_CONCAT(role.label SEPARATOR ', ') as roles
		 					from person inner join person_role on person.id = person_role.person_id
							inner join role on person_role.role_id = role.id
							where person.default_schoolId=$school_id
							group by first_name,surname,person.id,middle_name, common_name limit 10";

	 		if($filter){
				$sql = "select person.id, first_name, surname, middle_name, common_name, username, GROUP_CONCAT(role.label SEPARATOR ', ') as roles
		 					from person inner join person_role on person.id = person_role.person_id
							inner join role on person_role.role_id = role.id
							where person_role.role_id = $filter and person.default_schoolId=$school_id
							group by first_name,surname,person.id,middle_name, common_name limit 10";
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
 	}




	//Add person model
 	public function addperson($data,$roledata,$schoolid)
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
				'role_id' => $itm,
				'school_id' => $schoolid);
				$this->db->insert('person_role',$rdata);
				$this->db->flush_cache();
				
			}
		}

		return $id;
 	}
	
	
	
 	//Update person model
 	public function updateperson($id,$data,$roledata,$schoolid)
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
				'role_id' => $itm,
				'school_id' => $schoolid);
				$this->db->insert('person_role',$rdata);
				$this->db->flush_cache();
				
			}
		}
		
		
 	}
 	//Get Person by person id
	public function getpersonbyid($personid, $schoolid)
 	{
 		
		// select all the information from the table we want to use with a 10 row limit (for display)
		$this->db->select('id,surname,first_name,middle_name,common_name,title_id,gender_id,local_id,username, dob, email')->from('person');
		$this->db->join('person_role','person.id = person_role.person_id');
		$this->db->where('person.id',$personid)->where('person_role.school_id', $schoolid);

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

	//Get Person by person id
	public function GetUserProfileInfo($personid, $schoolid)
 	{
 		
		// select all the information from the table we want to use with a 10 row limit (for display)
		$this->db->select("person.id, first_name,middle_name, surname,common_name, username, GROUP_CONCAT(role.label SEPARATOR ', ') as roles, person_title.label as title, person_gender.label as gender, dob, email",FALSE);
		$this->db->from('person');
		$this->db->join('person_role','person.id = person_role.person_id');
		$this->db->join('role','person_role.role_id = role.id');
		$this->db->join('person_title','person.title_id = person_title.id');
		$this->db->join('person_gender','person.gender_id = person_gender.id');
		$this->db->where('person.id',$personid)->where('person_role.school_id',$schoolid);
		$this->db->group_by("first_name,surname,person.id");

   		// run the query and return the result
   		$query = $this->db->get();
		
		// proceed if records are found
   		if($query->num_rows()>0)
   		{
			// return the data (to the calling controller)
			return $query->row();
   		}
		else
		{
			// there are no records
			return FALSE;
		}
 	}

	public function validate_oldpwd($id,$pwd)
	{
		$this->db->select('id,username,password,default_schoolId, first_name, surname')->from('person')->where('id',$id)->limit(1);
		
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
			if($tcrypt->password_validate($pwd,$correcthash))
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
	public function UpdateUserPassword($id,$data)
	{
		// select all the information from the table we want to use with a 10 row limit (for display)
		$this->db->select('id,username,password,default_schoolId, first_name, surname')->from('person')->where('id',$id)->limit(1);

   		// run the query and return the result
   		$query = $this->db->get();
		
		// proceed if records are found
   		if($query->num_rows()>0)
   		{
   			$this->db->flush_cache();
			$this->db->where('id', $id);
			$this->db->update('person', $data);
			$this->db->flush_cache();
   		}
		
	}
	public function updatepersonclass($personid, $year, $data)
	{
		// select all the information from the table we want to use with a 10 row limit (for display)
		$this->db->select('person_id,class_id')->from('person_class')->where('person_id',$personid)->where('year', $year);

   		// run the query and return the result
   		$query = $this->db->get();
		
		// proceed if records are found
   		if($query->num_rows()>0)
   		{
   			$this->db->flush_cache();
			$this->db->where('person_id', $personid);
			$this->db->where('year', $year);
			$this->db->update('person_class', $data);
			$this->db->flush_cache();
   		}
		else
		{
			// there are no records
			$this->db->insert('person_class', $data);
			$this->db->flush_cache();
		}
		
	}
	public function updatepersonclassandCourse($personid, $year, $data,$courses)
	{
		// select all the information from the table we want to use with a 10 row limit (for display)
		$this->db->select('person_id,class_id')->from('person_class')->where('person_id',$personid)->where('year', $year);

   		// run the query and return the result
   		$query = $this->db->get();
		
		// proceed if records are found
   		if($query->num_rows()>0)
   		{
   			$this->db->flush_cache();
			$this->db->where('person_id', $personid);
			$this->db->where('year', $year);
			$this->db->update('person_class', $data);
			$this->db->flush_cache();
   		}
		else
		{
			// there are no records
			$this->db->insert('person_class', $data);
			$this->db->flush_cache();
		}
		
		
		//Clear the current roles associated with the person
		$this->db->where('person_id', $personid);
		$this->db->where('syear', $year);
        $this->db->delete('person_course'); 
		$this->db->flush_cache();
		
		//Add the new roles
		if(is_array($courses))
		{
			foreach($courses as $itm)
			{
				$rdata = array(
				'person_id' => $personid,
				'term_course_id' => $itm,
				'syear'=>$year
				);
				$this->db->insert('person_course',$rdata);
				$this->db->flush_cache();
				
			}
		}
		
	}
	

 	//Get current Person Roles
 	public function getpersonrolesbypersonid($personid, $schoolid)
	{
		// select all the information from the table we want to use with a 10 row limit (for display)
		$this->db->select('person_id,role_id')->from('person_role')->where('person_id',$personid)->where('school_id', $schoolid);

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
	
	public function GetStudentClassByStudent($studentid, $syear,$school_id)
	{
		
		$this->db->select('person_class.person_id,class_id,year')->from('person_class');
		$this->db->join('person_role', 'person_class.person_id = person_role.person_id');
		$this->db->where('person_class.person_id',$studentid)->where('year',$syear)->where('school_id',$school_id);
		$query = $this->db->get();
		
		// proceed if records are found
   		if($query->num_rows()>0)
   		{
			// return the data (to the calling controller)
			return $query->row();
   		}
		else
		{
			// there are no records
			return FALSE;
		}
	}
	
	public function GetGradeLevelPersonId($studentid, $syear,$school_id)
	{
		
		$this->db->select('school_class.gradelevel_id,school_class.title,school_class.id')->from('person_class');
		$this->db->join('school_class', 'person_class.class_id = school_class.id');
		$this->db->where('person_class.person_id',$studentid)->where('year',$syear)->where('school_id',$school_id);
		$query = $this->db->get();
		
		// proceed if records are found
   		if($query->num_rows()>0)
   		{
			// return the data (to the calling controller)
			return $query->row();
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

	public function GetPersonCoursesByPersonId($personid)
	{
		// select all the information from the table we want to use with a 10 row limit (for display)
		$this->db->select('person_id,term_course_id')->from('person_course')->where('person_id',$personid);

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
 	public function GetPersonsWithRole($role_id, $school_id){

		$sql = "select person.id, first_name, surname 
 					from person inner join person_role on person.id = person_role.person_id
					inner join role on person_role.role_id = role.id
					where person_role.role_id = $role_id and person.default_schoolId=$school_id
					group by first_name,surname,person.id";

   		
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