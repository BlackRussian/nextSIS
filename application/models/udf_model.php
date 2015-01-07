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

class Udf_model extends CI_Model
{
	// The listing method takes gets a list of people in the database 
	public function listing($school_id)
 	{
		$this->db->select('udf_id, school_id, type,  udf_definition.title,  description,  sort_order,  select_options,  udf_definition.category_id,  validation,  default_selection,  hide, udf_categories.title as category');
		$this->db->from('udf_definition');
		$this->db->join('udf_categories','udf_definition.category_id = udf_categories.category_id');
		$this->db->where('school_id', $school_id);

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
	

 	public function GetUdfCategories()
 	{
		$this->db->select('category_id,title')->from('udf_categories')->order_by("title");

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

 	public function GetUdfByID($udf_id)
 	{
		$this->db->select('udf_id, school_id, type,  title,  description,  sort_order,  select_options,  category_id,  validation,  default_selection,  hide');
		$this->db->from('udf_definition');
		$this->db->where('udf_id', $udf_id);

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

 	public function GetUdfs($school_id, $category_id, $fk_id = NULL)
 	{
 		switch ($category_id) {
 			case 1:
 				if($fk_id == NULL){
					$this->db->select('udf_id, school_id, type,  title,  description,  sort_order,  select_options,  category_id,  validation,  default_selection,  hide, NULL as udf_data_id, NULL as udf_value',false);
					$this->db->from('udf_definition');
					$this->db->where('school_id', $school_id);
					$this->db->where('category_id', $category_id);
					$this->db->where('hide', '0');
					$this->db->order_by('sort_order');
 				}else{
					$this->db->select('udf_definition.udf_id, school_id, type,  title,  description,  sort_order,  select_options,  category_id,  validation,  default_selection,  hide, udf_data_id, udf_value');
					$this->db->from('udf_definition');
					$this->db->join('udf_data','udf_definition.udf_id = udf_data.udf_id and fk_id = "' . $fk_id . '"', 'left');
					$this->db->where('school_id', $school_id);
					$this->db->where('category_id', $category_id);					
					$this->db->where('hide', '0');
					$this->db->order_by('sort_order');
 				}

 				break;
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



 	//Add person model
 	public function AddUDF($data)
 	{
 		//This section will be used to add the person data
 		
		$this->db->insert('udf_definition', $data);
		
		$this->db->flush_cache();		
 	}


 	public function UpdateUDF($data, $udf_id)
 	{
 		$this->db->where('udf_id', $udf_id);

		$this->db->update('udf_definition', $data);
		
		$this->db->flush_cache();	
 	}

 	public function GetUDFByCategory($category_id)
 	{
		$this->db->select('udf_id, school_id, type,  udf_definition.title,  description,  sort_order,  select_options,  udf_definition.category_id,  validation,  default_selection,  hide, udf_categories.title as category');
		$this->db->from('udf_definition');
		$this->db->join('udf_categories','udf_definition.category_id = udf_categories.category_id');
		$this->db->where('udf_definition.category_id', $category_id);
		$this->db->order_by('sort_order');

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

 	 public function AddUDFValues($data)
 	{
 		//This section will be used to add the person data
 		
		$this->db->insert_batch('udf_data', $data);
		
		$this->db->flush_cache();		
 	}
	public function UpdateUDFValues($data)
 	{
 		//This section will be used to add the person data
 		
		$this->db->update_batch('udf_data', $data, 'udf_data_id');
		
		$this->db->flush_cache();		
 	}
}
?>