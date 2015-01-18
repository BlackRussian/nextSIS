<div class="span9" id="content">
	<div class="row-fluid">
		<?php echo $this->load->view('templates/breadcrumb.php');?>
     	<div class="block">
       		<div class="block-content collapse in">
          		<div class="span9">
					<fieldset>
                  		<?php $this->load->view('shared/display_errors');?>
                  		<legend><?php echo $page_title;?></legend>
        					<?php echo form_open('person/addclass', 'method="post" class="form-horizontal"'); ?>
							<?php echo "<input type='hidden' id='school_id' name='school_id' value='" .$currentschoolid ."'  />"?>
							<div class="control-group">
								<label class="control-label" for="fname">Name</label>
			                	<div class="controls">
			                      	<?php
			                      	 echo  form_hidden('syear',set_value('syear', $currentsyear));
									  echo  form_hidden('person_id',set_value('person_id', $personid));
			                      	 echo  form_label(set_value('fullname', $fullname)); ?>
			                	</div>
		                	</div>
							<div class="control-group">
		                    	<label class="control-label" for="selGradeLevel">Classes</label>
		                    	<div class="controls">
		                      		<?php 
		                      		if($classid)
									{
										echo form_dropdown('class_id', $classes, $classid,'id="class_id"');
									}else{
										echo form_dropdown('class_id', $classes, 'id="class_id"');
									}
		                      		 ?>
		                    	</div>
		                	</div>
	                  		<div class="form-actions">
	                  			<a href="/person/<?php echo($personrole)?>" class="btn"> <i class="icon-chevron-left icon-black"></i>Cancel</a>
							          <?php echo form_submit('submit','Submit', 'class="btn btn-primary"'); ?>
					        </div>
				          	<?php echo form_close(); ?>
				     </fieldset>
        		</div>				
  			</div>
  		</div>
	</div>
</div>
