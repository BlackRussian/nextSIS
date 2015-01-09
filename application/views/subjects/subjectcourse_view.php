<div class="span9" id="content">
	<div class="row-fluid">
      <?php echo $this->load->view('templates/breadcrumb.php');?>
     	<div class="block">
       		<div class="block-content collapse in">
          		<div class="span12">
          			<?php $this->load->view('shared/display_notification.php');?>
                <h3><?php echo $page_title;?></h3>
          			<div class="table-toolbar">
                    	<div class="btn-group">
                    		<a href="/courses/add/<?php echo $subject_id;?>"><button class="btn btn-success">Add New Course <i class="icon-plus icon-white"></i></button></a>
                    	</div>
					</div>					
					<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="myTable">
						<thead>
							<tr>
								<th>Title</th>
								<th>Short Name</th>
								<th>Grade Level</th>
								<th></th>
                <th style="border-left:0px"></th>
							</tr>
						</thead>
            <tbody>
                <?php
                if($query){
                    foreach($query as $course) { ?>
                      <tr>
                        <td><?php echo $course->course_title;?></td>
                        <td><?php echo $course->short_name;?></td>
                        <td><?php echo $course->grade_title;?></td>
                        <td><a href="/courses/edit/<?php echo $course->course_id;?>">edit</a></td>
                        <td><a href="/courses/<?php echo $course->course_id;?>">view teacher(s)</a></td>
                      </tr>
                <?php } }?>
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
        	"ajax": {"url":"<?php echo base_url(); ?>ajaxcallbacks/getSubjectCourses","type":"POST", "data":{"subject_id":"<?php echo $subject_id?>", "school_id":"1"}},
        	"columns":[
        				{"data":"course_title"},
        				{"data":"short_name"},
        				{"data":"grade_title"},
        				{	"data":"edit",
        					"sortable":false,
        					"searchable":false
        				},
                { "data":"assign",
                  "sortable":false,
                  "searchable":false
                }
        	]
		} );
	} );
</script>