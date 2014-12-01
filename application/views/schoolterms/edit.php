
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
  		<script type="text/javascript">
               $(document).ready(function(){
                     $("#startdate").datepicker({
                     	dateFormat:"yy-MM-dd"
                     }      	
                     );
               });
               $(document).ready(function(){
                     $("#enddate").datepicker({
                     	dateFormat:"yy-MM-dd"
                     });
               });
       </script>
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
        		<?php echo form_open('schoolterms/editrecord'); ?>
					<h1>Edit School Period</h1>
					<p class="text-error"><?php echo validation_errors();?></p>
					<table>
					
					<?php echo "<input type='hidden' id='school_id' name='school_id' value='" .$currentschoolid ."'  />"?>
					<?php echo "<input type='hidden' id='syear' name='syear' value='" .$currentsyear ."'  />"?>
					<?php echo "<input type='hidden' id='termid' name='termid' value='" .$termid ."'  />"?>
					
					<?php echo "<input type='hidden' id='db_sdate' name='db_sdate' value='" .$db_sdate ."'  />"?>
					<?php echo "<input type='hidden' id='db_edate' name='db_edate' value='" .$db_edate ."'  />"?>
					
					<tr>
						<td>
							 Title
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
							Start Date
						</td>
						<td>
							<?php 
							
							$val="";
							if(isset($startdate))
							{
								$val = $startdate;
							}
							echo "<input type='text' id='startdate' name='startdate' value='". $val . "'  />"?>
					</tr>
					<tr>
						<td>End Date</td>
						<td>
						<?php 
							
							$val="";
							if(isset($enddate))
							{
								$val = $enddate;
							}
							echo "<input type='text' id='enddate' name='enddate' value='". $val . "'  />"?>
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