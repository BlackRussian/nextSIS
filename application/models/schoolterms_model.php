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

class Schoolterms_model extends CI_Model
{
	// The listing method takes gets a list of people in the database 
	public function listing($schoolid, $syear)
 	{
		// select all the information from the table we want to use with a 10 row limit (for display)
		$sql = "Select a.marking_period_id,a.school_id,a.title,a.syear,a.start_date,a.end_date,
				GROUP_CONCAT(b.title SEPARATOR ', ') as Terms from school_year a
				left outer join school_semester b on a.marking_period_id = b.year_id
				group by a.marking_period_id";
		//$this->db->select('marking_period_id,school_id,title,syear,start_date,end_date')->from('school_semester')->where('school_id',$schoolid)->where('syear',$syear)->limit(10);

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

	public function GetSchoolQuatersBySchoolYearId($syearId)
	 	{
			$sql = "Select a.marking_period_id,c.title as SchoolYearTitle,b.title as TermTitle,a.school_id,a.title,a.syear,
					a.start_date,a.end_date from school_quarter a
				inner join school_semester b on a.semester_id = b.marking_period_id
				inner join school_year c on a.year_id = c.marking_period_id
				where a.year_id = $syearId";
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
	
	//Manage marking period Id
	public function getMarkingPeriodId()
	{
		//$this->db->select('fn_marking_period_seq()');
		//$query = $this->db->get();
		//$this->db->call_function('fn_marking_period_seq');
		//$this->db->query("call fn_marking_period_seq()");
		//$query = $this->db->query("select fn_marking_period_seq()");
		//echo $query->result_array();
		
		//$vars = get_object_vars ( $query );
		//print_r ($vars);
		
		
		$data = array(
		   'id' => NULL 
		);
		
		$this->db->insert('marking_period_id_generator', $data); 
		$id = $this->db->insert_id();
		$this->db->flush_cache();
		
		return $id;
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
	
	
	
	
	//Add person model
 	public function addschoolterms($data)
 	{
 		//This section will be used to add the person data
 		
		$this->db->insert('school_semester', $data);
		
		$this->db->flush_cache();
 	}
	
	//Add person model
 	public function addtermquarter($data)
 	{
 		//This section will be used to add the person data
 		
		$this->db->insert('school_quarter', $data);
		
		$this->db->flush_cache();
 	}
	
	
	
	
 	//Update person model
 	public function updateschoolterm($id,$data)
 	{
 		//This section will be used to update the person data
 		$this->db->where('id', $id);
		$this->db->update('term', $data);
		$this->db->flush_cache();
	
 	}
	
	public function updateschoolyear($id,$data)
 	{
 		//This section will be used to update the person data
 		$this->db->where('marking_period_id', $id);
		$this->db->update('school_year', $data);
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
	
	//Get Grade Levels
	public function GetSchoolTermById($id)
 	{
 		
		// select all the information from the table we want to use with a 10 row limit (for display)
		$this->db->select('id,school_id,title,syear,startdate,enddate')->from('term')->where('id',$id);

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