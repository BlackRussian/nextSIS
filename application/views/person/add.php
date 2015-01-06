<div class="span9" id="content">
	<div class="row-fluid">
     <?php echo $this->load->view('templates/breadcrumb.php');?>
     <div class="block">
        <div class="block-content collapse in">
          <div class="span12">
        		<?php echo form_open('person/addrecord'); ?>
					<h3>Add Person</h3>
					<table>
						<tr>
							<td>Title</td>
							<td>
								<?php echo form_dropdown('Title', $titles,'','class="required" id="Title"');  ?>
							</td>
						</tr>
						
						<tr>
							<td>
								First Name
							</td>
							<td>
								<?php echo "<input type='text' id='fname' name='fname' />"?>
							</td>
						</tr>
						<tr>
							<td>
							Middle Name
							</td>
							<td>
							<?php echo "<input type='text' id='mname' name='mname' />"?>
							</td>
						</tr>
						<tr>
							<td>
								Last Name
							</td>
							<td>
								<?php echo "<input type='text' id='lname' name='lname' />"?>
								</td>
						</tr>
						<tr>
							<td>
								Common Name
							</td>
							<td>
								<?php echo "<input type='text' id='cname' name='cname' />"?>
								</td>
						</tr>
						<tr>
							<td>Gender</td>
							<td>
								<?php echo form_dropdown('Gender', $genders,'','class="required" id="Gender"');  ?>
							</td>
						</tr>
						<tr>
							<td>
								User Name
							</td>
							<td>
								<?php echo "<input type='text' id='uname' name='uname' />"?>
								</td>
						</tr>
						<tr>
							<td>
								User Roles
							</td>
							<td>
								<?php
									foreach($roles as $role){ 
										$selected="";
										echo "<input   type='checkbox' name='userrole[]'  value='". $role->id ."'". $selected ." />" .$role->label ."<br/>";
									}
								?>
							</td>
						</tr>
						<tr>
							<td colspan="2">
								<?php echo form_submit('submit','submit', 'class="btn btn-primary"'); ?>
								<?php echo form_close(); ?>
							</td>
						</tr>
					</table>
        		</div>  			
  				  				
  			</div>
  		</div>
	</div>
</div>