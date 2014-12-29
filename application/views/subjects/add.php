<div class="span9">
	<div class="row-fluid">
     	<div class="block">
       		<div class="block-content collapse in">
          		<div class="span9">
        		<?php
        			$hiddenflds = array('school_id' => $currentschoolid, 'syear' => $currentsyear);
        			echo form_open('subjects/addrecord', 'method="post" class="form-horizontal"', $hiddenflds);
        		?>
                <fieldset>
                  <?php $this->load->view('shared/display_errors');?>
                  <legend>Add Subject</legend>
                  <div class="control-group">
                    <label class="control-label" for="selSemester">Title</label>
                    <div class="controls">
                    	<?php echo form_input('title'); ?>
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label" for="selSemester">Short Name</label>
                    <div class="controls">
                    	<?php echo form_input('short_name'); ?>
                    </div>
                  </div>
                  <div class="form-actions">
						<?php echo form_submit('submit','Submit', 'class="btn btn-primary"'); ?>
						<?php echo form_close(); ?>
				</div>
				</fieldset>
        		</div>  			
  				  				
  			</div>
  		</div>
	</div>
</div>