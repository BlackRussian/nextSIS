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
  						<li ><a href=""><?php echo $this->lang->line("search");?>&nbsp;<i class="icon-search icon-white"></i></a></li>
  						<li ><a href="../schoolterms/listing"><?php echo $this->lang->line("school_terms");?></a></li> 	
  						<li><a href="../gradelevels/listing"><?php echo $this->lang->line("grade_levels");?></a></li>  
  						<li><a href="../schoolperiods/listing"><?php echo $this->lang->line("school_periods");?></a></li> 	
  						<li class="active"><a href="../grades/listing"><?php echo $this->lang->line("course_grades");?></a></li> 		
  							  						
  					</ul>
  					<div class="well">
  						<p><b><?php echo $this->lang->line("help");?></b>&nbsp;<?php echo $this->lang->line("sample_help_message");?></p>
  					</div>
  				</div>
  				
        		<div class="span8">
        			<?php echo form_open('grades/listing'); ?>
					<h1><?php echo $this->lang->line("course_grades");?></h1>
					<table>
					<tr>
						<td>
							Course:
							<select id="course" name="course">
						<?php 
						echo '<option selected value="0">Select Course</option>';
						foreach($courses as $course){ 
							$selected = False;
							$value= $course->subjectcourse_id;
							$text = $course->subjectcourse_title;
							if($courseid == $value){$selected = 'selected';}
								
							echo '<option value="'. $value .'" '.$selected.'>'. $text . '</option>';
							
						}?>
						</select>
						</td>
						
						
					</tr>
					<tr>
						<td>
							<?php echo form_submit('submit','Search',"class='active'"); ?>
						</td>
					</tr>
					<tr>
						<td>
							&nbsp;
						</td>
					</tr>
					
					</table>
					<table>
					
					<tr>
						<td>
							Course Name
						</td>
											
						<td>
							Student Name
						</td>
						<td>
							Class
						</td>
						<td>
							Grade
						</td>
						
						<td>
							&nbsp;
						</td>
					</tr>
				 	<?php 
				 	
				 	function is_iterable($var)
					{
					    return $var !== null 
					        && (is_array($var) 
					            || $var instanceof Traversable 
					            || $var instanceof Iterator 
					            || $var instanceof IteratorAggregate
					            );
					}
				 	
				 	 if(is_iterable($query))
				 	{
				 		foreach($query as $subject)
				 		{?>
						<tr>
							<td>
								<?php echo $subject->subjectcourse_title ?>
							</td>
							<td>
								<?php echo $subject->studentname ?>
							</td>
							<td>
								<?php echo $subject->classtitle ?>
							</td>
							<td>
								<?php echo $subject->grade ?>
							</td>
							
							
							<td>
									
								<a href="edit/<?php echo urlencode($subject->gradeid); ?>"><?php echo $this->lang->line("editoption");?></a>
							</td>
							<td>
								
							</td>
						</tr>
					<?php 
						}
					
						}?>
					</table>
					<a href="add"><?php echo $this->lang->line("add_new_grade");?></a>
        		</div>  			
  				  				
  			</div>
  			
						<?php echo form_close(); ?>
  		</div>
  		
	</body>
</html>