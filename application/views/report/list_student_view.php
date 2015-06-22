<script type="text/javascript">
	function updateProfile(id){
		var period = $('#sel_marking_period').val();
		var class_id =   $("input[name='class_id']").val();
		var url = "/reports/report_profile/" + id + "/" + period + "/" + class_id;

		window.location.href = url;
   		return false;
	}
	function updateProfileComments(id){
		var period = $('#sel_marking_period').val();
		var class_id =   $("input[name='class_id']").val();
		var url = "/reports/report_comments/" + id + "/" + period + "/" + class_id;

		window.location.href = url;
   		return false;
	}

</script>
<div class="span9" id="content">
	<div class="row-fluid">
		<?php echo $this->load->view('templates/breadcrumb.php');?>
     	<div class="block">
       		<div class="block-content collapse in">
          		<div class="span12">
          			<?php $this->load->view('shared/display_notification.php');?>
          			<h2><?php echo $page_title;?></h2>  

          			<?php echo form_hidden('class_id', $class_id);?>
          			<div class="control-group">
	                    <label class="control-label" for="sel_marking_period"><?php echo "Marking Period";?></label>
	                    <div class="controls">		                    	
	                    	<?php echo form_dropdown('sel_marking_period', $periods,set_value('sel_marking_period', ''),'id="sel_marking_period"'); ?>
	                    </div>
	                </div>     			
					<?php if ($query){?>	
					<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered">
						<thead>
							<tr>
								<th>Student Name</th>
								<th >&nbsp;</th>
							</tr>
						</thead>
						<tbody>
					 	<?php foreach($query as $student) { ?>
							<tr>
								<td><?php echo $student->name ?>
								<?php //echo var_dump($student)?></td>								
								<?php if($fteacher) { ?><td><a style="cursor:pointer;" onclick="updateProfile('<?php echo $student->person_id; ?>')"><?php echo "Update Report Profile";?></a><?php } ?> </td>
								<?php	if($function){ ?>  <td>
								<a style="cursor:pointer;" onclick="updateProfileComments('<?php echo $student->person_id; ?>')"><?php echo "Update Report Comments";?></a>	</td><?php }?>
									
									
									
								</td>
							</tr>
						<?php } ?>
						<tbody>
					</table>
					<?php } ?>	
        		</div>  			
  				  				
  			</div>
  		</div>
	</div>
</div>