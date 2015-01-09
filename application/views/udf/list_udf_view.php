<div class="span9" id="content">
	<div class="row-fluid">
     	<div class="block">
       		<div class="block-content collapse in">
          		<div class="span12">
          			<?php $this->load->view('shared/display_notification.php');?>
          			<h2><?php echo 'User Defined Fields';?></h2>     
          			<div class="table-toolbar">
                    	<div class="btn-group">
                    		<a href='/udf/add'><button class="btn btn-success"><?php echo "Add New User Defined Field";?> <i class="icon-plus icon-white"></i></button></a>
                    	</div>
					</div>	  			
					<?php 
					
					if ($query){?>	
					<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered">
						<thead>
							<tr>
								<th>Category</th>
								<th>Title</th>
								<th>Descrption</th>
								<th>Type</th>
								<th>Hidden</th>
								<th>&nbsp;</th>
							</tr>
						</thead>
						<tbody>
					 	<?php foreach($query as $udf) { ?>
							<tr>
								<td><?php echo $udf->category ?></td>
								<td><?php echo $udf->title ?></td>
								<td><?php echo $udf->description ?></td>
								<td><?php echo $udf->type ?></td>
								<td><?php echo $udf->hide == 1? "Yes":"No"; ?></td>
								<td><a href='udf/edit/<?php echo urlencode($udf->udf_id); ?>'><?php echo $this->lang->line("editoption");?></a></td>
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