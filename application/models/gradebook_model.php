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

class Gradebook_model extends CI_Model
{
	// The listing method takes gets a list of people in the database 
	public function listing($role, $teacher_id)
 	{

		$this->db->select('term_course.term_course_id,subject_course.title,subject_course.title,subject_course.short_name, person_title.label, person.first_name,person.surname');
		$this->db->from('term_course');
		$this->db->join('subject_course', 'term_course.course_id = subject_course.course_id');
		$this->db->join('person', 'term_course.teacher_id = person.id');
		$this->db->join('person_title', 'person.title_id = person_title.id');
		if ($role == 2)
			$this->db->where('term_course.teacher_id', $teacher_id);
		$this->db->order_by("title,short_name, label, first_name,surname");

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
	

 	public function GetGradeTypes($course_id)
 	{
		// select all the information from the table we want to use with a 10 row limit (for display)
		$this->db->select('grade_type_id,title')->from('grade_type')->where("term_course_id",$course_id)->order_by("title");

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

 	public function GetGradeTypeByID($grade_type_id)
 	{
		// select all the information from the table we want to use with a 10 row limit (for display)
		$this->db->select('grade_type_id,title,weight,term_course_id')->from('grade_type')->where("grade_type_id",$grade_type_id);

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

 	public function GetStudentList($grade_type_id)
 	{
		$this->db->select('student_subjects_vw.student,student_subjects_vw.studentid, grade_book.points, grade_book.grade_id');
		$this->db->from('student_subjects_vw');
		$this->db->join('grade_type', 'student_subjects_vw.term_course_id = grade_type.term_course_id');
		$this->db->join('grade_book', 'grade_type.grade_type_id = grade_book.grade_type_id and student_subjects_vw.studentid = grade_book.student_id','left');
		$this->db->where('grade_type.grade_type_id', $grade_type_id);
		$this->db->order_by("student_subjects_vw.student");

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
 
	public function GetGradeTypeInfo($grade_type_id)
 	{
		$this->db->select('subject_course.title as `subject`,subject_course.short_name, grade_type.title, grade_type.term_course_id');
		$this->db->from('grade_type');
		$this->db->join('term_course', 'grade_type.term_course_id = term_course.term_course_id');
		$this->db->join('subject_course', 'term_course.course_id = subject_course.course_id');
		$this->db->where('grade_type.grade_type_id', $grade_type_id)->limit(1);
		

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

 		//Add person model
 	public function AddGrades($data)
 	{
 		//This section will be used to add the person data
 		
		$this->db->insert_batch('grade_book', $data);
		
		$this->db->flush_cache();		
 	}


 	public function UpdateGrades($data)
 	{
 		//This section will be used to add the person data
 		
		$this->db->update_batch('grade_book', $data,'grade_id');
		
		$this->db->flush_cache();	
 	}

 	public function AddGradeType($data)
 	{
 		//This section will be used to add the person data
 		
		$this->db->insert('grade_type', $data);
		
		$this->db->flush_cache();
		
 	}

 	public function UpdateGradeType($data, $grade_type_id)
 	{ 		 		
		$this->db->where('grade_type_id', $grade_type_id);

		$this->db->update('grade_type', $data);
		
		$this->db->flush_cache();	
 	}
	
	
}

?>