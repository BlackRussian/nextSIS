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

class Grades_model extends CI_Model
{
	// The listing method takes gets a list of people in the database 
	public function listing($courseid)
 	{
		// select all the information from the table we want to use with a 10 row limit (for display)
		$this->db->select('studentname,classtitle,grade,gradeid,subjectcourse_title,subjectcourse_id,personid,termcourseid')->from('reportgradebook');
				
		if($courseid != '0')
		{
			$this->db->where('subjectcourse_id', $courseid);
		}
   		// run the query and return the result
   		$this->db->limit(10);
   		
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
	public function searchlisting($langid)
 	{
		// select all the information from the table we want to use with a 10 row limit (for display)
		$this->db->select('studentname,classtitle,grade,gradeid,subjectcourse_title,subjectcourse_id,personid,termcourseid')->from('reportgradebook')->limit(10);
		if(isset($name) &&  $name  != '' && !empty($name))
		{
			
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
	//Get Current Teachers Courses
	public function GetTeacherCoursesByYear($id,$syear)
 	{
		// select all the information from the table we want to use with a 10 row limit (for display)
		$this->db->select('subjectcourse_id,subjectcourse_title')->from('TeacherSubjects_vw')->where('personid',$id)->where('syear', $syear)->limit(10);

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
	//Get Current Teachers Courses
	public function GetGradeTypes()
 	{
		// select all the information from the table we want to use with a 10 row limit (for display)
		$this->db->select('id,typename')->from('gradetypes')->limit(10);

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

    public function GetStudentsWhoSitCourse($courseid) 
 	{
		// select all the information from the table we want to use with a 10 row limit (for display)
		$this->db->select('student,studentid,termcourses_id,title')->from('Student_subjects_vw')->where('termcourses_id',$courseid)->limit(10);

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
 	public function addperson($data,$roledata)
 	{
 		//This section will be used to add the person data
 		
		$this->db->insert('person', $data);
		$id = $this->db->insert_id();
		$this->db->flush_cache();
		
		
		//Add the new roles
		if(is_array($roledata))
		{
			foreach($roledata as $itm)
			{
				$rdata = array(
				'person_id' => $id,
				'role_id' => $itm);
				$this->db->insert('person_role',$rdata);
				$this->db->flush_cache();
				
			}
		}
		
		
 	}
	
	
	
 	//Update person model
 	public function updateperson($id,$data,$roledata)
 	{
 		//This section will be used to update the person data
 		$this->db->where('id', $id);
		$this->db->update('person', $data);
		$this->db->flush_cache();
		
		//Clear the current roles associated with the person
		$this->db->where('person_id', $id);
        $this->db->delete('person_role'); 
		$this->db->flush_cache();
		
		//Add the new roles
		if(is_array($roledata))
		{
			foreach($roledata as $itm)
			{
				$rdata = array(
				'person_id' => $id,
				'role_id' => $itm);
				$this->db->insert('person_role',$rdata);
				$this->db->flush_cache();
				
			}
		}
		
		
 	}
 	//Get Person by person id
	public function getpersonbyid($personid)
 	{
 		
		// select all the information from the table we want to use with a 10 row limit (for display)
		$this->db->select('id,surname,first_name,middle_name,common_name,title_id,gender_id,local_id,username')->from('person')->where('id',$personid);

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
 	//Get current Person Roles
 	public function getpersonrolesbypersonid($personid)
	{
		// select all the information from the table we want to use with a 10 row limit (for display)
		$this->db->select('person_id,role_id')->from('person_role')->where('person_id',$personid);

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
 	//Get all Person Genders
	public function GetGradeById($id)
 	{
		// select all the information from the table we want to use with a 10 row limit (for display)
		$this->db->select('id,course_id,gradetype_id,student_id,grade_title,grade,actualscore,weight')->from('course_grade')->where('id',$id)->limit(1);

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
	//Get all Person Titles
	public function GetPersonTitles($langid)
 	{
		// select all the information from the table we want to use with a 10 row limit (for display)
		$this->db->select('id,language_id,label')->from('person_title')->where('language_id',$langid)->limit(10);

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