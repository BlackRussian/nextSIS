<div class="span9" id="content">
	<div class="row-fluid">
		<?php echo $this->load->view('templates/breadcrumb.php');?>
     	<div class="block">
       		<div class="block-content collapse in">
          		<div class="span12">
          			<?php $this->load->view('shared/display_notification.php');?>
					<h3>School Semesters/Terms for - <?php echo $syeartitle; ?></h3>
					<div class="table-toolbar">
                    	<div class="btn-group">
                    		<a href="/schoolsemester/add/<?php echo $yearid;?>"><button class="btn btn-success">Add Semester <i class="icon-plus icon-white"></i></button></a>
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
									
								<a href="/schoolsemester/edit/<?php echo urlencode($sterm->marking_period_id); ?>"><?php echo $this->lang->line("editoption");?></a>
							</td>
							<td>
								<a href="/schoolquarter/<?php echo urlencode($sterm->marking_period_id); ?>"><?php echo "Manage Quarters";?></a>
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
	