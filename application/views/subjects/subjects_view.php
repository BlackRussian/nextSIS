<div class="span9">
	<div class="row-fluid">
     	<div class="block">
       		<div class="block-content collapse in">
          		<div class="span12">
          			<?php $this->load->view('shared/display_notification.php');?>
          			<h3><?php echo $this->lang->line("school_subjects");?></h3>
          			<div class="table-toolbar">
                    	<div class="btn-group">
                    		<a href="subjects/add"><button class="btn btn-success"><?php echo $this->lang->line("add_new_schoolsubject");?> <i class="icon-plus icon-white"></i></button></a>
                    	</div>
					</div>					
					<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered">
						<thead>
							<tr>
								<th>Title</th>
								<th>Short Name</th>
								<th colspan="2">&nbsp;</th>
							</tr>
						</thead>
						<tbody>
					 	<?php foreach($query as $subject) { ?>
							<tr>
								<td><?php echo $subject->title ?></td>
								<td><?php echo $subject->short_name ?></td>
								<td><a href='subjects/edit/<?php echo urlencode($subject->subject_id); ?>'><?php echo $this->lang->line("editoption");?></a></td>
								<td><a href='subjects/courses/<?php echo urlencode($subject->subject_id); ?>'>view courses <span class="label label-success"><?php echo $subject->course_count ?></span></a></td>
							</tr>
						<?php } ?>
						<tbody>
					</table>
        		</div>  			
  				  				
  			</div>
  		</div>
	</div>
</div>