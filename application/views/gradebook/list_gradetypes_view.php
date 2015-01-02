<div class="span9">
	<div class="row-fluid">
     	<div class="block">
       		<div class="block-content collapse in">
          		<div class="span12">
          			<?php $this->load->view('shared/display_notification.php');?>
          			<h2><?php echo $page_title;?></h2>  
          			<div class="table-toolbar">
                    	<div class="btn-group">
                    		<a href='/gradebook/addgradetype/<?php echo $course_id;?>'><button class="btn btn-success"><?php echo "Add New Grade Type";?> <i class="icon-plus icon-white"></i></button></a>
                    	</div>
					</div>	     			
					<?php if ($query){?>	
					<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered">
						<thead>
							<tr>
								<th>Title</th>
								<th colspan="2">&nbsp;</th>
							</tr>
						</thead>
						<tbody>
					 	<?php foreach($query as $gradetype) { ?>
							<tr>
								<td><?php echo $gradetype->title ?></td>
								<td><a href='/gradebook/editgradetype/<?php echo $gradetype->grade_type_id; ?>/<?php echo $course_id; ?>'><?php echo "Edit Grade Type";?></a></td>
								<td><a href='/gradebook/add/<?php echo $gradetype->grade_type_id; ?>'><?php echo "Update Student Grades";?></a></td>
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