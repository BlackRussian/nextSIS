<div class="span9">
	<div class="row-fluid">
     	<div class="block">
       		<div class="block-content collapse in">
          		<div class="span12">
          			<?php $this->load->view('shared/display_notification.php');?>
          			<h2><?php echo $page_title;?></h2>
          			<div class="table-toolbar">
                    	<div class="btn-group">
                    		<a href="/courses/add/<?php echo $subject_id;?>"><button class="btn btn-success">Add New Course <i class="icon-plus icon-white"></i></button></a>
                    	</div>
					</div>					
					<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered">
						<thead>
							<tr>
								<th>Title</th>
								<th>Short Name</th>
								<th>Grade Level</th>
								<th colspan="2">&nbsp;</th>
							</tr>
						</thead>
						<tbody>
					 	<?php foreach($query as $course) { ?>
							<tr>
								<td><?php echo $course->subject_title ?></td>
								<td><?php echo $course->short_name ?></td>
								<td><?php echo $course->grade_title ?></td>
								<td><a href='/courses/edit/<?php echo urlencode($course->course_id); ?>'><?php echo $this->lang->line("editoption");?></a></td>
								<td><a href='/courses/details/<?php echo urlencode($course->course_id); ?>'>view details</a></td>
							</tr>
						<?php } ?>
						<tbody>
					</table>
        		</div>  			
  				  				
  			</div>
  		</div>
	</div>
</div>