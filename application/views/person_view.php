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
                    		<a href="/person/add<?php if($filter){echo '/'.$filter;} ?>"><button class="btn btn-success">Add New Person <i class="icon-plus icon-white"></i></button></a>
                    	</div>
					</div>	
						<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered"  id="myTable">
							<thead>
								<tr>
									<th>First Name</th>
									<th>Middle Name</th>
									<th>Surname</th>
									<th>Called/Alias</th>
									<th>Login name</th>
									<th>Role(s)</th>
									<th></th>
									<?php if($filter && ($filter=="3" || $filter=="2"))
												{
													echo '<th style="border-left:0px"></th>';
												}
												if($filter && $filter=="3"){
													echo '<th style="border-left:0px"></th>';
												}
										?>
								</tr>
							</thead>
							<tbody>
							 	<?php if($query){  foreach($query as $person){?>
									<tr>
										<td><?php echo $person->first_name ?></td>
										<td><?php echo $person->middle_name ?></td>
										<td><?php echo $person->surname ?></td>
										<td><?php echo $person->common_name ?></td>
										<td><?php echo $person->username ?></td>
										<td><?php echo $person->roles ?></td>
										<td>
											<a href="/person/edit/<?php echo urlencode($person->id); if($filter){echo '/'.$filter;} ?>">edit</a>
											
										</td>
										
										<?php if($filter && ($filter=="3" || $filter=="2"))
												{
													
													echo "<td>
													<a href='/person/assignclass/" .  urlencode($person->id) . "/".urlencode($filter)."';>assign class</a>										
													</td>";
												}
												if($filter && $filter=="3"){
													echo "<td>
													<a href='/person/assigncourses/" .  urlencode($person->id) . "/".urlencode($filter)."';>assign courses</a>										
													</td>";
												}
										?>
									</tr>
								<?php }}?>
							</tbody>
						</table>
        		</div>  			
  			</div>			
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		$('#myTable').dataTable( {
			"processing": true,
        	"serverSide": true,
        	"ajax": {"url":"<?php echo base_url(); ?>ajaxcallbacks/getPersonsBySchool","type":"POST", "data":{"school_id":"<?php echo $school_id?>", "role_id":"<?php echo $filter?>"}},
        	"columns":[
        				{"data":"first_name"},
        				{"data":"middle_name"},
        				{"data":"surname"},
        				{"data":"common_name"},
        				{"data":"username"},
        				{"data":"roles", "sortable":false, "searchable":false},
        				{"data":"edit","sortable":false, "searchable":false}
        				<?php if($filter && ($filter=="3" || $filter=="2"))
        				{
							echo ',{"data":"assign", "sortable":false, "searchable":false}';
						}
						if($filter && $filter=="3"){
							echo ',{"data":"courses", "sortable":false, "searchable":false}';
						}
				?>
        	]
		} );
	} );
</script>