<div class="span9" id="content">
	<div class="row-fluid">
     	<div class="block">
       		<div class="block-content collapse in">
          		<div class="span9">
        		<?php
        			$hiddenflds = array('school_id' => $currentschoolid, 'syear' => $currentsyear, 'subject_id' => $subject_id, 'course_id' => $course_id);
        			echo form_open('courses/editrecord', 'method="post" class="form-horizontal"', $hiddenflds);
        		?>
                <fieldset>
                  <?php $this->load->view('shared/display_errors');?>
                  <legend><?php echo $page_title;?></legend>
                  <div class="control-group">
                    <label class="control-label">Subject</label>
                    <div class="controls">
                      <span class="input uneditable-input"><?php echo $title; ?></span>
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label" for="selGradeLevel">Grade Level</label>
                    <div class="controls">
                      <?php echo form_dropdown('selGradeLevel', $gradelevels,set_value('selGradeLevel', $grade_level),'id="selGradeLevel"'); ?>
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label" for="title">Title</label>
                    <div class="controls">
                      <?php echo form_input('title', set_value('title', $title)); ?>
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label" for="short_name">Short Name</label>
                    <div class="controls">
                      <?php echo form_input('short_name', set_value('short_name', $short_name)); ?>
                    </div>
                  </div>
                  <div class="form-actions">
                      <a href="/subjects/courses/<?php echo $subject_id;?>" class="btn"><i class="icon-chevron-left icon-black"></i>Cancel</a>
                      <?php echo form_submit('submit','Submit', 'class="btn btn-primary"'); ?>
                      <?php echo form_close(); ?>
                  </div>
                </fieldset>
        		</div>  			
  				  				
  			</div>
  		</div>
	</div>
</div>