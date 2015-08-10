
  		
  	<div class="span9" id="content">
  		<div class="row-fluid">
  		<?php echo $this->load->view('templates/breadcrumb.php');?>
  		<div class="block">
       		<div class="block-content collapse in">
          		<div class="span12">
          			<?php $this->load->view('shared/display_notification.php');?>
					<h3>School Periods/Terms for - <?php echo $currentsyear; ?></h3>
					<div class="table-toolbar">
                    	<div class="btn-group">
                    		<a href="/schoolperiods/add"><button class="btn btn-success">Add Period <i class="icon-plus icon-white"></i></button></a>
                    	</div>
					</div>
					<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered">
					<thead>
						<tr>
						<th>
							Title
						</th>
						<th>
							Start Time
						</th>
						<th>
							End Time
						</th>
						<th>
							Length
							(minutes)
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
				 		foreach($query as $periods)
				 		{?>
						<tr>
							<td>
								<?php echo $periods->title ?>
							</td>
							<td>
								<?php echo $periods->start_time ?>
							</td>
							<td>
								<?php echo $periods->end_time ?>
							</td>
							<td>
								<?php $duration=0;
								$duration =   $periods->end_time - $periods->start_time;
								echo $periods->length; ?>
							</td>
							<td>
									
								<a href="/schoolperiods/edit/<?php echo urlencode($periods->period_id); ?>"><?php echo $this->lang->line("editoption");?></a>
							</td>
							<td>
								
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
  				
  				
  						
  		