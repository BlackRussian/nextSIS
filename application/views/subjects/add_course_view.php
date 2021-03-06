<div class="span9" id="content">
	<div class="row-fluid">
      <?php echo $this->load->view('templates/breadcrumb.php');?>
     	<div class="block">
       		<div class="block-content collapse in">
          		<div class="span9">
        		<?php
        			$hiddenflds = array('subject_id' => $subject->subject_id);
        			echo form_open('courses/addrecord', 'method="post" class="form-horizontal"', $hiddenflds);
        		?>
                <fieldset>
                  <?php $this->load->view('shared/display_errors');?>
                  <legend><?php echo $page_title;?></legend>
                  <div class="control-group">
                    <label class="control-label">Subject</label>
                    <div class="controls">
                      <span class="input uneditable-input"><?php echo $subject->title; ?></span>
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label" for="selGradeLevel">Grade Level</label>
                    <div class="controls">
                      <?php echo form_dropdown('selGradeLevel', $gradelevels,'','id="selGradeLevel"'); ?>
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label" for="title">Title</label>
                    <div class="controls">
                    	<?php echo form_input('title', set_value('title')); ?>
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label" for="short_name">Short Name</label>
                    <div class="controls">
                    	<?php echo form_input('short_name', set_value('short_name')); ?>
                    </div>
                  </div>
                  <div class="form-actions">
                  		<a href="/subjects/courses/<?php echo $subject->subject_id;?>" class="btn"><i class="icon-chevron-left icon-black"></i>Cancel</a>
						          <?php echo form_submit('submit','Submit', 'class="btn btn-primary"'); ?>
						          <?php echo form_close(); ?>
				          </div>
				        </fieldset>
        		</div>  			
  				  				
  			</div>
  		</div>
	</div>
</div>