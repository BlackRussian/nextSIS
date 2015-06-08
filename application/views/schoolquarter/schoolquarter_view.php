<div class="span9" id="content">
	<div class="row-fluid">
		<?php echo $this->load->view('templates/breadcrumb.php');?>
     	<div class="block">
       		<div class="block-content collapse in">
          		<div class="span12">
          			<?php $this->load->view('shared/display_notification.php');?>
					<h3>Manage School Years</h3>
					<div class="table-toolbar">
                    	<div class="btn-group">
                    		<a href="/schoolquarter/add/<?php echo $semesterid ?>"><button class="btn btn-success">Add Quarter <i class="icon-plus icon-white"></i></button></a>
                    	</div>
					</div>
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
				 		foreach($query as $squart)
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
									
								<a href="/schoolquarter/edit/<?php echo urlencode($squart->marking_period_id); ?>"><?php echo $this->lang->line("editoption");?></a>
							</td>
							
							
							
							
						</tr>
					<?php 
						}
					
						}?>
						</tbody>
					</table>
					<a href="add"><?php echo $this->lang->line("add_new_gradelevel");?></a>
        		</div>				
  			</div>
  		</div>
	</div>
</div>