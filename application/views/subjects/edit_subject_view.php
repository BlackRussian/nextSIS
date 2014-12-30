<div class="span9">
	<div class="row-fluid">
     	<div class="block">
       		<div class="block-content collapse in">
          		<div class="span9">
        		<?php
        			$hiddenflds = array('school_id' => $currentschoolid, 'syear' => $currentsyear, 'subject_id' => $subject_id);
        			echo form_open('subjects/editrecord', 'method="post" class="form-horizontal"', $hiddenflds);
        		?>
                <fieldset>
                  <?php $this->load->view('shared/display_errors');?>
                  <legend>Edit Subject</legend>
                  <div class="control-group">
                    <label class="control-label" for="selSemester">Title</label>
                    <div class="controls">
                    	<?php echo form_input('title', set_value('title', $title)); ?>
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label" for="selSemester">Short Name</label>
                    <div class="controls">
                    	<?php echo form_input('short_name', set_value('short_name', $short_name)); ?>
                    </div>
                  </div>
                  <div class="form-actions">
                  		<a href="/subjects" class="btn"><i class="icon-chevron-left icon-black"></i>Cancel</a>
						<?php echo form_submit('submit','Submit', 'class="btn btn-primary"');?>
						<?php 	echo form_close();?>
				</div>
				</fieldset>
        		</div>  			
  				  				
  			</div>
  		</div>
	</div>
</div>