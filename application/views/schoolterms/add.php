
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
                $(document).ready(function(){
                     $("#syearstartdate").datepicker({
                     	dateFormat:"yy-MM-dd"
                     });
               });
                $(document).ready(function(){
                     $("#syearenddate").datepicker({
                     	dateFormat:"yy-MM-dd"
                     });
               });
       </script>
       
       <div class="span9">
		  <div class="row-fluid section">
		     <div class="block">
		     	 <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">Form Wizard</div>
                            </div>
		        <div class="block-content collapse in">
		          <div class="span12">
		    	     <h1><?php echo $this->lang->line("courses");?></h1>
		    	     <!-- Wizard Start-->
		    	     
		    	     <div id="rootwizard">
                                        <div class="navbar">
                                          <div class="navbar-inner">
                                            <div class="container">
                                        <ul >
                                            <li><a href="#tab1" data-toggle="tab">Step 1</a></li>
                                            <li ><a href="#tab2" data-toggle="tab">Step 2</a></li>
                                            <li><a href="#tab3" data-toggle="tab">Step 3</a></li>
                                        </ul>
                                         </div>
                                          </div>
                                        </div>
                                        <div id="bar" class="progress progress-striped active">
                                          <div class="bar"></div>
                                        </div>
                                        <div class="tab-content">
                                            <div class="tab-pane" id="tab1">
                                            	<?php 
                                            	$attributes = array('class' => 'form-horizontal', 'id' => 'addsyear');
                                            	echo form_open('schoolterms/addsyearrecord',$attributes);
                                            	echo form_hidden('addsyear_schoolid',$currentschoolid);
												$val="";
												if(isset($syeartitle))
												{
													$val = $syear_markingperiodid;
												}
												echo form_hidden('syear_markingperiodid',$val);
												echo form_hidden('syear_isnew','true');
                                            	
                                            	?>
                                            	<?php //echo "<input type='hidden' id='addsyear_schoolid' name='addsyear_schoolid' value='" .$currentschoolid ."'  />"
                                            	?>
                                            	<?php //echo "<input type='hidden' id='syear_markingperiodid' name='syear_markingperiodid' value='" .$syear_markingperiodid ."'  />"
                                            	?>
                                            	<h1>Add School Year</h1>
                                            	<p class="text-error"><?php echo validation_errors();?></p>
												<table>
													<tr>
														<td>
														 Title
													</td>
													<td>
														<?php 
														$val="";
														if(isset($syeartitle))
														{
															$val = $syeartitle;
														}
														echo "<input class='input-xlarge focused' type='text' id='syeartitle' name='syeartitle' value='". $val . "' />"?>
														</td>
													</tr>
													<tr>
														<td>
														 Short Name
													</td>
													<td>
														<?php 
														$val="";
														if(isset($syearsname))
														{
															$val = $syearsname;
														}
														echo "<input class='input-xlarge focused' type='text' id='syearsname' name='syearsname' value='". $val . "' />"?>
														</td>
													</tr>
													<tr>
														<td>
															Year
														</td>
														<td>
														<select style="width:70px" id="start_time_hr" name="start_time_hr">
														<?php 
														$years = explode(",", $years);
														
														echo"<option value='0' selected>n/a</option>";
														 foreach($years as $year){ 
															$selected = False;
															//if($time[0] == $hr)
															//{
															//$selected = selected;
														//	}
															$value= $year;
															$text = $year;
															//if($titleid == $value){$selected = 'selected';}
																
															echo '<option value="'. $value .'" '.$selected.'>'. $text . '</option>';
															
														}?>
														
														</select>
														
														</td>
													</tr>
													<tr>
													<td>
														Start Date
													</td>
													<td>
														<?php 
														
														
														
														$val="";
														if(isset($syearstartdate))
														{
															$val = $syearstartdate;
														}
														$js = array('name' => 'syearstartdate','value'=>$val, 'id' => 'syearstartdate');
														//echo form_input('syearstartdate',$val,$js);
														echo form_input($js);
														
														//echo "<input class='input-xlarge focused' type='text' id='syearstartdate' name='syearstartdate' value='". $val . "'  />"?>
												</tr>
												<tr>
													<td>End Date</td>
													<td>
													<?php 
														
														$val="";
														if(isset($syearenddate))
														{
															$val = $syearenddate;
														}
														
													
														$js = array('name' => 'syearenddate','value'=>$val, 'id' => 'syearenddate','class'=>'input-xlarge focused');
														//echo "<input class=''  type='text' id='syearenddate' name='syearenddate' value='". $val . "'  />"
														echo form_input($js);
														?>
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
                                            <div class="tab-pane" id="tab2">
                                               <!--<div class="span8">-->
        		<?php echo form_open('schoolterms/addrecord'); ?>
					<h1>Add School Term</h1>
					<p class="text-error"><?php echo validation_errors();?></p>
					<table>
					
					<?php echo "<input type='hidden' id='school_id' name='school_id' value='" .$currentschoolid ."'  />"?>
					<?php echo "<input type='hidden' id='syear' name='syear' value='" .$currentsyear ."'  />"?>
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
							</td>
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
        	<!--</div>-->			
  				
                                            </div>
                                            <div class="tab-pane" id="tab3">
                                                <form class="form-horizontal">
                                                  <fieldset>
                                                    <div class="control-group">
                                                      <label class="control-label" for="focusedInput">Company Name</label>
                                                      <div class="controls">
                                                        <input class="input-xlarge focused" id="focusedInput" type="text" value="">
                                                      </div>
                                                    </div>
                                                    <div class="control-group">
                                                      <label class="control-label" for="focusedInput">Contact Name</label>
                                                      <div class="controls">
                                                        <input class="input-xlarge focused" id="focusedInput" type="text" value="">
                                                      </div>
                                                    </div>
                                                    <div class="control-group">
                                                      <label class="control-label" for="focusedInput">Contact Phone</label>
                                                      <div class="controls">
                                                        <input class="input-xlarge focused" id="focusedInput" type="text" value="">
                                                      </div>
                                                    </div>
                                                  </fieldset>
                                                </form>
                                            </div>
                                            <ul class="pager wizard">
                                                <li class="previous first" style="display:none;"><a href="javascript:void(0);">First</a></li>
                                                <li class="previous"><a href="javascript:void(0);">Previous</a></li>
                                                <li class="next last" style="display:none;"><a href="javascript:void(0);">Last</a></li>
                                                <li class="next"><a href="javascript:void(0);">Next</a></li>
                                                <li class="next finish" style="display:none;"><a href="javascript:;">Finish</a></li>
                                            </ul>
                                        </div>  
                                    </div>
		    	     
		    	     
		    	     
		    	     
		    	     <!--Wizard end-->
		    	  </div>  			
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
  				
        		  				
  			</div>
  		</div>
  		
  		
  		 <script>

	
	

        $(function() {
           //$(".datepicker").datepicker();
           // $(".uniform_on").uniform();
           //$(".chzn-select").chosen();
           //$('.textarea').wysihtml5();

            $('#rootwizard').bootstrapWizard({onTabShow: function(tab, navigation, index) {
                var $total = navigation.find('li').length;
                var $current = index+1;
                var $percent = ($current/$total) * 100;
                $('#rootwizard').find('.bar').css({width:$percent+'%'});
                // If it's the last tab then hide the last button and show the finish instead
                if($current >= $total) {
                    $('#rootwizard').find('.pager .next').hide();
                    $('#rootwizard').find('.pager .finish').show();
                    $('#rootwizard').find('.pager .finish').removeClass('disabled');
                } else {
                    $('#rootwizard').find('.pager .next').show();
                    $('#rootwizard').find('.pager .finish').hide();
                }
            }});
            $('#rootwizard .finish').click(function() {
                alert('Finished!, Starting over!');
                $('#rootwizard').find("a[href*='tab1']").trigger('click');
            });
        });
        </script>
	</body>
</html>