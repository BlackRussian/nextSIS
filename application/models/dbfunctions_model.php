<?php if (!defined('BASEPATH')) exit('No direct script access allowed.');

/* nextSIS user model
 *
 * PURPOSE 
 * This creates a user class with a login method which retrieves user account information from the database.
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

class Dbfunctions_model extends CI_Model
{
	
	//Manage marking period Id
	public function getMarkingPeriodId()
	{
			
		$data = array(
		   'id' => NULL 
		);
		
		$this->db->insert('marking_period_id_generator', $data); 
		$id = $this->db->insert_id();
		$this->db->flush_cache();
		
		return $id;
	}

}

?>