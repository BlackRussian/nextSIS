<?php 
	$counter 					= 0;
	$style 						= "padding-top: 5px;";
	$field_names				= array();
	if (!isset($udfDisplay))
		$udfDisplay = FALSE;

	if ($udf){
		if (!isset($suffix))
			$suffix = "";


		foreach($udf as $field) {
			$udf_field_name			= "udf_field_". $suffix  ."_". $counter;
			$udf_types_name			= "udf_types". $suffix  ."[". $counter ."]";
			$udf_validations_name	= "udf_validations". $suffix  ."[". $counter ."]";
			$udf_titles_name		= "udf_titles". $suffix  ."[". $counter ."]";
			$udf_ids_name			= "udf_ids". $suffix  ."[". $counter ."]";
			$udf_data_ids_name		= "udf_data_ids". $suffix  ."[". $counter ."]";
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
						foreach(explode(",", $field->select_options) as $value){
			            	$dropValues[$value] = $value;
			        	}
			        	//echo $default_vals;
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
					case 'checkbox':       	
						?>
						    <div class="control-group">
						    	<label><?php echo $field->description;?></label>
						        <label class="control-label" for="<?php echo $udf_field_name ."[]"; ?>"><?php echo $field->title;?></label>
						        
						        <? 
						        	$row_limit = 4;
						        	$cnt = count(explode(",", $field->select_options));
						        	
									$cnter = 1;
									foreach(explode(",", $field->select_options) as $value){
										if ($cnter == 1 || $cnter % $row_limit == 1)
										echo "<div class='controls span2'>";

										echo "<label class='checkbox'>";
										echo form_checkbox($udf_field_name ."[]", $value, set_checkbox($udf_field_name ."[]", $value, in_array($value, explode(",", $default_vals))));
										echo " " .$value;
										echo "</label>";


										if ($cnter % $row_limit == 0 || $cnter == $cnt)
											echo "</div>";

										$cnter++;
									}
						        ?>
						    </div>
						<?php 
						break;
				}

				$field_names[] = $udf_field_name;
				
				echo form_hidden($udf_types_name, $field->type);
				echo form_hidden($udf_validations_name, $field->validation);
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

		echo form_hidden("udf_field_names" .$suffix, implode(",", $field_names));
	}
?>