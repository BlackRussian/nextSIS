<div class="span9" id="content">
	<div class="row-fluid">
		<?php echo $this->load->view('templates/breadcrumb.php');?>
     	<div class="block">
       		<div class="block-content collapse in">
          		<div class="span12">
          			<?php $this->load->view('shared/display_notification.php');?>
          			<h2><?php echo 'Manage Grades';?></h2>       			
					<?php if ($query){?>	
					<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered">
						<thead>
							<tr>
								<th>Grade Level</th>
								<th>Course Name</th>
								<th>Teacher Name</th>
								<th>&nbsp;</th>
							</tr>
						</thead>
						<tbody>
					 	<?php foreach($query as $course) { ?>
							<tr>
								<td><?php echo $course->grade_level ?></td>
								<td><?php echo $course->title . " - ".$course->short_name?></td>
								<td><?php echo $course->label . ' ' . $course->first_name . ' ' . $course->surname?></td>
								<td><a href='gradebook/gradetypelist/<?php echo urlencode($course->term_course_id); ?>'><?php echo $this->lang->line("editoption");?></a></td>
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