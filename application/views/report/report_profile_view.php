<div class="span9" id="content">
	<div class="row-fluid">
		<?php echo $this->load->view('templates/breadcrumb.php');?>
     	<div class="block">
       		<div class="block-content collapse in">
          		<div class="span12">
					<?php
	        			$hiddenflds = array('student_id' => $student_id,'class_id' => $class_id,'period' => $period);
	        			echo form_open('reports/editrecord', 'method="post" class="form-horizontal"', $hiddenflds);	        			
	        		?>
		                <fieldset>
		                <?php $this->load->view('shared/display_errors');?>
		                <legend><?php echo $page_title;?></legend>                
		              	<?php $this->load->view('shared/display_udf_view');?>
						<div class="form-actions">
	                  		<a href="/reports/student_list/<?php echo $class_id;?>" class="btn"><i class="icon-chevron-left icon-black"></i>Cancel</a>
							          <?php echo form_submit('submit','Submit', 'class="btn btn-primary"'); ?>
							          <?php echo form_close(); ?>
					    </div>
						</fieldset>	
        		</div>  			
  				  				
  			</div>
  		</div>
	</div>
</div>