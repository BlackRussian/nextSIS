<script type="text/javascript">
	$(document).ready(function() {
	     if ($('#sel_type').val() != "text")
			setValidationList(false);

	     if ($('#sel_type').val() != "select" && $('#sel_type').val() != "checkbox")
	     	$('#txt_selectoptions').attr('disabled','disabled');

	     $('#sel_type').change(function() {	     	
	        if($(this).val() == 'select' || $(this).val() == 'checkbox') {
	           	$('#txt_selectoptions').removeAttr('disabled');
	        }else{
	        	$('#txt_selectoptions').attr('disabled','disabled');
	        }

	        if ($('#sel_type').val() != "text")
				setValidationList(false);
			else				
				setValidationList(true);

	     });
	 });

	function setValidationList(enabled){
		$("#sel_validation > option").each(function() {
			if (this.text != "required")
			    if (enabled)
			    	$(this).prop("disabled", false);
			    else
			    	$(this).prop("disabled", true);
		});
	}
</script>
<div class="span9" id="content">
	<div class="row-fluid">
     	<div class="block">
       		<div class="block-content collapse in">
          		<div class="span12" id="content">
					<?php
	        			$hiddenflds = array('currentschoolid' => $currentschoolid);
	        			echo form_open('udf/addrecord', 'method="post" class="form-horizontal"', $hiddenflds);
	        		?>
		                <fieldset>
		                <?php $this->load->view('shared/display_errors');?>
		                <legend><?php echo $page_title;?></legend>
						<div class="control-group">
		                    <label class="control-label" for="sel_category"><?php echo "Category";?></label>
		                    <div class="controls">		                    	
		                    	<?php echo form_dropdown('sel_category', $categories,set_value('sel_category', ''),'id="sel_category"'); ?>
		                    </div>
		                </div>
		                <div class="control-group">
		                    <label class="control-label" for="txt_title"><?php echo "Title";?></label>
		                    <div class="controls">
		                    	<?php echo form_input("txt_title", set_value("txt_title")); ?>
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


		                    		echo form_textarea($data, set_value("txt_description")); 
		                    	?>
		                    </div>
		                </div> 
		                <div class="control-group">
		                    <label class="control-label" for="txt_sort"><?php echo "Sort order";?></label>
		                    <div class="controls">
		                    	<?php echo form_input("txt_sort", set_value("txt_sort","1")); ?>
		                    </div>
		                </div>
		                <div class="control-group">
		                    <label class="control-label" for="sel_type"><?php echo "Type";?></label>
		                    <div class="controls">		                    	
		                    	<?php echo form_dropdown('sel_type', $types, set_value('sel_type', ''),'id="sel_type"');?>
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


		                    		echo form_textarea($data, set_value("txt_selectoptions")); 
		                    	?>
		                    </div>
		                </div>
		                <div class="control-group">
		                    <label class="control-label" for="sel_validation"><?php echo "Validation";?></label>
		                    <div class="controls">		                    	
		                    	<?php echo form_multiselect('sel_validation[]', $validations, $this->input->post('sel_validation'),'id="sel_validation"');?>
		                    </div>
		                </div>
		                <div class="control-group">
		                    <label class="control-label" for="txt_default"><?php echo "Default Value";?></label>
		                    <div class="controls">
		                    	<?php echo form_input("txt_default", set_value("txt_default")); ?>
		                    </div>
		                </div>
		                <div class="control-group">
		                    <label class="control-label" for="chk_hidden"><?php echo "Hidden";?></label>
		                    <div class="controls">
		                    	<?php echo  form_checkbox('chk_hidden', '1', set_checkbox('chk_hidden', '1')); ?>
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