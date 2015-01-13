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
                    		<a href="/person/add/<?php echo $filter ?>"><button class="btn btn-success">Add New Person <i class="icon-plus icon-white"></i></button></a>
                    	</div>
					</div>	
						<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered">
							<thead>
								<tr>
									<th>First Name</th>
									<th>Middle Name</th>
									<th>Surname</th>
									<th>Role(s)</th>
								</tr>
							</thead>
							<tbody>
							 	<?php if($query){  foreach($query as $person){?>
									<tr>
										<td><?php echo $person->first_name ?></td>
										<td><?php echo $person->surname ?></td>
										<td><?php echo $person->username ?></td>
										<td><?php echo $person->roles ?></td>
										<td>
											<a href="/person/edit/<?php echo urlencode($person->id); ?>"><?php echo $this->lang->line("edit_person");?></a>
											
										</td>
										
										<?php if($filter && $filter=="3")
												{
													
													echo "<td>
													<a href='/person/assignclass/" .  urlencode($person->id) . "';>Assign Class</a>										
													</td>";
												}?>
									</tr>
								<?php }}?>
							</tbody>
						</table>
        		</div>  			
  			</div>			
		</div>
	</div>
</div>