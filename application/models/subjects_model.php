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

class Subjects_model extends CI_Model
{
	// The listing method takes gets a list of people in the database 
	public function listing($schoolid)
 	{
		// select all the information from the table we want to use with a 10 row limit (for display)
		$this->db->select('subject_id,school_id,title,short_name,course_count')->from('subject_course_count')->where('school_id',$schoolid);

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
	

 	//Gets list of courses for a subject
	public function GetSubjectCourses($subject_id, $school_id)
 	{
		//$this->db->select('course_id,subject_id,subject_course.title as subject_title, school_gradelevels.title as grade_title, short_name,grade_level,syear');
		//$this->db->from('subject_course', 'school_gradelevels');
		//$this->db->join('school_gradelevels', 'subject_course.grade_level = school_gradelevels.id');
		//$this->db->where('subject_id = ', $subject_id);
		//$this->db->where('school_id = ', $school_id);

 		
		$this->datatables->select('subject_course.title as subject_title, short_name, school_gradelevels.title as grade_title, course_id, subject_id, grade_level,syear');
		$this->datatables->edit_column('edit', '<a href="/courses/edit/$1">edit</a>', 'course_id');
		$this->datatables->from('subject_course');
		$this->datatables->join('school_gradelevels', 'subject_course.grade_level = school_gradelevels.id');
		$this->datatables->where('subject_id = ', $subject_id);
		$this->datatables->where('school_id = ', $school_id);
		

		return $this->datatables->generate();
   		// run the query and return the result
   		//$query = $this->db->get();
		
		// proceed if records are found
   		//if($query->num_rows()>0)
   		//{
			// return the data (to the calling controller)
		//	return $query->result();
   		//}
		//else
		//{
			// there are no records
		//	return FALSE;
		//}
 	}

 	public function AddSubject($data)
 	{	
		$this->db->insert('subject', $data);
		
		$this->db->flush_cache();

 	}

 	public function AddSubjectCourse($data)
 	{
 		
		$this->db->insert('subject_course', $data);
		
		$this->db->flush_cache();
 	}
	
 	public function UpdateSubject($id,$data)
 	{
 		//This section will be used to update the person data
 		$this->db->where('subject_id', $id);
		$this->db->update('subject', $data);
		$this->db->flush_cache();
 	}

 	public function UpdateSubjectCourse($id, $data)
 	{
 		//This section will be used to update the person data
 		$this->db->where('course_id', $id);
		$this->db->update('subject_course', $data);
		$this->db->flush_cache();
 	}
	
	public function GetSubjectById($id, $school_id)
 	{
 		
		// select all the information from the table we want to use with a 10 row limit (for display)
		$where = 'subject_id = '. $id . ' AND school_id = ' . $school_id;
		$this->db->select('subject_id,school_id,short_name,title')->from('subject')->where($where);

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

 		//Get Grade Levels
	public function GetSubjectCourseById($course_id)
 	{
 		
		// select all the information from the table we want to use with a 10 row limit (for display)
		//$where = 'subject_id = '. $id . ' AND school_id = ' . $school_id;
		$this->db->select('course_id,subject_id,syear,grade_level,title,short_name');
		$this->db->from('subject_course');
		$this->db->where('course_id',$course_id);

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