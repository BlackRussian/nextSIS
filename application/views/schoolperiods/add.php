
<div class="span9" id="content">
	<div class="row-fluid">
		<?php echo $this->load->view('templates/breadcrumb.php');?>
     	<div class="block">
       		<div class="block-content collapse in">
          		<div class="span12">
          			<fieldset>
                  		<?php $this->load->view('shared/display_errors');?>
                  		<legend><?php echo $page_title;?></legend>
                  		<?php echo form_open('schoolperiods/addrecord', 'method="post" class="form-horizontal"'); ?>
                  		<?php echo "<input type='hidden' id='school_id' name='school_id' value='" .$currentschoolid ."'  />"?>
						<?php echo "<input type='hidden' id='syear' name='syear' value='" .$currentsyear ."'  />"?>
                  		<div class="control-group">
							<label class="control-label" for="selGradeLevel">Period Title</label>
		                	<div class="controls">
		                      	<?php echo form_input('title',set_value('title')); ?>
		                      	<p class="help-block">Enter the full name of the School Year</p>
		                	</div>
		                </div>
		                <div class="control-group">
		                	<label class="control-label" for="selGradeLevel">Short Name</label>
		                	<div class="controls">
		                		<?php echo form_input('short_name',set_value('short_name')); ?>
			                    <p class="help-block">Enter the short name of the period</p>
		                	</div>
		                </div>
		                <div class="control-group">
		                	<label class="control-label" for="selGradeLevel">Start Time</label>
		                	<div class="controls">
		                		<select style="width:70px" id="start_time_hr" name="start_time_hr">
						<?php 
						$time= explode(":", $start_time);
						$time2 = explode(" ", $time[1]);
						echo"<option value='n/a' selected>n/a</option>";
						 foreach($hoursopts as $hr){ 
							$selected = False;
							if($time[0] == $hr)
							{
							$selected = selected;
							}
							$value= $hr;
							$text = $hr;
							//if($titleid == $value){$selected = 'selected';}
								
							echo '<option value="'. $value .'" '.$selected.'>'. $text . '</option>';
							
						}?>
						
						</select>
						<select style="width:70px" id="start_time_mins" name="start_time_mins">
						<?php  echo "<option value='n/a' selected>n/a</option>";
						foreach($minutesopts as $mins){ 
							$selected = False;
							if($time2[0] == $mins)
							{
								$selected = selected;
							}
							$value= $mins;
							$text = $mins;
							//if($titleid == $value){$selected = 'selected';}
								
							echo '<option value="'. $value .'" '.$selected.'>'. $text . '</option>';
							
						}?>
						
						</select>
						<select style="width:70px" id="start_time_ampm" name="start_time_ampm">
						<?php  echo "<option value='n/a' selected>n/a</option>";
						if($time2[1] == "AM")
						{
							echo "<option selected value='AM'>AM</option>";
							echo "<option value='PM'>PM</option>";
						}else if($time2[1] == "PM"){
							echo "<option value='AM'>AM</option>";
							echo "<option selected value='PM'>PM</option>";
						}else{
							
							echo "<option value='AM'>AM</option>";
							echo "<option value='PM'>PM</option>";
						}
						
						?>
						
						</select>
		                		
		                		
			                    <p class="help-block">Enter the short name of the period</p>
		                	</div>
		                </div>
                  		
                  		
                  		<div class="control-group">
		                	<label class="control-label" for="selGradeLevel">End Time</label>
		                	<div class="controls">
		                		<select style="width:70px" id="end_time_hr" name="end_time_hr">
						<?php 
						$time= explode(":", $end_time);
						$time2 = explode(" ", $time[1]);
						echo"<option value='n/a' selected>n/a</option>";
						 foreach($hoursopts as $hr){ 
							$selected = False;
							if($time[0] == $hr)
							{
								$selected = selected;
							}
							$value= $hr;
							$text = $hr;
							//if($titleid == $value){$selected = 'selected';}
								
							echo '<option value="'. $value .'" '.$selected.'>'. $text . '</option>';
							
						}?>
						
						</select>
						<select style="width:70px" id="end_time_mins" name="end_time_mins">
						<?php 
						
						 echo "<option value='n/a' selected>n/a</option>";
						foreach($minutesopts as $mins){
							$selected = False;
							
							if($time2[0] == $mins)
							{
								$selected = selected;
							}
							
							$value= $mins;
							$text = $mins;
							//if($titleid == $value){$selected = 'selected';}
								
							echo '<option value="'. $value .'" '.$selected.'>'. $text . '</option>';
							
						}?>
						
						</select>
						<select style="width:70px" id="end_time_ampm" name="end_time_ampm">
						<?php
						echo "<option value='n/a' selected>n/a</option>";
						$selected = false;
						if($time2[1] == "AM")
						{
							echo "<option selected value='AM'>AM</option>";
							echo "<option value='PM'>PM</option>";
						}else if($time2[1] == "PM"){
							echo "<option value='AM'>AM</option>";
							echo "<option selected value='PM'>PM</option>";
						}else{
							
							echo "<option value='AM'>AM</option>";
							echo "<option value='PM'>PM</option>";
						}
						
						
						
						?>
						
						</select>
		                		
		                		
		                		
			                    <p class="help-block">Enter the short name of the period</p>
		                	</div>
		                </div>
                  		
                  		<div class="control-group">
		                	<label class="control-label" for="selGradeLevel">Use in Attendance</label>
		                	<div class="controls">
		                		<?php echo "<input type='checkbox' id='attendance' value='1' name='attendance' />"?>
			                    <p class="help-block">Enter the short name of the period</p>
		                	</div>
		                </div>
		                
		                <div class="control-group">
		                	<label class="control-label" for="ignore_scheduling">Ignore for Schedule</label>
		                	<div class="controls">
		                		<?php echo "<input type='checkbox' id='ignore_scheduling' value='1' name='ignore_scheduling' />"?>
		                		<p class="help-block">Select if this period should be used as a part of scheduling</p>
		                	</div>
		                </div>
		                 <div class="control-group">
		                	<label class="control-label" for="sort_order">Sort Order</label>
		                	<div class="controls">
		                		<select id="sort_order" name="sort_order">
								<?php 
									echo "'<option value='n/a' selected>n/a</option>'";
									foreach($allsortopts as $opt){ 
									$selected = False;
									$value= $opt;
									$text = $opt;
									//if($titleid == $value){$selected = 'selected';}
										
									echo '<option value="'. $value .'" '.$selected.'>'. $text . '</option>';
									
								}?>
								
								</select>
								<p class="help-block">Select the order of the period</p>
		                	</div>
		                </div>
		                 <div class="form-actions">
		                 	<a href="/schoolperiods/" class="btn"> <i class="icon-chevron-left icon-black"></i>Cancel</a>
		                 	<?php echo form_submit('submit','submit','class="btn btn-primary"'); ?>
							<?php echo form_close(); ?>
		                 </div>
                  		
                  	</fieldset>
          		</div>
            </div>
       </div>
    </div>
</div>


  
  