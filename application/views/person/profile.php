<div class="span9" id="content">
<div class="row-fluid">
     <div class="block">
        <div class="block-content collapse in">
          <div class="span12" >
          <?php
          
          		echo form_open('person/UpdateUserProfile', 'method="post" class="form-horizontal"');
				echo  form_hidden('person_id',set_value('person_id', $profile->id));
				 ?>
          				<fieldset>
		                <?php $this->load->view('shared/display_errors');?>
		                <legend><?php echo $page_title;?></legend>
		                
                      	<?php $style = "padding-top: 5px;"; ?> 
                      	<div class="control-group">
                      		<label class="control-label" for="sel_category"><?php echo "Photo";?></label>
	                      	<div class="span3">
	                          <a href="#" class="thumbnail">
	                            <img data-src="holder.js/260x180" alt="260x180" style="width: 260px; height: 180px;" src="data:image/png;base64,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">
	                          </a>
	                        </div>
                        </div>            
		                <div class="control-group">
		                    <label class="control-label" for="sel_category"><?php echo "Title";?></label>
		                    <div class="controls" style="<?php echo $style ?>">
		                    	<?php echo $profile->title ?>	                                        			                    	
		                    </div>
		                </div>
		                <div class="control-group">
		                    <label class="control-label" for="fname"><?php echo "First Name";?></label>
		                    <div class="controls" style="<?php echo $style ?>">		                    			                    	
		                    	<?php echo $profile->first_name ?>	                                        			                    	
		                    </div>
		                </div>
						<div class="control-group">
		                    <label class="control-label" for="mname"><?php echo "Middle Name";?></label>
		                    <div class="controls" style="<?php echo $style ?>">
		                    	<?php echo $profile->middle_name ?>	                                        			                    	
		                    </div>
		                </div>
						<div class="control-group">
		                    <label class="control-label" for="lname"><?php echo "Last Name";?></label>
		                    <div class="controls" style="<?php echo $style ?>">
		                    	<?php echo $profile->surname ?>	                                        			                    	
		                    </div>
		                </div>
		                <div class="control-group">
		                    <label class="control-label" for="cname"><?php echo "Common Name";?></label>
		                    <div class="controls" style="<?php echo $style ?>">
		                    	<?php echo  $profile->common_name ?>	                                        			                    	
		                    </div>
		                </div>
						<div class="control-group">
		                    <label class="control-label" for="Gender"><?php echo "Gender";?></label>
		                    <div class="controls" style="<?php echo $style ?>">
		                    	<?php echo $profile->gender ?>	                                        			                    	
		                    </div>
		                </div>
		                <div class="control-group">
		                    <label class="control-label" for="uname"><?php echo "User Name";?></label>
		                    <div class="controls" style="<?php echo $style ?>">
		                    	<?php echo $profile->username ?>	                                        			                    	
		                    </div>
		                </div>
		                <div class="control-group">
		                    <label class="control-label" for="uname"><?php echo "Date of Birth";?></label>
		                    <div class="controls" style="<?php echo $style ?>">
		                    	<?php $timestamp = strtotime($profile->dob);
		                    		echo date("F j, Y", $timestamp) . " (<i>" . $age . "</i>)";  ?>	                                        			                    	
		                    </div>
		                </div>						
		                <div class="control-group">
		                    <label class="control-label" for="uname"><?php echo "User Roles";?></label>
		                    <div class="controls" style="<?php echo $style ?>">
		                    	<?php echo  $profile->roles ?>	                                        			                    	
		                    </div>
		                </div>
 						<?php $this->load->view('shared/display_udf_view');?>		
 						<legend>Change Password</legend>
 						<div class="control-group">
		                    <label class="control-label" for="fname"><?php echo "Password";?></label>
		                    <div class="controls">		                    			                    	
		                    	<input type="password" name="old_password" placeholder="Current Password: " class="form-control">
		                    	
		                    </div>
		                </div>
						<div class="control-group">
		                    <label class="control-label" for="mname"><?php echo "New Password";?></label>
		                    <div class="controls">		                    			                    	
		                    	<input type="password" name="newpassword" placeholder="New Password: " class="form-control">
		                    	
		                    </div>
		                </div>
 						<div class="control-group">
		                    <label class="control-label" for="mname"><?php echo "Confirm Password";?></label>
		                    <div class="controls">		                    			                    	
		                    	<input type="password" name="con_password" placeholder="Confirm Password: " class="form-control">
		                    	
		                    </div>
		                </div>                
					</fieldset>	
        		<div class="form-actions">
          			
				          <?php echo form_submit('submit','Change Password', 'class="btn btn-primary"'); ?>
		        </div>
	          	<?php echo form_close(); ?>
        		</div>  			
  				  				
  			</div>
  		</div>
	</div>
</div>