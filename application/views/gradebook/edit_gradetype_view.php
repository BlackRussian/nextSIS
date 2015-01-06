<div class="span9">
	<div class="row-fluid">
     	<div class="block">
       		<div class="block-content collapse in">
          		<div class="span12">
					<?php
	        			$hiddenflds = array('course_id' => $course_id,'grade_type_id' => $grade_type->grade_type_id);
	        			echo form_open('gradebook/editgradetyperecord', 'method="post" class="form-horizontal"', $hiddenflds);	        			
	        		?>
		                <fieldset>
		                <?php $this->load->view('shared/display_errors');?>
		                <legend><?php echo $page_title;?></legend>		                
		                <div class="control-group">
		                    <label class="control-label" for="title"><?php echo "Title";?></label>
		                    <div class="controls">
		                    	<?php echo form_input("title", set_value("title", $grade_type->title)); ?>
		                    </div>
		                </div>

		                <div class="control-group">
		                    <label class="control-label" for="weight"><?php echo "Weight";?></label>
		                    <div class="controls">
		                    	<?php echo form_input("weight", set_value("weight", $grade_type->weight)); ?>
		                    </div>
		                </div>
		              
						<div class="form-actions">
	                  		<a href="/gradebook/gradetypelist/<?php echo $course_id;?>" class="btn"><i class="icon-chevron-left icon-black"></i>Cancel</a>
							          <?php echo form_submit('submit','Submit', 'class="btn btn-primary"'); ?>
							          <?php echo form_close(); ?>
					    </div>
						</fieldset>	
        		</div>  			
  				  				
  			</div>
  		</div>
	</div>
</div>