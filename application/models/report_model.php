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

class Report_model extends CI_Model
{
	public function listing($role, $teacher_id, $year, $schoolid)
 	{
 		$validRoles = array(1,2);
 		if (!in_array($role, $validRoles))
 			return FALSE;


		$this->lang->load('setup');

		$this->db->select("GROUP_CONCAT(CONCAT(first_name,' ',surname) SEPARATOR ', ') as name, school_class.title as class, school_class.id", FALSE);
		$this->db->from('person_class', FALSE);
		$this->db->join('person', 'person_class.person_id = person.id', FALSE);
		$this->db->join('person_role', 'person.id = person_role.person_id', FALSE);
		$this->db->join('school_class', 'person_class.class_id = school_class.id', FALSE);		
		$this->db->where('person_role.role_id', 2, FALSE);
		$this->db->where('person_class.year', $year, FALSE);
		$this->db->where('person.default_schoolId', $schoolid, FALSE);
		$this->db->group_by("school_class.title", FALSE);
		if ($role == 2)
			$this->db->having("LOCATE(" . $teacher_id . ",GROUP_CONCAT(person_class.person_id))>0");

		$this->db->order_by("Class, Name", FALSE);		
		

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

 	public function student_listing($class_id, $year, $schoolid)
 	{

		$this->lang->load('setup');

		$this->db->select("CONCAT(first_name,if(middle_name = '',middle_name,CONCAT(' ',SUBSTRING(middle_name,1,1),'. ')),' ',surname) as name, person.id as person_id, school_class.id as class_id, school_class.title as class", FALSE);
		$this->db->from('person_class', FALSE);
		$this->db->join('person', 'person_class.person_id = person.id', FALSE);
		$this->db->join('person_role', 'person.id = person_role.person_id', FALSE);
		$this->db->join('school_class', 'person_class.class_id = school_class.id', FALSE);		
		$this->db->where('person_role.role_id', 2, FALSE);
		$this->db->where('person_class.year', $year, FALSE);
		$this->db->where('person.default_schoolId', $schoolid, FALSE);
		$this->db->where('school_class.id', $class_id, FALSE);
		$this->db->order_by("name", FALSE);		
		

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