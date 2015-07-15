<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


	if ( ! function_exists('UDF_Validation')){
		function UDF_Validation($object, $suffix = ""){
				$udf_field  		= explode(",", $object->input->post('udf_field_names' . $suffix, TRUE));
				$udf_types	 		= $object->input->post('udf_types' . $suffix, TRUE);
				$udf_validations	= $object->input->post("udf_validations" . $suffix, TRUE);
				$udf_titles 		= $object->input->post("udf_titles" . $suffix, TRUE);
				

				foreach ($udf_field as $key => $value) {
					$object->form_validation->set_rules($value, $udf_titles[$key], $udf_validations[$key]);
				}
		}
	}

	if ( ! function_exists('Insert_Update_UDF')){
		function Insert_Update_UDF($object, $fk_id, $fk_id2 = 0, $suffix = ""){
			$object->load->model('udf_model');
			$udf_field_names	= explode(",", $object->input->post('udf_field_names' . $suffix, TRUE));
			$udf_types	 		= $object->input->post('udf_types' . $suffix, TRUE);
			$udf_ids 			= $object->input->post("udf_ids" . $suffix, TRUE);
			$udf_data_ids 		= $object->input->post("udf_data_ids" . $suffix, TRUE);
			$insertData			= array();		
			$updateData			= array();

			foreach ($udf_field_names as $key => $value) {
				$isAdd = empty($udf_data_ids[$key]);			
				switch ($udf_types[$key]) {
					case 'checkbox':

					$data = $object->input->post($value, TRUE);
					
						if ($isAdd){
							$insertData[count($insertData)] = array(							
								'udf_id' 		=> $udf_ids[$key],
								'udf_value' 	=> (($data)? implode(",", $object->input->post($value, TRUE)) : ""),
								'fk_id' 		=> $fk_id,
								'fk_id_2' 		=> $fk_id2				
							);
						}else{
							$updateData[count($updateData)] = array(							
								'udf_data_id' 	=> $udf_data_ids[$key],
								'udf_id' 		=> $udf_ids[$key],
								'udf_value' 	=> (($data)? implode(",", $object->input->post($value, TRUE)) : ""),
								'fk_id' 		=> $fk_id					
							);
						}

						break;
					default:
					$data = $object->input->post($value, TRUE);
						if ($isAdd){
							$insertData[count($insertData)] = array(							
								'udf_id' 		=> $udf_ids[$key],
								'udf_value' 	=> $data,
								'fk_id' 		=> $fk_id,
								'fk_id_2' 		=> $fk_id2					
							);
						}else{
							$updateData[count($updateData)] = array(							
								'udf_data_id' 	=> $udf_data_ids[$key],
								'udf_id' 		=> $udf_ids[$key],
								'udf_value' 	=> $data,
								'fk_id' 		=> $fk_id					
							);
						}
						break;
				}			
			}

			if(count($insertData) > 0)
				$object->udf_model->AddUDFValues($insertData);
			
			if(count($updateData) > 0)
				$object->udf_model->UpdateUDFValues($updateData);
		}
	}

?>