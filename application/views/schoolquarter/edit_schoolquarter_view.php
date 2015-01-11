<script>
			
			$(document).ready(function() { 
				
							 
			     $("#start_date").datepicker({
			     	dateFormat:"dd M yy"
			     }      	
			     );

			     $("#end_date").datepicker({
			     	dateFormat:"dd M yy"
			     });

			    $(".datepicker").datepicker();

			});			
		</script>
<div class="span9" id="content">
	<div class="row-fluid">
		<?php echo $this->load->view('templates/breadcrumb.php');?>
     	<div class="block">
       		<div class="block-content collapse in">
          		<div class="span9">
					<fieldset>
                  		<?php $this->load->view('shared/display_errors');?>
                  		<legend><?php echo $page_title;?></legend>
        					<?php echo form_open('schoolquarter/editrecord', 'method="post" class="form-horizontal"'); ?>
							<?php echo "<input type='hidden' id='school_id' name='school_id' value='" .$schoolquarterobj->school_id ."'  />"?>
							<?php echo "<input type='hidden' id='schoolquarter_id' name='schoolquarter_id' value='" . $schoolquarterobj->marking_period_id ."'  />"?>
							<?php echo form_hidden('schoolyear', set_value('schoolyear', $schoolquarterobj->syear)); ?>
							<?php echo form_hidden('semester_id', set_value('semester_id', $schoolquarterobj->semester_id)); ?>
							<?php echo form_hidden('year_id', set_value('year_id', $schoolquarterobj->year_id)); ?>
							
							<div class="control-group">
								<label class="control-label" for="title">Name/Title</label>
			                	<div class="controls">
			                      	<?php echo form_input('title',set_value('title', $schoolquarterobj->title)); ?>
			                	</div>
		                	</div>
		                	
		                	<div class="control-group">
								<label class="control-label" for="short_name">Short Name</label>
			                	<div class="controls">
			                      	<?php echo form_input('short_name',set_value('short_name',$schoolquarterobj->short_name)); ?>
			                	</div>
		                	</div>
		                	
		                	
		                	<div class="control-group">
								<label class="control-label" for="start_date">Start Date</label>
			                	<div class="controls">
			                      	<?php 
			                      	$js = array('name' => 'start_date','value'=>set_value('start_date', $schoolquarterobj->start_date), 'id' => 'start_date');
			                      	echo form_input($js); ?>
			                	</div>
		                	</div>
		                	<div class="control-group">
								<label class="control-label" for="end_date">End Date</label>
			                	<div class="controls">
			                      	<?php 
			                      	$js = array('name' => 'end_date','value'=>set_value('end_date', $schoolquarterobj->end_date), 'id' => 'end_date');
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
