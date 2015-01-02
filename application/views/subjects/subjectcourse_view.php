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
					<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="myTable">
						<thead>
							<tr>
								<th>Title</th>
								<th>Short Name</th>
								<th>Grade Level</th>
								<th></th>
							</tr>
						</thead>
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
        				{"data":"subject_title"},
        				{"data":"short_name"},
        				{"data":"grade_title"},
        				{	"data":"edit",
        					"sortable":false,
        					"searchable":false
        				}
        	]
		} );
	} );
</script>