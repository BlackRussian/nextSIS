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

class Schoolyear_model extends CI_Model
{
	// The listing method takes gets a list of people in the database 
	public function listing($schoolid)
 	{
		$sql = "Select a.marking_period_id,a.school_id,a.title,a.syear,a.start_date,a.end_date,
				GROUP_CONCAT(b.title SEPARATOR ', ') as Terms from school_year a
				left outer join school_semester b on a.marking_period_id = b.year_id
				where a.school_id = $schoolid
				group by a.marking_period_id";

		// select all the information from the table we want to use with a 10 row limit (for display)
		//$this->db->select($sql)->limit(10);
		
		$query = $this->db->query($sql);
   		// run the query and return the result
   		//$query = $this->db->get();
		
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
	
	
	//Add new school year
	public function addschoolyear($data)
 	{
 		//This section will be used to add the person data
 		
		$this->db->insert('school_year', $data);
		$id = $this->db->insert_id();
		$this->db->flush_cache();
		//echo "marking period Id: " . $id;
		return $id;
 	}
	
	public function UpdateSchoolYear($id,$data)
 	{
 		//This section will be used to update the person data
 		$this->db->where('marking_period_id', $id);
		$this->db->update('school_year', $data);
		$this->db->flush_cache();
	
 	}
	
	
	
	//Get school year by id
 	public function GetSchoolYearById($id)
 	{
 		
		// select all the information from the table we want to use with a 10 row limit (for display)
		$this->db->select('marking_period_id,school_id,title,syear,short_name,start_date,end_date')->from('school_year')->where('marking_period_id',$id);

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
	
}

?>