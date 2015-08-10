<div class="span9" id="content">
	<div class="row-fluid">
     	<div class="block">
       		<div class="block-content collapse in">
          		<div class="span9">
        		<?php
        			$hiddenflds = array('term_course_id' => $course->term_course_id, 'subject_id' => $subject_id,'course_id'=>$course->course_id);
        			echo form_open('courses/edittermcourse', 'method="post" class="form-horizontal"', $hiddenflds);
        		?>
                <fieldset>
                  <?php $this->load->view('shared/display_errors');?>
                  <legend><?php echo $page_title;?></legend>
                  <div class="control-group">
                    <label class="control-label">Course Name</label>
                    <div class="controls"><span class="input uneditable-input"><?php echo $course->course_title ." - " . $course->short_name; ?></span></div>
                  </div>
                  <div class="control-group">
                    <label class="control-label">Grade Level</label>
                    <div class="controls"><span class="input uneditable-input"><?php echo $course->grade_title ?></span></div>
                  </div>
                  <div class="control-group">
                    <label class="control-label" for="selTerm">Term</label>
                    <div class="controls">
                      <?php echo form_dropdown('selTerm', $markingperiod,set_value('selTerm', $course->marking_period_id.'|'.$course->term_short_name),'id="selTerm" disabled="disabled"');?>
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label" for="title">Teacher</label>
                    <div class="controls">
                    	 <?php echo form_dropdown('selTeacher', $teachers, set_value('selTeacher', $course->teacher_id),'id="selTeacher" disabled="disabled"'); ?>
                    </div>
                  </div>
                  <div class="form-actions">
                  		<a href="/courses/<?php echo $course->course_id;?>" class="btn"><i class="icon-chevron-left icon-black"></i>Cancel</a>
						          <?php echo form_submit('submit','Submit', 'class="btn btn-primary"'); ?>
						          <?php echo form_close(); ?>
				          </div>
				        </fieldset>
        		</div>  			
  				  				
  			</div>
  		</div>
	</div>
</div>