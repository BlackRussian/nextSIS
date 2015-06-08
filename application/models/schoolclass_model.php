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

class Schoolclass_model extends CI_Model
{
	// The listing method takes gets a list of people in the database 
	public function listing($filter, $schoolid)
 	{
		if($filter){
			$this->db->select('school_class.id,school_class.school_id, school_class.title as class_title, gradelevel_id, school_gradelevels.title as grade_title')->from('school_class');
			$this->db->join('school_gradelevels', 'school_class.gradelevel_id = school_gradelevels.id');
			$this->db->where('gradelevel_id', $filter);
			$this->db->where('school_class.school_id',$schoolid);//->limit(10);
		}else{
			$this->db->select('school_class.id,school_class.school_id, school_class.title as class_title, gradelevel_id, school_gradelevels.title as grade_title')->from('school_class');
			$this->db->join('school_gradelevels', 'school_class.gradelevel_id = school_gradelevels.id');
			$this->db->where('school_class.school_id',$schoolid);//->limit(10);
		}
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
	
	//Add person model
 	public function AddSchoolClass($data)
 	{
 		//This section will be used to add the person data
 		
		$this->db->insert('school_class', $data);
		
		$this->db->flush_cache();
		
				
		
 	}
	
	
	
 	//Update person model
 	public function updateschoolclass($id,$data)
 	{
 		//This section will be used to update the person data
 		$this->db->where('id', $id);
		$this->db->update('school_class', $data);
		$this->db->flush_cache();
		
		
		
		
 	}
 	//Get Grade Levels
	public function GetSchoolClasses($schoolid)
 	{
 		
		// select all the information from the table we want to use with a 10 row limit (for display)
		$this->db->select('id,title')->from('school_class')->where('school_id',$schoolid);

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

	// The listing method takes gets a list of people in the database 
	public function GetSchoolClassesById($id, $school_id)
 	{
		// select all the information from the table we want to use with a 10 row limit (for display)
		$this->db->select('id,school_id,title,gradelevel_id')->from('school_class');
		$this->db->where('id', $id);
		$this->db->where('school_id', $school_id);

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

 	public function GetClassByGradeLevel($gradelevel_id){
		// select all the information from the table we want to use with a 10 row limit (for display)
		$this->db->select('id,title')->from('school_class')->where('schoolgradelevels_id', $gradelevel_id);

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