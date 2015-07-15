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

class Schoolsemester_model extends CI_Model
{
	// The listing method takes gets a list of people in the database 
	public function listing($filter, $schoolid)
 	{
		// select all the information from the table we want to use with a 10 row limit (for display)
		if($filter)
		{
			$this->db->select('school_year.title as syeartitle,school_semester.marking_period_id,school_semester.year_id,school_semester.school_id,school_semester.title,school_semester.syear,school_semester.start_date,school_semester.end_date')->from('school_semester');
			$this->db->join('school_year', 'school_semester.year_id = school_year.marking_period_id');
			$this->db->where('year_id',$filter);
			$this->db->where('school_semester.school_id',$schoolid)->limit(10);
		}else{
			$this->db->select('school_year.title as syeartitle,school_semester.marking_period_id,school_semester.year_id,school_semester.school_id,school_semester.title,school_semester.syear,school_semester.start_date,school_semester.end_date')->from('school_semester');
			$this->db->join('school_year', 'school_semester.year_id = school_year.marking_period_id');
			$this->db->where('school_semester.school_id',$schoolid)->limit(10);
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
	
	public function GetSchoolTermsBySchoolYearId($syearId)
 	{
		// select all the information from the table we want to use with a 10 row limit (for display)
		$this->db->select('marking_period_id,year_id,school_id,title,syear,start_date,end_date')->from('school_semester')->where('year_id',$syearId)->limit(10);

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


	public function GetSchoolTermsBySchoolYear($syear)
	 	{
			// select all the information from the table we want to use with a 10 row limit (for display)
			$this->db->select('marking_period_id,year_id,school_id,title,syear,start_date,end_date')->from('school_semester')->where('syear',$syear)->limit(10);
	
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

	
	
	
	
	public function PopulateSchoolTermsDDLByyearId($syearId)
 	{
		$sql = "Select a.marking_period_id,CONCAT(a.Title,' - ', a.start_date) as Title
				from school_semester a
				where a.year_id =$syearId";
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
 	public function addschoolterms($data)
 	{
 		//This section will be used to add the person data
 		
		$this->db->insert('school_semester', $data);
		
		$this->db->flush_cache();
 	}
	
	
	
	
	
	
 	//Update person model
 	public function updateschoolterm($id,$data)
 	{
 		//This section will be used to update the person data
 		$this->db->where('marking_period_id', $id);
		$this->db->update('school_semester', $data);
		$this->db->flush_cache();
	
 	}
	
	
 	
	//Get Grade Levels
	public function GetSchoolTermById($id)
 	{
 		
		// select all the information from the table we want to use with a 10 row limit (for display)
		$this->db->select('marking_period_id,short_name,year_id,school_id,title,syear,start_date,end_date')->from('school_semester')->where('marking_period_id',$id);

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