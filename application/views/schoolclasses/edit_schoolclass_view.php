<div class="span9" id="content">
	<div class="row-fluid">
		<?php echo $this->load->view('templates/breadcrumb.php');?>
     	<div class="block">
       		<div class="block-content collapse in">
          		<div class="span9">
					<fieldset>
                  		<?php $this->load->view('shared/display_errors');?>
                  		<legend><?php echo $page_title;?></legend>

        				<?php echo form_open('schoolclasses/editrecord', 'method="post" class="form-horizontal"'); ?>
        				<?php echo "<input type='hidden' id='class_id' name='class_id' value='" . $classobj->id ."'  />"?>
        				<div class="control-group">
							<label class="control-label" for="selGradeLevel">Name/Title</label>
			                <div class="controls">
			                      <?php echo form_input('title',set_value('title', $classobj->title)); ?>
			                </div>
		                </div>
		               	<div class="control-group">
		                    <label class="control-label" for="selGradeLevel">Grade Level</label>
		                    <div class="controls">
		                      <?php echo form_dropdown('selGradeLevel', $gradelevels, $classobj->gradelevel_id,'id="selGradeLevel"'); ?>
		                    </div>
		                </div>
                  		<div class="form-actions">
                  			<a href="/schoolclasses/" class="btn"> <i class="icon-chevron-left icon-black"></i>Cancel</a>
						          <?php echo form_submit('submit','Submit', 'class="btn btn-primary"'); ?>
				        </div>
			          <?php echo form_close(); ?>
				     </fieldset>
        		</div>				
  			</div>
  		</div>
	</div>
</div>