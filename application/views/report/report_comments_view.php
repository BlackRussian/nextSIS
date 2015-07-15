<div class="span9" id="content">
	<div class="row-fluid">
		<?php echo $this->load->view('templates/breadcrumb.php');?>
     	<div class="block">
       		<div class="block-content collapse in">
          		<div class="span12">
					<?php
	        			$hiddenflds = array('student_id' => $student_id,'class_id' => $class_id,'period' => $period,'teacherid'=>$id);
	        			echo form_open('reports/updatereportcomments', 'method="post" class="form-horizontal"', $hiddenflds);	        			
	        		?>
		                <fieldset>
		                <?php $this->load->view('shared/display_errors');?>
		                <legend><?php echo $page_title;?></legend>  
		                 <div class="control-group">
		                    <label class="control-label" for="Comments"><?php echo $function. "'s Comments";?></label>
		                    <div class="controls">		                    			                    	
		                    	<?php echo form_textarea('Comments', set_value('Comments',$comments));  ?>
		                    	<p class="help-block">Enter Comments here</p>
		                    </div>
		                </div>              
		              	<?php //$this->load->view('shared/display_udf_view');?>
						<div class="form-actions">
	                  		<a href="/reports/student_list/<?php echo $class_id;?>" class="btn"><i class="icon-chevron-left icon-black"></i>Cancel</a>
							          <?php
							          if($function)
									  {
									  	echo form_submit('submit','Submit', 'class="btn btn-primary"'); 
									  }else{
									  		$data = array(
										  	'name' => 'submit',
										  	'id' => 'submit',
										  	'value'=>'Submit',
										  	'class'=>'btn btn-primary',
										  	'style'=>'visibility:hidden'
										  
										  	);
								          	echo form_submit($data);
									  }
							          
									  ?>
							          <?php echo form_close(); ?>
					    </div>
						</fieldset>	
        		</div>  			
  				  				
  			</div>
  		</div>
	</div>
</div>