<div class="span9" id="content">
	<div class="row-fluid">
		<?php echo $this->load->view('templates/breadcrumb.php');?>
     	<div class="block">
       		<div class="block-content collapse in">
          		<div class="span12">
          			<?php $this->load->view('shared/display_notification.php');?>
					<h3>People</h3>
					<div class="table-toolbar">
                    	<div class="btn-group">
                    		<a href="/schoolterms/add"><button class="btn btn-success"><?php echo $this->lang->line("add_new_schoolterm");?><i class="icon-plus icon-white"></i></button></a>
                    	</div>
					</div>	
					<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered">
								<thead>
					<tr>
						<th>
							Year
						</th>
						<th>
							Title
						</th>
						<th>
							Start Date
						</th>
						<th>
							End Date
						</th>
						<th>
							Terms
						</th>
						
						
						<th>
							&nbsp;
						</th>
					</tr>
					
					</thead>
					<tbody>
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
				 		foreach($query as $sterm)
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
								<?php echo $sterm->Terms ?>
							</td>
							
							<td>
									
								<a href="/schoolterms/newedit/<?php echo urlencode($sterm->marking_period_id); ?>"><?php echo $this->lang->line("editoption");?></a>
							</td>
							
						</tr>
					<?php 
						}
					
						}?>
						</tbody>
					</table>
					
					</div>
				</div>
			</div>
		</div>
	</div>




<!--div class="span9" id="content">
  
  			<div class="row-fluid">
  				<div class="span4 navleft">
  					<ul class="nav nav-pills nav-stacked">
  						<li ><a href=""><?php echo $this->lang->line("search");?>&nbsp;<i class="icon-search icon-white"></i></a></li>
  						<li class="active"><a href="../schoolterms/listing"><?php echo $this->lang->line("school_terms");?></a></li> 	
  						<li><a href="../gradelevels/listing"><?php echo $this->lang->line("grade_levels");?></a></li>  
  						<li><a href="../schoolclasses/listing"><?php echo $this->lang->line("schoolclasses");?></a></li>
  						<li><a href="../schoolperiods/listing"><?php echo $this->lang->line("school_periods");?></a></li> 	
  						<li><a href="../schoolsubjects/listing"><?php echo $this->lang->line("school_subjects");?></a></li> 			  						
  					</ul>
  					<div class="well">
  						<p><b><?php echo $this->lang->line("help");?></b>&nbsp;<?php echo $this->lang->line("sample_help_message");?></p>
  					</div>
  				</div>
  				
        		<div class="span8">
					<h1><?php echo $this->lang->line("school_terms");?></h1>
					
					<div class="btn-group">
					
                    	</div>
        		</div>  			
  				  				
  			</div>
  		
  		
</div>-->