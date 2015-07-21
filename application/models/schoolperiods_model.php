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

class Schoolperiods_model extends CI_Model
{
	// The listing method takes gets a list of people in the database 
	public function listing($schoolid,$syear)
 	{
 		
		// select all the information from the table we want to use with a 10 row limit (for display)
		$this->db->select('period_id,school_id,sort_order,title,start_time,end_time','ignore_scheduling','attendance')->from('school_periods')->where('school_id',$schoolid)->where('syear',$syear)->limit(10);

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
 	public function addschoolperiod($data)
 	{
 		//This section will be used to add the person data
 		
		$this->db->insert('school_periods', $data);
		
		$this->db->flush_cache();
		
				
		
 	}
	
	
	
 	//Update person model
 	public function updateperiodlevel($id,$data)
 	{
 		//This section will be used to update the person data
 		$this->db->where('period_id', $id);
		$this->db->update('school_periods', $data);
		$this->db->flush_cache();
	}
	
	//Get all Person Roles
	public function GetAvailableTimes()
 	{
 		//Get hour values
 		for($i=1;$i<=12;$i++)
		{
			$hour_options[$i] = $i;
		}
		
		for($i=0;$i<=9;$i++)
		{
			$minute_options[$i] = '0'.$i;
		}
		
		for($i=10;$i<=59;$i++)
		{
			$minute_options[$i] = $i;
		}
	
		return array('hour'=>$hour_options,
		'minutes'=>$minute_options);
		// select all the information from the table we want to use with a 10 row limit (for display)
		
 	}
	
	
	
 	//Get Grade Levels
	public function GetSortOrder($schoolid,$syear)
 	{
 		
		// select all the information from the table we want to use with a 10 row limit (for display)
		$this->db->select('period_id,sort_order')->from('school_periods')->where('school_id',$schoolid)->where('syear',$syear);

   		// run the query and return the result
   		$query = $this->db->get();
		
		// proceed if records are found
   		if($query->num_rows()>0)
   		{
   			$x=1;
   			for($i=1;$i<=$query->num_rows();$i++)
			{
				$valfound = false;
				foreach($query->result() as $q)
				{
					//echo "<br/>Database value" . $q->sort_order;
					if($q->sort_order== $i)
					{
						$valfound = true;
					}
				}
				//echo "<br/>If found:" . $valfound;
				if(!$valfound)
				{
					$sortoptions[$x] = $i;
					$x++;
				}
			}
			// return the data (to the calling controller)
			//return $query->result();
			
			return array('sortopts' =>$sortoptions);
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
	public function GetSchoolPeriodById($id)
 	{
		// select all the information from the table we want to use with a 10 row limit (for display)
		$this->db->select('period_id,syear,short_name,school_id,block,sort_order,title,start_time,end_time,ignore_scheduling,attendance')->from('school_periods')->where('period_id',$id);

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
	// The method will identify if the time period start time is unique
	public function IsUniqueStartTime($stime,$syear,$sid)
 	{
		// select all the information from the table we want to use with a 10 row limit (for display)
		
		$this->db->select('period_id')->from('school_periods')->where('syear',$syear)->where('school_id',$sid)->where('start_time',$stime);
		
   		// run the query and return the result
   		$query1 = $this->db->get();
		echo $query1->num_rows();
		// proceed if records are found
   		if($query1->num_rows()>0)
   		{
			// return the data (to the calling controller)
			//return $query->result();
			return false;
   		}
		else
		{
			// there are no records
			return true;
		}
 	}
	// The method will identify if the time period start time is unique
	public function IsUniqueEndTime($stime,$syear,$sid)
 	{
		// select all the information from the table we want to use with a 10 row limit (for display)
		
		$this->db->select('period_id')->from('school_periods')->where('syear',$syear)->where('school_id',$sid)->where('end_time',$stime);
		
   		// run the query and return the result
   		$query1 = $this->db->get();
		echo $query1->num_rows();
		// proceed if records are found
   		if($query1->num_rows()>0)
   		{
			// return the data (to the calling controller)
			//return $query->result();
			return false;
   		}
		else
		{
			// there are no records
			return true;
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