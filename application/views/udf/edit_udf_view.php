<script type="text/javascript">
	$(document).ready(function() {
	     
	     if ($('#sel_type').val() != "select")
	     	$('#txt_selectoptions').attr('disabled','disabled');

	     $('#sel_type').change(function() {	     	
	        if($(this).val() == 'select') {
	           	$('#txt_selectoptions').removeAttr('disabled');
	        }else{
	        	$('#txt_selectoptions').attr('disabled','disabled');
	        }
	     });
	 });

</script>
<div class="span9">
	<div class="row-fluid">
     	<div class="block">
       		<div class="block-content collapse in">
          		<div class="span12">
					<?php
	        			$hiddenflds = array('currentschoolid' => $currentschoolid, 'udf_id' => $udf_id);
	        			echo form_open('udf/editrecord', 'method="post" class="form-horizontal"', $hiddenflds);
	        		?>
		                <fieldset>
		                <?php $this->load->view('shared/display_errors');?>
		                <legend><?php echo $page_title;?></legend>		                
						<div class="control-group">
		                    <label class="control-label" for="sel_category"><?php echo "Category";?></label>
		                    <div class="controls">		                    	
		                    	<?php echo form_dropdown('sel_category', $categories,set_value('sel_category', $udf->category_id),'id="sel_category"'); ?>
		                    </div>
		                </div>
		                <div class="control-group">
		                    <label class="control-label" for="txt_title"><?php echo "Title";?></label>
		                    <div class="controls">
		                    	<?php echo form_input("txt_title", set_value("txt_title", $udf->title)); ?>
		                    </div>
		                </div>
		                <div class="control-group">
		                    <label class="control-label" for="txt_description"><?php echo "Description";?></label>
		                    <div class="controls">
		                    	<?php 
		                    		$data = array(
						              'name'        => 'txt_description',
						              'id'          => 'txt_description',						              
						              'rows'   		=> '4',
						              'cols'        => '50'						              
						            );


		                    		echo form_textarea($data, set_value("txt_description", $udf->description)); 
		                    	?>
		                    </div>
		                </div>
		                <div class="control-group">
		                    <label class="control-label" for="txt_sort"><?php echo "Sort order";?></label>
		                    <div class="controls">
		                    	<?php echo form_input("txt_sort", set_value("txt_sort", $udf->sort_order)); ?>
		                    </div>
		                </div>
		                <div class="control-group">
		                    <label class="control-label" for="sel_type"><?php echo "Type";?></label>
		                    <div class="controls">		                    	
		                    	<?php echo form_dropdown('sel_type', $types, set_value('sel_type', $udf->type),'id="sel_type"');?>
		                    </div>
		                </div>		                
		                <div class="control-group">
		                    <label class="control-label" for="txt_selectoptions"><?php echo "Select Options";?></label>
		                    <div class="controls">		                    	
		                    	<?php 
		                    		$data = array(
						              'name'        => 'txt_selectoptions',
						              'id'          => 'txt_selectoptions',						              
						              'rows'   		=> '4',
						              'cols'        => '50'						              
						            );

		                    		echo form_textarea($data, set_value("txt_selectoptions", $udf->select_options)); 
		                    	?>
		                    </div>
		                </div>
		                <div class="control-group">
		                    <label class="control-label" for="sel_validation"><?php echo "Validation";?></label>
		                    <div class="controls">		                    	
		                    	<?php echo form_multiselect('sel_validation[]', $validations, $this->input->post('sel_validation')?explode('|',$udf->validation):$this->input->post('sel_validation'),'id="sel_validation"');?>
		                    </div>
		                </div>
		                <div class="control-group">
		                    <label class="control-label" for="txt_default"><?php echo "Default Value";?></label>
		                    <div class="controls">
		                    	<?php echo form_input("txt_default", set_value("txt_default",$udf->default_selection)); ?>
		                    </div>
		                </div>
		                <div class="control-group">
		                    <label class="control-label" for="chk_hidden"><?php echo "Hidden";?></label>
		                    <div class="controls">
		                    	<?php echo  form_checkbox('chk_hidden', '1', set_checkbox('chk_hidden', '1', (bool)$udf->hide)); ?>
		                    </div>
		                </div>
						<div class="form-actions">
	                  		<a href="/udf" class="btn"><i class="icon-chevron-left icon-black"></i>Cancel</a>
							          <?php echo form_submit('submit','Submit', 'class="btn btn-primary"'); ?>
							          <?php echo form_close(); ?>
					    </div>
					</fieldset>	
        		</div>  			
  				  				
  			</div>
  		</div>
	</div>
</div>