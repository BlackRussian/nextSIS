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
							<?php echo "<input type='hidden' id='school_id' name='school_id' value='" .$school_id ."'  />"?>
							<div class="control-group">
								<label class="control-label" for="fname">Name</label>
			                	<div class="controls">
			                		<span class="input uneditable-input"><?php echo $fullname ?></span>
			                      	<?php
			                      	 echo  form_hidden('syear',set_value('syear', $currentsyear));
									 echo  form_hidden('person_id',set_value('person_id', $personid));
									 echo  form_hidden('personrole',set_value('personrole', $personrole));
									 ?>
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
		                	<?php		                    	
									//foreach($roles as $role){									
										//echo form_checkbox('userrole[]', $role->id, set_checkbox('userrole[]', $role->id, in_array($role->id, $personroles)));
										//echo " " .$role->label . "<br />";									
									//}
									$dataString = serialize($currentschterms);
									echo  form_hidden('hfvschterms',set_value('hfvschterms', $dataString));
									foreach($currentschterms as $sterms)
									{?>
										<div class="control-group">
		                		<label class="control-label" for="checkboxTermcourse"><?php echo($sterms->title) ?> Courses</label>
		                		<div class="controls">
		                			<?php 
		                				$cboxname = 'termcourse'.$sterms -> marking_period_id.'[]';
									//	print_r($personcourses);
									if($termcourses)	
									{                    	
										foreach($termcourses as $termcourse){
											//print_r($termcourse);
											if($termcourse->marking_period_id == $sterms->marking_period_id)
											{
												echo form_checkbox($cboxname, $termcourse->term_course_id, set_checkbox($cboxname, $termcourse->term_course_id, in_array($termcourse->term_course_id, $personcourses)));
											echo " " .$termcourse->course_title ." - " .$termcourse->first_name." ".$termcourse->surname."<br />";	
											}								
																			
										}
									}
							
		                			?>
		                		</div>
		                	</div>
									<?php
									}
							?>
		                	
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
