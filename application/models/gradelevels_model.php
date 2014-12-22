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

class GradeLevels_model extends CI_Model
{
	// The listing method takes gets a list of people in the database 
	public function listing($schoolid)
 	{
		// select all the information from the table we want to use with a 10 row limit (for display)
		$this->db->select('id,school_id,title,next_grade_id')->from('school_gradelevels')->where('school_id',$schoolid)->limit(10);

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
 	public function addgradelevel($data)
 	{
 		//This section will be used to add the person data
 		
		$this->db->insert('school_gradelevels', $data);
		
		$this->db->flush_cache();
		
				
		
 	}
	
	
	
 	//Update person model
 	public function updategradelevel($id,$data)
 	{
 		//This section will be used to update the person data
 		$this->db->where('id', $id);
		$this->db->update('school_gradelevels', $data);
		$this->db->flush_cache();
		
		
		
		
 	}
 	//Get Grade Levels
	public function GetGradeLevels($schoolid)
 	{
 		
		// select all the information from the table we want to use with a 10 row limit (for display)
		$this->db->select('id,title')->from('school_gradelevels')->where('school_id',$schoolid);

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
 	//Get Grade levels except current grade level
 	public function GetGradeLevelsExceptCurrent($schoolid,$currentid)
 	{
 		// select all the information from the table we want to use with a 10 row limit (for display)
		$this->db->select('id,title')->from('school_gradelevels')->where('school_id',$schoolid)->where('next_grade_id !=',$currentid);

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
	public function GetGradeLevelById($id)
 	{
		// select all the information from the table we want to use with a 10 row limit (for display)
		$this->db->select('id,school_id,title,next_grade_id')->from('school_gradelevels')->where('id',$id);

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