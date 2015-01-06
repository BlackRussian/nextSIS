<div class="span9" id="content">
	<div class="row-fluid">
		<?php echo $this->load->view('templates/breadcrumb.php');?>
     	<div class="block">
       		<div class="block-content collapse in">
          		<div class="span9">
					<fieldset>
                  		<?php $this->load->view('shared/display_errors');?>
                  		<legend><?php echo $page_title;?></legend>
        					<?php echo form_open('gradelevels/editrecord', 'method="post" class="form-horizontal"'); ?>
							<?php echo "<input type='hidden' id='gradelevel_id' name='gradelevel_id' value='" . $gradelevelobj->id ."'  />"?>
							<?php echo "<input type='hidden' id='school_id' name='school_id' value='" .$currentschoolid ."'  />"?>
							<div class="control-group">
								<label class="control-label" for="selGradeLevel">Name/Title</label>
			                	<div class="controls">
			                      	<?php echo form_input('title',set_value('title', $gradelevelobj->title)); ?>
			                	</div>
		                	</div>
							<div class="control-group">
		                    	<label class="control-label" for="selGradeLevel">Next Grade Level</label>
		                    	<div class="controls">
		                      		<?php echo form_dropdown('selGradeLevel', $gradelevels, $gradelevelobj->next_grade_id,'id="selGradeLevel"'); ?>
		                    	</div>
		                	</div>
	                  		<div class="form-actions">
	                  			<a href="/gradelevels" class="btn"> <i class="icon-chevron-left icon-black"></i>Cancel</a>
							          <?php echo form_submit('submit','Submit', 'class="btn btn-primary"'); ?>
					        </div>
				          	<?php echo form_close(); ?>
				     </fieldset>
        		</div>				
  			</div>
  		</div>
	</div>
</div>
