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

class Schoolquarter_model extends CI_Model
{
	// The listing method takes gets a list of people in the database 
	public function listing($semesterid, $schoolid)
 	{
 		if($semesterid)
		{
			$sql = "Select a.marking_period_id,c.title as SchoolYearTitle,b.title as TermTitle,a.school_id,a.title,a.syear,
					a.start_date,a.end_date from school_quarter a
				inner join school_semester b on a.semester_id = b.marking_period_id
				inner join school_year c on a.year_id = c.marking_period_id
				where a.semester_id = $semesterid and a.school_id = $schoolid";
		}else{
			$sql = "Select a.marking_period_id,c.title as SchoolYearTitle,b.title as TermTitle,a.school_id,a.title,a.syear,
					a.start_date,a.end_date from school_quarter a
				inner join school_semester b on a.semester_id = b.marking_period_id
				inner join school_year c on a.year_id = c.marking_period_id
				where a.school_id = $schoolid";
		}
			
	   		// run the query and return the result
	   		//$query = $this->db->get();
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
 	public function addschoolquarter($data)
 	{
 		//This section will be used to add the person data
 		
		$this->db->insert('school_quarter', $data);
		
		$this->db->flush_cache();
		
				
		
 	}
	
	
	
 	//Update person model
 	public function UpdateSchoolQuarter($id,$data)
 	{
 		//This section will be used to update the person data
 		$this->db->where('marking_period_id', $id);
		$this->db->update('school_quarter', $data);
		$this->db->flush_cache();
		
		
		
		
 	}
 	
 	
	// The listing method takes gets a list of people in the database 
	public function GetSchoolQuarterById($id)
 	{
		// select all the information from the table we want to use with a 10 row limit (for display)
		$this->db->select('marking_period_id,short_name,syear,semester_id,start_date,end_date,year_id, school_id, title')->from('school_quarter')->where('marking_period_id', $id);

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