<div class="span9" id="content">
	<div class="row-fluid">
		<?php echo $this->load->view('templates/breadcrumb.php');?>
     	<div class="block">
       		<div class="block-content collapse in">
          		<div class="span12">
          			<?php $this->load->view('shared/display_notification.php');?>
					<h3>Manage Grade Levels</h3>
					<div class="table-toolbar">
                    	<div class="btn-group">
                    		<a href="gradelevels/add"><button class="btn btn-success">Add New Grade Level <i class="icon-plus icon-white"></i></button></a>
                    	</div>
					</div>
					<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered">
						<thead>
							<tr>
								<th>Grade Level</th>
								<th>Next Grade Level</th>
								<th>&nbsp;</th>
								<th>&nbsp;</th>
							</tr>
						</thead>
				 		<?php foreach($query as $gradelevel){ ?>
						<tr>
							<td><?php echo $gradelevel->grade_title ?></td>
							<td><?php echo $gradelevel->next_title ?></td>
							<td><a href="/gradelevels/edit/<?php echo urlencode($gradelevel->id); ?>">edit</a></td>
							<td><a href="/schoolclasses/<?php echo urlencode($gradelevel->id); ?>">view class</a></td>
						</tr>
						<?php }?>
					</table>
					<a href="add"><?php echo $this->lang->line("add_new_gradelevel");?></a>
        		</div>				
  			</div>
  		</div>
	</div>
</div>