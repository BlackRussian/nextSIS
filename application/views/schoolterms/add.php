		<script type="text/javascript">
			function submitform(val1)
			{
			  //$("#hx").val(val);
			// var val = parseInt($('#activeindex').val())- 1;
			  alert($("#activeindex").val());
			  switch(val) {
				    case 0:
				        //alert("im here" + val);
			  			//document.forms["addsyear"].submit();
				        break;
				    case 1:
				        alert("im here 5" + val);
				        break;
				    default:
				        alert("im here 2");
				        break;
				}
			 
			}
			$(document).ready(function() { 
				
				$("#AddTerm").click(function(){
					document.forms["addterm"].submit();
				});
				$("#AddQuarter").click(function(){
					document.forms["addprecord"].submit();
				});
				$("#AddYear").click(function(){
					document.forms["addsyear"].submit();
				});
				 
			     $("#startdate").datepicker({
			     	dateFormat:"dd M yy"
			     }      	
			     );

			     $("#enddate").datepicker({
			     	dateFormat:"dd M yy"
			     });

			     $("#syearstartdate").datepicker({
			     	dateFormat:"dd M yy"
			     });

			     $("#syearenddate").datepicker({
			     	dateFormat:"dd M yy"
			     });
			     
			      $("#pstartdate").datepicker({
			     	dateFormat:"dd M yy"
			     });

			     $("#penddate").datepicker({
			     	dateFormat:"dd M yy"
			     });

			    $(".datepicker").datepicker();

				
			    $('#rootwizard').bootstrapWizard({onNext: function(tab, navigation, index) {
						var val = parseInt($('#activeindex').val());
			  //alert($("#activeindex").val());
			  switch(val) {
				    case 0:
				        //alert("im here" + val);
			  			//document.forms["addsyear"].submit();
				        break;
				    case 1:
				       // alert("im here 5" + val);
				       // var val = parseInt($('#activeindex').val())- 1;
				        break;
				    default:
				        alert("im here 2");
				        break;
				}
			
		},onTabShow: function(tab, navigation, index) {
			    	//alert("system index is " + index);
			    	
			    	//alert("active index is " + $("#activeindex").val());
			    	var $total = navigation.find('li').length;
			        
			    	var $current = $current = index+1;
			        
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
			    //if($("#activeindex").val()!="" && $("#newwizard").val()!="no")
			    //{
			    	//alert("im in next");
			    	$('#rootwizard').bootstrapWizard('show',parseInt($("#activeindex").val()));
			    //}
			});
			
			
		</script>
		       
       <div class="span9">
		  <div class="row-fluid section">
		     <div class="block">
		     	
		        <div class="block-content collapse in">
		          <div class="span12">
		    	    
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
                                            	if (!function_exists('is_iterable')) {
	                                            	function is_iterable($var)
													{
													    return $var !== null 
													        && (is_array($var) 
													            || $var instanceof Traversable 
													            || $var instanceof Iterator 
													            || $var instanceof IteratorAggregate
													            );
													}
												}
                                            	
                                            	
                                            	
                                            	$attributes = array('class' => 'form-horizontal', 'id' => 'addsyear' ,'name' => 'addsyear');
                                            	echo form_open('schoolterms/addsyearrecord',$attributes);
                                            	echo form_hidden('addsyear_schoolid',$currentschoolid);
												echo form_hidden('isyedit',$isyedit);
												
												$val="";
												if(isset($activeindex))
												{
													$val = $activeindex;
												}
												
												echo "<input class='input-xlarge focused' type='hidden' id='activeindex' name='activeindex' value='". $val . "' />";
												$val="";
												if(isset($newwizard))
												{
													$val = $newwizard;
												}
												echo "<input class='input-xlarge focused' type='hidden' id='newwizard' name='newwizard' value='". $val . "' />";
							
																							
												if(isset($syear_markingperiodid))
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
                                            	<h1>School Year</h1>
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
														<select style="width:70px" id="syear_newyear" name="syear_newyear">
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
															if($syear == $value){$selected = 'selected';}
																
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
							<div class="btn-group">
                    		<a href="#" id="AddYear"><button class="btn btn-success">Submit Year <i class="icon-plus icon-white"></i></button></a>
                    	
                    	</div>
						</td>
					</tr>
												<tr>
													<td colspan="2">
													<?php 
															//echo form_submit('submit','submit'); 
															?>
													<?php echo form_close(); ?>
														
														
													</td>
												</tr>
												</table>
                                            	
                                              
                                            </div>
                                            <div class="tab-pane" id="tab2">
                                               <!--<div class="span8">-->
        		<?php 
        		
        		$attributes = array('class' => 'form-horizontal', 'id' => 'addterm' ,'name' => 'addterm');
        		echo form_open('schoolterms/addrecord', $attributes);
				
				if(isset($activeindex))
												{
													$val = $activeindex;
												}
												
												echo "<input class='input-xlarge focused' type='hidden' id='activeindex' name='activeindex' value='". $val . "' />";
												$val="";
												if(isset($newwizard))
												{
													$val = $newwizard;
												}
												echo "<input class='input-xlarge focused' type='hidden' id='newwizard' name='newwizard' value='". $val . "' />";
							
				
				
				
				 ?>
					<h1>Add School Term</h1>
					<p class="text-error"><?php echo validation_errors();?></p>
					
					<table>
					
					<?php echo "<input type='hidden' id='school_id' name='school_id' value='" .$currentschoolid ."'  />"?>
					<?php
					$val="";
					if(isset($syear_markingperiodid))
												{
													$val = $syear_markingperiodid;
												}
					
					 echo "<input type='hidden' id='syear_markingperiodid' name='syear_markingperiodid' value='" .$val ."'  />"?>
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
							<div class="btn-group">
                    		<a href="#" id="AddTerm"><button class="btn btn-success">Add New Term <i class="icon-plus icon-white"></i></button></a>
                    	</div>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered">
								<thead>
								<tr>
									<th>Year</th>
									<th>Title</th>
									<th>Start Date</th>
									<th>End Date</th>
									<th></th>
								</tr>
							</thead>
					<tbody>
				 	<?php 
				 	
				 	
				 	if(isset($stquery))
					{
				 	 if(is_iterable($stquery))
				 	{
				 		foreach($stquery as $sterm)
				 		{?>
						<tr>
							<td>
								<?php echo $sterm->syear ?>
							</td>
							<td>
								<?php echo $sterm->title ?>
							</td>
							<td>
								<?php echo $sterm->start_date ?>
							</td>
							<td>
								<?php echo $sterm->end_date ?>
							</td>
							
							<td>
									
								<a href="edit/<?php echo urlencode($sterm->marking_period_id); ?>"><?php echo $this->lang->line("editoption");?></a>
							</td>
							
						</tr>
					<?php 
						}
						
					}
					
						}?>
						</tbody>
					</table>
						</td>
					</tr>
					
					<tr>
						<td colspan="2">
						<?php //echo form_submit('submit','submit');
						 ?>
						<?php echo form_close(); ?>
							
							
						</td>
					</tr>
					
					</table>
        	<!--</div>-->			
  				
                                            </div>
                                            <div class="tab-pane" id="tab3">
                                               <?php 
        		
        		$attributes1 = array('class' => 'form-horizontal', 'id' => 'addquarter' ,'name' => 'addquarter');
        		echo form_open('schoolterms/addprecord', $attributes1);
				
				if(isset($activeindex))
												{
													$val = $activeindex;
												}
												
												echo "<input class='input-xlarge focused' type='hidden' id='activeindex' name='activeindex' value='". $val . "' />";
												$val="";
												if(isset($newwizard))
												{
													$val = $newwizard;
												}
												echo "<input class='input-xlarge focused' type='hidden' id='newwizard' name='newwizard' value='". $val . "' />";
							
				
				
				
				 ?>
					<h1>Add Term Quarter</h1>
					<p class="text-error"><?php echo validation_errors();?></p>
					
					<table>
					
					<?php echo "<input type='hidden' id='school_id' name='school_id' value='" .$currentschoolid ."'  />"?>
					<?php echo "<input type='hidden' id='syear_markingperiodid' name='syear_markingperiodid' value='" .$syear_markingperiodid ."'  />"?>
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
							echo "<input type='text' id='ptitle' name='ptitle' value='". $val . "' />"?>
							</td>
					</tr>
					<tr>
						
						<td>
							Term
						</td>
						<td>
							<?php echo form_dropdown('DDL_Terms', $stermsddl,'','class="required" id="Gender"');  ?>
						
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
							echo "<input type='text' id='pstartdate' name='pstartdate' value='". $val . "'  />"?>
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
							echo "<input type='text' id='penddate' name='penddate' value='". $val . "'  />"?>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<div class="btn-group">
                    		<a href="#" id="AddQuarter"><button class="btn btn-success">Add New Quarter <i class="icon-plus icon-white"></i></button></a>
                    	</div>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered">
								<thead>
					<tr>
						<th>Year</th>
						<th>
							Term
						</th>
						<th>
							Quarter
						</th>
						
						<th>
							Start Date
						</th>
						<th>
							End Date
						</th>
						
						<th>
							&nbsp;
						</th>
					</tr>
					</thead>
					<tbody>
				 	<?php 
				 	 if(is_iterable($sqquery))
				 	{
				 		foreach($sqquery as $squart)
				 		{?>
						<tr>
							<td>
								<?php echo $squart->SchoolYearTitle ?>
							</td>
							<td>
								<?php echo $squart->TermTitle ?>
							</td>
							<td>
								<?php echo $squart->title ?>
							</td>
							<td>
								<?php echo $squart->start_date ?>
							</td>
							<td>
								<?php echo $squart->end_date ?>
							</td>
							
							<td>
									
								<a href="edit/<?php echo urlencode($squart->marking_period_id); ?>"><?php echo $this->lang->line("editoption");?></a>
							</td>
							<td>
								
							</td>
						</tr>
					<?php 
						}
					
						}?>
						</tbody>
					</table>
						</td>
					</tr>
					
					<tr>
						<td colspan="2">
						<?php //echo form_submit('submit','submit'); 
						?>
						<?php echo form_close(); ?>
							
							
						</td>
					</tr>
					
					</table>
                                            </div>
                                            <ul class="pager wizard">
                                                <li class="previous first" style="display:none;"><a href="javascript:void(0);">First</a></li>
                                                <li class="previous"><a href="javascript:void(0);">Previous</a></li>
                                                <li class="next last" style="display:none;"><a href="javascript:void(0);">Last</a></li>
                                                <li class="next"><a id="linksubmit" href="javascript:void(0);">Next</a></li>
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
  		
  		