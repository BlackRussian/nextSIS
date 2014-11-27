
<!--<!DOCTYPE html>

 nextSIS person view
 
 PURPOSE 
 This displays a list of people in the database.
 
 LICENCE 
 This file is part of nextSIS.
 
 nextSIS is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as
 published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
  
 nextSIS is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
  
 You should have received a copy of the GNU General Public License along with nextSIS. If not, see
 <http://www.gnu.org/licenses/>.
  
 Copyright 2012 http://nextsis.org


<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">		
		<link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.css');?>" type="text/css">
		<link rel="stylesheet" href="<?php echo base_url('assets/css/nextsis.css');?>" type="text/css">
		<link rel="shortcut icon" href="<?php echo base_url('assets/img/nextsis.favicon.png');?>">
		<title><?php echo $this->lang->line('student_information_system');?></title>				
	</head>
	
	<body>
		<div class="navbar">
  			<div class="navbar-inner">
  				<div class="container">
  				   	<a class="brand" href="home">nextSIS&gt;</a>
  				   	<div class="navbar-content">
    					<ul class="nav">
    						<li><a href="home"><i class="icon-home"></i>&nbsp;<?php echo $this->lang->line("home");?></a></li>
      						<li class="active"><a href=""><i class="icon-user"></i>&nbsp;<?php echo $this->lang->line("people");?></a></li>
      						<li><a href=""><i class="icon-list-alt"></i>&nbsp;<?php echo $this->lang->line("courses");?></a></li>
      						<li><a href=""><i class="icon-wrench"></i>&nbsp;<?php echo $this->lang->line("setup");?></a></li>
      						<li><a href=""><i class="icon-question-sign"></i>&nbsp;<?php echo $this->lang->line("help");?></a></li>
      						<li><a href="person/logout"><i class="icon-off"></i>&nbsp;<?php echo $this->lang->line("logout");?></a></li>
  				   		</ul>
    					<ul class="nav pull-right">
      						<li><a href="person/me"><i class="icon-user"></i>&nbsp;<?php echo $username;?></a></li>
    					</ul>  				   		
  				   	</div>
  				</div>
  			</div>
  		</div>-->
  		
  		<div class="container-fluid">
  			<div class="row-fluid">
  				<div class="span4 navleft">
  					<ul class="nav nav-pills nav-stacked">
  						<li class="active"><a href=""><?php echo $this->lang->line("search");?>&nbsp;<i class="icon-search icon-white"></i></a></li>
  						<li><a href="person/add"><?php echo $this->lang->line("add_new_person");?></a></li>
  						<li><a href=""><?php echo $this->lang->line("attendance");?></a></li>
  						<li><a href=""><?php echo $this->lang->line("grades");?></a></li>  						  						
  					</ul>
  					<div class="well">
  						<p><b><?php echo $this->lang->line("help");?></b>&nbsp;<?php echo $this->lang->line("sample_help_message");?></p>
  					</div>
  				</div>
  				
        		<div class="span8">
        		<?php echo form_open('gradelevels/editrecord'); ?>
					<h1>Edit Grade Level</h1>
					<p class="text-error"><?php echo validation_errors();?></p>
					<table>
					
					<?php echo "<input type='hidden' id='school_id' name='school_id' value='" .$currentschoolid ."'  />"?>
					<?php echo "<input type='hidden' id='syear' name='syear' value='" .$currentsyear ."'  />"?>
					<tr>
						<td>
							Period Title
						</td>
						<td>
							<?php 
							$val="";
							if(isset($title))
							{
								$val = $title;
							}
							echo "<input type='text' id='title' name='title' value='". $val . "' />"?>
					</tr>
					<tr>
						<td>
							Short Name
						</td>
						<td>
							<?php 
							
							$val="";
							if(isset($short_name))
							{
								$val = $short_name;
							}
							echo "<input type='text' id='short_name' name='short_name' value='". $val . "'  />"?>
					</tr>
					<tr>
						<td>Start Time</td>
						<td>
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
						}else{
							echo "<option value='AM'>AM</option>";
							echo "<option selected value='PM'>PM</option>";
						}
						
						?>
						
						</select>
					</tr>
					<tr>
						<td>End Time</td>
						<td>
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
						}else{
							echo "<option value='AM'>AM</option>";
							echo "<option selected value='PM'>PM</option>";
						}
						
						
						
						?>
						
						</select>
						</td>
					</tr>
					<tr>
						<td>
							Use in Attendance
						</td>
						<td>
							<?php
							$cbstatus="";
							if($attendance=="1")
								$cbstatus="checked";
							 echo "<input type='checkbox' id='attendance' value='1' name='attendance' " . $cbstatus ." />"?>
					</tr>
					<tr>
						<td>
							Ignore for Schedule
						</td>
						<td>
							<?php
							$cbstatus="";
							if($ignore_scheduling=="1")
								$cbstatus="checked";
						echo "<input type='checkbox' id='ignore_scheduling' value='1' name='ignore_scheduling'" . $cbstatus ." />"?>
					</tr>
					<tr>
						<td>Sort Order</td>
						<td>
						<select id="sort_order" name="sort_order">
						<?php foreach($gradelevels as $level){ 
							$selected = False;
							$value= $level->id;
							$text = $level->title;
							//if($titleid == $value){$selected = 'selected';}
								
							echo '<option value="'. $value .'" '.$selected.'>'. $text . '</option>';
							
						}?>
						echo '<option value='n/a' selected>n/a</option>';
						</select>
					</tr>
					
					<tr>
						<td colspan="2">
						<?php echo form_submit('submit','submit'); ?>
						<?php echo form_close(); ?>
							
							
						</td>
					</tr>
					</table>
        		</div>  			
  				  				
  			</div>
  		</div>
  		
	</body>
</html>