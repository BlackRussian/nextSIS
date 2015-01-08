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
	

 	//Gets list of courses for a subject
	public function GetSubjectCourses($subject_id, $school_id, $ajax=FALSE)
 	{
		if($ajax){
			$this->datatables->select('subject_course.title as course_title, short_name, school_gradelevels.title as grade_title, course_id, subject_id, grade_level,syear');
			$this->datatables->from('subject_course');
			$this->datatables->join('school_gradelevels', 'subject_course.grade_level = school_gradelevels.id');
			$this->datatables->where('subject_id = ', $subject_id);
			$this->datatables->where('school_id = ', $school_id);

			$this->datatables->edit_column('edit', '<a href="/courses/edit/$1">edit</a>', 'course_id');
			$this->datatables->edit_column('assign', '<a href="/courses/$1">view teacher(s)</a>', 'course_id');


			return $this->datatables->generate();
		}else{
			$this->db->select('subject_course.title as course_title, short_name, school_gradelevels.title as grade_title, course_id, subject_id, grade_level,syear');
			$this->db->from('subject_course', 'school_gradelevels');
			$this->db->join('school_gradelevels', 'subject_course.grade_level = school_gradelevels.id');
			$this->db->where('subject_id = ', $subject_id);
			$this->db->where('school_id = ', $school_id);
			$this->db->limit(10);
			$this->db->order_by('course_title,short_name');
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
	
	public function AddTermCourse($data)
 	{
 		
		$this->db->insert('term_course', $data);
		
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
		$this->db->select('course_id,subject.subject_id,subject.syear,grade_level,subject_course.title as course_title,subject_course.short_name, school_gradelevels.title as grade_title, subject.title as subject_title');
		$this->db->from('subject_course');
		$this->db->join('school_gradelevels', 'subject_course.grade_level = school_gradelevels.id');
		$this->db->join('subject', 'subject.subject_id = subject_course.subject_id');
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

 	public function GetTermCourses($syear, $schoolid, $filter){

 		$sql = "select term_course_id, concat_ws(' ', first_name, middle_name, surname) full_name, marking_period.title term,marking_period.short_name,subject_course.title course_title,
 					subject_course.short_name, school_gradelevels.title as grade_level
 					from term_course inner join marking_period
					on term_course.marking_period_id = marking_period.marking_period_id inner join person
					on term_course.teacher_id = person.id inner join subject_course
					on term_course.course_id = subject_course.course_id inner join school_gradelevels
					on subject_course.grade_level = school_gradelevels.id
					where subject_course.syear = marking_period.syear and subject_course.syear = $syear and marking_period.school_id = $schoolid;";

		if($filter){
			$sql = "select term_course_id, concat_ws(' ', first_name, middle_name, surname) full_name, marking_period.title term,marking_period.short_name,subject_course.title course_title,
 					subject_course.short_name, school_gradelevels.title as grade_level
 					from term_course inner join marking_period
					on term_course.marking_period_id = marking_period.marking_period_id inner join person
					on term_course.teacher_id = person.id inner join subject_course
					on term_course.course_id = subject_course.course_id inner join school_gradelevels
					on subject_course.grade_level = school_gradelevels.id
					where subject_course.syear = marking_period.syear and subject_course.syear = $syear and marking_period.school_id = $schoolid
					and subject_course.course_id = $filter";
		}

 		// run the query and return the result
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
}

?>