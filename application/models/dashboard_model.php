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

class Dashboard_model extends CI_Model
{
	// The listing method takes gets a list of people in the database 
	public function listing($schoolid)
 	{
		// select all the information from the table we want to use with a 10 row limit (for display)
		$this->db->select('subject_id,school_id,title,short_name,course_count')->from('subject_course_count')->where('school_id',$schoolid);
		$this->db->order_by("title,short_name");

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
	
	public function GetSubjectRegisteredStudentCount($periodid,$teacherId)
	{
		
		// select all the information from the table we want to use with a 10 row limit (for display)
		$this->db->select('term_course_id,marking_period_id,mp,course_id,teacher_id,registeredStudentCount,title,gradesEntered,gradetype')->from('Subjects_student_grade_count_vw')->where('marking_period_id',$periodid)->where('teacher_id',$teacherId);

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
	
	public function GetTeacherSubjectList($periodid,$teacherId)
	{
		// select all the information from the table we want to use with a 10 row limit (for display)
		$this->db->select('term_course_id,marking_period_id,mp,term_course.course_id,teacher_id,subject_course.title')->from('term_course')->where('marking_period_id',$periodid)->where('teacher_id',$teacherId);
		$this->db->join('subject_course','term_course.course_id = subject_course.course_id');

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

	public function GetCoursesforSemester($periodid)
	{
		
		// select all the information from the table we want to use with a 10 row limit (for display)
		$this->db->select('term_course_id,marking_period_id,mp,term_course.course_id,teacher_id')->from('term_course')->where('marking_period_id',$periodid);
		

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
	public function GetCreatedGradeBooks($courseids)
	{
		// select all the information from the table we want to use with a 10 row limit (for display)
		$this->db->select('grade_type_id,title,weight,term_course_id')->from('grade_type')->where_in('term_course_id', $courseids);;
		

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