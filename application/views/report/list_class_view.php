<div class="span9" id="content">
	<div class="row-fluid">
		<?php echo $this->load->view('templates/breadcrumb.php');?>
     	<div class="block">
       		<div class="block-content collapse in">
          		<div class="span12">
          			<?php $this->load->view('shared/display_notification.php');?>
          			<h2><?php echo 'Manage Report Profile';?></h2>       			
					<?php 
					//echo $this->db->last_query();
					//echo var_dump($query);
					if ($query){?>	
					<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered">
						<thead>
							<tr>
								<th>Teacher(s)</th>
								<th>Class</th>	
								<th>&nbsp;</th>
							</tr>
						</thead>
						<tbody>
					 	<?php foreach($query as $info) { ?>
							<tr>
								<td><?php echo $info->name ?></td>								
								<td><?php echo $info->class?></td>
								<td><a href='/reports/student_list/<?php echo urlencode($info->id); ?>'><?php echo "View Students";?></a></td>
							</tr>
						<?php } ?>
						<tbody>
					</table>
					<?php }?>	
        		</div>  			
  				  				
  			</div>
  		</div>
	</div>
</div>