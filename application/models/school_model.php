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

class School_model extends CI_Model
{

	public function __construct()
    {
        $this->load->database();
    }

	//Get School by school id
	public function GetSchoolByAnchor($school_anchor)
 	{
 		
		// select all the information from the table we want to use with a 10 row limit (for display)
		$this->db->select('id,title,anchor')->from('school')->where('anchor',$school_anchor);

   		// run the query and return the result
   		$query = $this->db->get();
		
		// proceed if records are found
   		if($query->num_rows() === 1)
   		{
			// return the data (to the calling controller)
			return $query->row();
   		}
		else
		{
			return null;
		}
	}

	public function GetSchoolTerms($school_id, $syear){
		
		// select all the information from the table we want to use with a 10 row limit (for display)
		$this->db->select('marking_period_id, title')->from('marking_period');
		$this->db->where('school_id',$school_id);
		$this->db->where('syear',$syear);
		$this->db->order_by('title');

   		// run the query and return the result
   		$query = $this->db->get();
		
		// proceed if records are found
   		if($query->num_rows() > 0)
   		{
			// return the data (to the calling controller)
			return $query->result();
   		}
		else
		{
			return null;
		}	
	}
}