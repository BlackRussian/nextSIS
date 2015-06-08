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
        					<?php echo form_open('schoolsemester/editrecord', 'method="post" class="form-horizontal"'); ?>
							<?php echo "<input type='hidden' id='school_id' name='school_id' value='" .$semesterobj->school_id ."'  />"?>
							<?php echo "<input type='hidden' id='semesterid' name='semesterid' value='" . $semesterobj->marking_period_id ."'  />"?>
							<?php echo form_hidden('schoolyear', set_value('schoolyear', $semesterobj->syear)); ?>
							
							<?php echo form_hidden('year_id', set_value('year_id', $semesterobj->year_id)); ?>
							
							<div class="control-group">
								<label class="control-label" for="title">Name/Title</label>
			                	<div class="controls">
			                      	<?php echo form_input('title',set_value('title', $semesterobj->title)); ?>
			                      	<p class="help-block">Enter the full name of the School term</p>
			                	</div>
		                	</div>
		                	
		                	<div class="control-group">
								<label class="control-label" for="short_name">Short Name</label>
			                	<div class="controls">
			                      	<?php echo form_input('short_name',set_value('short_name',$semesterobj->short_name)); ?>
			                      	<p class="help-block">Short Name of the term F14 , Year 20 etc</p>
			                	</div>
		                	</div>
		                	
		                	
		                	<div class="control-group">
								<label class="control-label" for="start_date">Start Date</label>
			                	<div class="controls">
			                      	<?php 
			                      	$js = array('name' => 'start_date','value'=>set_value('start_date', $semesterobj->start_date), 'id' => 'start_date');
			                      	echo form_input($js); ?>
			                      	<p class="help-block">Select start of the School Term</p>
			                	</div>
		                	</div>
		                	<div class="control-group">
								<label class="control-label" for="end_date">End Date</label>
			                	<div class="controls">
			                      	<?php 
			                      	$js = array('name' => 'end_date','value'=>set_value('end_date', $semesterobj->end_date), 'id' => 'end_date');
			                      	echo form_input($js); ?>
			                      	<p class="help-block">Select end of the School Term</p>
			                	</div>
		                	</div>
		                	
							
	                  		<div class="form-actions">
	                  			<a href="/schoolsemester/<?php echo $semesterobj->year_id;?>" class="btn"> <i class="icon-chevron-left icon-black"></i>Cancel</a>
							          <?php echo form_submit('submit','Submit', 'class="btn btn-primary"'); ?>
					        </div>
				          	<?php echo form_close(); ?>

				     </fieldset>
        		</div>				
  			</div>
  		</div>
	</div>
</div>
