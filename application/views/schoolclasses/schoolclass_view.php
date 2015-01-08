<div class="span9" id="content">
	<div class="row-fluid">
		<?php echo $this->load->view('templates/breadcrumb.php');?>
     	<div class="block">
       		<div class="block-content collapse in">
          		<div class="span12">
          			<?php $this->load->view('shared/display_notification.php');?>
					<h3>Manage Classes</h3>
					<div class="table-toolbar">
                    	<div class="btn-group">
                    		<a href="/schoolclasses/add"><button class="btn btn-success">Add New Class <i class="icon-plus icon-white"></i></button></a>
                    	</div>
					</div>
					<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered">
						<thead>
							<tr>
								<th>Grade Level</th>
								<th>Class</th>
								<th>&nbsp;</th>
							</tr>
						</thead>
					 	<?php if($query){  foreach($query as $class){ ?>
							<tr>
								<td>
									<?php echo $class->grade_title; ?>
								</td>
								<td>
									<?php echo $class->class_title; ?>
								</td>
								<td><a href="/schoolclasses/edit/<?php echo urlencode($class->id); ?>">edit</a></td>
							</tr>
						<?php }}?>
					</table>
					<a href="add"><?php echo $this->lang->line("add_new_schoolclass");?></a>
        		</div>  						
  			</div>
  		</div>
  	</div>
</div>