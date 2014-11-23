
<!DOCTYPE html>
<!--
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
-->

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
  		</div>
  		
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
        		<?php echo form_open('person/addrecord'); ?>
					<h1>Add Person</h1>
					<table>
					<tr>
						<td>Title</td>
						<td>
						<select id="Title" name="Title">
						<?php foreach($titles as $title){ 
							$selected = False;
							$value= $title->id;
							$text = $title->label;
							//if($titleid == $value){$selected = 'selected';}
								
							echo '<option value="'. $value .'" '.$selected.'>'. $text . '</option>';
							
						}?>
						</select>
					</tr>
					
					<tr>
						<td>
							First Name
						</td>
						<td>
							<?php echo "<input type='text' id='fname' name='fname' />"?>
					</tr>
					<tr>
						<td>
						Middle Name
						</td>
						<td>
						<?php echo "<input type='text' id='mname' name='mname' />"?>
						</td>
					</tr>
					<tr>
						<td>
							Last Name
						</td>
						<td>
							<?php echo "<input type='text' id='lname' name='lname' />"?>
					</tr>
					<tr>
						<td>
							Common Name
						</td>
						<td>
							<?php echo "<input type='text' id='cname' name='cname' />"?>
					</tr>
					<tr>
						<td>Gender</td>
						<td>
						
						<select id="Gender" name="Gender">
						<?php foreach($genders as $gender){ 
						
							$selected = False;
							$value= $gender->id;
							$text = $gender->label;
							//if($genderid == $value){$selected = 'selected';}
								
							echo '<option value="'. $value .'" '.$selected.'>'. $text . '</option>';
						}?>
						</select>
					</tr>
					<tr>
						<td>
							User Name
						</td>
						<td>
							<?php echo "<input type='text' id='uname' name='uname' />"?>
					</tr>
					<tr>
						<td>
							User Roles
						</td>
						<td>
							<?php foreach($roles as $role){ 
							$selected="";
							
							echo "<input   type='checkbox' name='userrole[]'  value='". $role->id ."'". $selected ." />" .$role->label ."<br/>";
							//$selected = False;
							//$value= $gender->id;
							//$text = $gender->label;
							//if($genderid == $value){$selected = 'selected';}
								
							//echo '<option value="'. $value .'" '.$selected.'>'. $text . '</option>';
						}?>
						
						</td>
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