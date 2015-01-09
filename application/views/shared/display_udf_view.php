<?php 
	$counter 					= 0;
	$gradeid_field_name			= "";
	$style 						= "padding-top: 5px;";
	if (!isset($udfDisplay))
		$udfDisplay = FALSE;

		
	if (isset($udf)){
		foreach($udf as $field) {
			$udf_field_name			= "udf_field[". $counter ."]";
			$udf_types_name			= "udf_types[". $counter ."]";
			$udf_validations_name	= "udf_validations[". $counter ."]";
			$udf_titles_name		= "udf_titles[". $counter ."]";
			$udf_ids_name			= "udf_ids[". $counter ."]";
			$udf_data_ids_name		= "udf_data_ids[". $counter ."]";
			$default_vals			= $field->udf_value==null ? $field->default_selection: $field->udf_value;
			if (!$udfDisplay){
				switch ($field->type) {
					case 'text':
						$data = array(
					      'name'        	=> $udf_field_name,
					      'id'          	=> $udf_field_name,
					      'autocomplete'    => 'off'
					    );
						?>
						    <div class="control-group">
						        <label class="control-label" for="<?php echo $udf_field_name; ?>"><?php echo $field->title;?></label>
						        <div class="controls">
						        	<?php echo form_input($data, set_value($udf_field_name, $default_vals)); ?>

						        </div>
						    </div>
						<?php 
						break;
					case 'select':
						$data = array(
					      'name'        	=> $udf_field_name,
					      'id'          	=> $udf_field_name
					    );

						$dropValues[""] 		= "Select " . $field->title;

						foreach(explode("\r\n", $field->select_options) as $value){
			            	$dropValues[$value] = $value;
			        	}
			        	
						?>
						    <div class="control-group">
						        <label class="control-label" for="<?php echo $udf_field_name; ?>"><?php echo $field->title;?></label>
						        <div class="controls">
						        	<?php echo form_dropdown($udf_field_name, array_unique($dropValues) ,set_value($udf_field_name, $default_vals),'id="' . $udf_field_name. '"'); ?>
						        	
						        </div>
						    </div>
						<?php 
						break;
					case 'textarea':
						$data = array(
					      'name'        	=> $udf_field_name,
					      'id'          	=> $udf_field_name,
					      'rows'    		=> '4',
					      'cols'    		=> '50'
					    );
						?>
						    <div class="control-group">
						        <label class="control-label" for="<?php echo $udf_field_name; ?>"><?php echo $field->title;?></label>
						        <div class="controls">
						        	<?php echo form_textarea($data, set_value($udf_field_name, $default_vals)); ?>

						        </div>
						    </div>
						<?php 				
						break;
				}		
				echo form_hidden($udf_types_name, $field->type);
				echo form_hidden($udf_validations_name, $field->validation);
				echo form_hidden($udf_titles_name, $field->title);
				echo form_hidden($udf_titles_name, $field->title);
				echo form_hidden($udf_ids_name, $field->udf_id);
				echo form_hidden($udf_data_ids_name, $field->udf_data_id);
				$counter=$counter+1;
			}else{
			?>
			    <div class="control-group">
			        <label class="control-label" for="<?php echo $udf_field_name; ?>"><?php echo $field->title;?></label>
			        <div class="controls" style="<?php echo $style ?>">
                    	<?php echo $default_vals ?>	                                        			                    	
                    </div>
			    </div>
			<?php 
			}
		}
	}
?>