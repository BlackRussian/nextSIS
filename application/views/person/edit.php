<script type="text/javascript">
	$(document).ready(function() {
	     $(".datepicker").datepicker({
    		format: 'dd/mm/yyyy'
		});
	 });
</script>
<div class="span9" id="content">
<div class="row-fluid">
	<?php echo $this->load->view('templates/breadcrumb.php');?>
     <div class="block">
        <div class="block-content collapse in">
          <div class="span12" >
          		<?php 
          		$hiddenflds = array('pid' => $personid);
          		echo form_open('person/editrecord', 'method="post" class="form-horizontal"',$hiddenflds); ?>
					<fieldset>
		                <?php $this->load->view('shared/display_errors');?>
		                <legend><?php echo $page_title;?></legend>
		                <div class="control-group">
		                    <label class="control-label" for="sel_category"><?php echo "Title";?></label>
		                    <div class="controls">		                                        			                    	
		                    	<?php echo form_dropdown('Title', $titles ,set_value('Title', $titleid),'id="Title"');  
		                    	echo  form_hidden('personrole',set_value('personrole', $personrole));
		                    	?>
		                    </div>
		                </div>
		                <div class="control-group">
		                    <label class="control-label" for="fname"><?php echo "First Name";?></label>
		                    <div class="controls">		                    			                    	
		                    	<?php echo form_input('fname', set_value('fname',$fname));  ?>
		                    	<p class="help-block">Enter First Name here e.g. John, Mary</p>
		                    </div>
		                </div>
						<div class="control-group">
		                    <label class="control-label" for="mname"><?php echo "Middle Name";?></label>
		                    <div class="controls">		                    			                    	
		                    	<?php echo form_input('mname', set_value('mname',$mname));  ?>
		                    	<p class="help-block">Enter middle Name here.</p>
		                    </div>
		                </div>
						<div class="control-group">
		                    <label class="control-label" for="lname"><?php echo "Last Name";?></label>
		                    <div class="controls">		                    			                    	
		                    	<?php echo form_input('lname', set_value('lname',$lname));  ?>
		                    	<p class="help-block"> Enter Last name e.g. Brown, Campbell</p>
		                    </div>
		                </div>
		                <div class="control-group">
		                    <label class="control-label" for="cname"><?php echo "Common Name";?></label>
		                    <div class="controls">		                    			                    	
		                    	<?php echo form_input('cname', set_value('cname',$cname));  ?>
		                    	<p class="help-block">Alias or Called name</p>
		                    </div>
		                </div>
						<div class="control-group">
		                    <label class="control-label" for="Gender"><?php echo "Gender";?></label>
		                    <div class="controls">		                    			                    			                    	
		                    	<?php echo form_dropdown('Gender', $genders,set_value('Gender', $genderid),'id="Gender"');  ?>
		                    </div>
		                </div>
		                <div class="control-group">
		                    <label class="control-label" for="uname"><?php echo "User Name";?></label>
		                    <div class="controls">		                    			                    	
		                    	<?php echo form_input('uname', set_value('uname',$uname), 'readonly="readonly"');  ?>
		                    	<p class="help-block">Name used for log in</p>
		                    </div>
		                </div>
		                <div class="control-group">
		                    <label class="control-label" for="dob"><?php echo "Date of Birth";?></label>
		                    <div class="controls">		                    			                    	
		                    	<?php
		                    		$timestamp = strtotime($dob);
		                    		echo form_input('dob', set_value('dob',date("d/m/Y", $timestamp)),'class="datepicker"');  
		                    	?>
		                    </div>
		                </div>					
		                <div class="control-group">
		                    <label class="control-label" for="uname"><?php echo "User Roles";?></label>
		                    <div class="controls">		                    			                    	
		                    	<?php		                    	
									foreach($roles as $role){									
										echo form_checkbox('userrole[]', $role->id, set_checkbox('userrole[]', $role->id, in_array($role->id, $personroles)));
										echo " " .$role->label . "<br />";									
									}
								?>
		                    </div>
		                </div>
 						<?php $this->load->view('shared/display_udf_view');?>
		                <div class="form-actions">
	                  		<a href="/person/<?php echo($personrole)?>" class="btn"> <i class="icon-chevron-left icon-black"></i>Cancel</a>
							          <?php echo form_submit('submit','Submit', 'class="btn btn-primary"'); ?>
							          
					    </div>
					</fieldset>	
        		<?php echo form_close(); ?>
        		</div>  			
  				  				
  			</div>
  		</div>
	</div>
</div>