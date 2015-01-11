<div class="span9" id="content">
	<div class="row-fluid">
		<?php echo $this->load->view('templates/breadcrumb.php');?>
     	<div class="block">
       		<div class="block-content collapse in">
          		<div class="span9">
					<fieldset>
                  		<?php $this->load->view('shared/display_errors');?>
                  		<legend><?php echo $page_title;?></legend>
        					<?php echo form_open('schoolyear/editrecord', 'method="post" class="form-horizontal"'); ?>
							<?php echo "<input type='hidden' id='school_id' name='school_id' value='" .$schoolyearobj->school_id ."'  />"?>
							<?php echo "<input type='hidden' id='schoolyear_id' name='schoolyear_id' value='" . $schoolyearobj->marking_period_id ."'  />"?>
							<div class="control-group">
								<label class="control-label" for="title">Name/Title</label>
			                	<div class="controls">
			                      	<?php echo form_input('title',set_value('title', $schoolyearobj->title)); ?>
			                	</div>
		                	</div>
		                	
		                	<div class="control-group">
								<label class="control-label" for="short_name">Short Name</label>
			                	<div class="controls">
			                      	<?php echo form_input('short_name',set_value('short_name',$schoolyearobj->short_name)); ?>
			                	</div>
		                	</div>
		                	
		                	
		                	<div class="control-group">
								<label class="control-label" for="start_date">Start Date</label>
			                	<div class="controls">
			                      	<?php 
			                      	$js = array('name' => 'start_date','value'=>set_value('start_date', $schoolyearobj->start_date), 'id' => 'start_date');
			                      	echo form_input($js); ?>
			                	</div>
		                	</div>
		                	<div class="control-group">
								<label class="control-label" for="end_date">End Date</label>
			                	<div class="controls">
			                      	<?php 
			                      	$js = array('name' => 'end_date','value'=>set_value('end_date', $schoolyearobj->end_date), 'id' => 'end_date');
			                      	echo form_input($js); ?>
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
