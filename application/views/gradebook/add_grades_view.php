<div class="span9" id="content">
	<div class="row-fluid">
     	<div class="block">
       		<div class="block-content collapse in">
          		<div class="span12">
					<?php
	        			$hiddenflds = array('grade_type_id' => $grade_type_id, 'term_course_id' => $term_course_id);
	        			echo form_open('gradebook/addrecord', 'method="post" class="form-horizontal"', $hiddenflds);
	        		?>
		                <fieldset>
		                <?php $this->load->view('shared/display_errors');?>
		                <legend><?php echo $page_title;?></legend>
		                <div class="accordion" id="accordion1">
						<?php 
						//print_r($_SESSION);
						//echo $this->db->last_query();
						$counter 					= 0;
						$gradeid_field_name			= "";
						$grade_field_name			= "";
						$studentid_field_name		= "";
						$studentName_field_name		= "";
						$oldgrade_field_name		= "";
						$udfData					= null;
						foreach($query as $student) {
							$gradeid_field_name			= "gradeid[". $counter ."]";
							$grade_field_name			= "grade[". $counter ."]";
							$studentid_field_name		= "studentid[". $counter ."]";
							$studentName_field_name		= "studentName[". $counter ."]";
							$oldgrade_field_name		= "oldgrade[". $counter ."]";
							$aID 						= "collapse". $counter;

							$data = array(
				              'name'        	=> $grade_field_name,
				              'id'          	=> $grade_field_name,
				              'autocomplete'    => 'off'
				            );

				            $udfData["udf"]		= $udfs[$student->studentid];
				            $udfData["suffix"] 	= $student->studentid;
						?>
			                

			                <div class="accordion-group">
						    <div class="accordion-heading">
						      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#<?=$aID?>">
						        <?php echo $student->student;?>
						      </a>
						    </div>
						    <div id="<?=$aID?>" class="accordion-body collapse out">
						      <div class="accordion-inner">
						        	<div class="control-group">
					                    <label class="control-label" for="<?php echo $grade_field_name; ?>">Grade</label>
					                    <div class="controls">
					                    	<?php echo form_input($data, set_value($grade_field_name, $student->points + 0)); ?>
					                    	<?php echo form_hidden($studentid_field_name, $student->studentid); ?>
					                    	<?php echo form_hidden($studentName_field_name, $student->student); ?>
					                    	<?php echo form_hidden($gradeid_field_name, $student->grade_id); ?>
					                    	<?php echo form_hidden($oldgrade_field_name, $student->points); ?>
					                    </div>
			                		</div>
			                		<?php $this->load->view('shared/display_udf_view',$udfData);?>
						      </div>
						    </div>
						  </div>
		                <?php 
						$counter=$counter+1;
		                }?>
		                </div>
						<div class="form-actions">
	                  		<a href="/gradebook/gradetypelist/<?php echo $term_course_id; ?>" class="btn"><i class="icon-chevron-left icon-black"></i>Cancel</a>
							          <?php echo form_submit('submit','Submit', 'class="btn btn-primary"'); ?>
							          <?php echo form_close(); ?>
					    </div>
						</fieldset>	
        		</div>  			
  				  				
  			</div>
  		</div>
	</div>
</div>