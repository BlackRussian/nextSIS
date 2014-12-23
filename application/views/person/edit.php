<div class="span9">
<div class="row-fluid">
     <div class="block">
        <div class="block-content collapse in">
          <div class="span12">
        		<?php echo form_open('person/editrecord'); ?>
					<h1>Edit Person</h1>
					<table>
					<tr>
						<td>Title</td>
						<td>
						<select id="Title" name="Title">
						<?php foreach($titles as $title){ 
							$selected = False;
							$value= $title->id;
							$text = $title->label;
							if($titleid == $value){$selected = 'selected';}
								
							echo '<option value="'. $value .'" '.$selected.'>'. $text . '</option>';
							
						}?>
						</select>
					</tr>
					
					<tr>
						<td>
							First Name
						</td>
						<td>
							<?php echo "<input type='text' id='fname' name='fname' value='". $fname ."'/>"?>
					</tr>
					<tr>
						<td>
						Middle Name
						</td>
						<td>
						<?php echo "<input type='text' id='mname' name='mname' value='". $mname ."'/>"?>
						</td>
					</tr>
					<tr>
						<td>
							Last Name
						</td>
						<td>
							<?php echo "<input type='text' id='lname' name='lname' value='". $lname ."'/>"?>
					</tr>
					<tr>
						<td>
							Common Name
						</td>
						<td>
							<?php echo "<input type='text' id='cname' name='cname' value='". $cname ."'/>"?>
					</tr>
					<tr>
						<td>Gender</td>
						<td>
						<input style="display:none"; type="text" id="hide" name="pid" value="<?php echo $personid; ?>">
						<select id="Gender" name="Gender">
						<?php foreach($genders as $gender){ 
						
							$selected = False;
							$value= $gender->id;
							$text = $gender->label;
							if($genderid == $value){$selected = 'selected';}
								
							echo '<option value="'. $value .'" '.$selected.'>'. $text . '</option>';
						}?>
						</select>
					</tr>
					<tr>
						<td>
							User Name
						</td>
						<td>
							<?php echo "<input type='text' name='uname' value='". $uname ."'/>"?>
					</tr>
					<tr>
						<td>
							User Roles
						</td>
						<td>
							<?php foreach($roles as $role){ 
							$selected="";
							if(is_array($personroles))
							{
								foreach($personroles as $pr)
								{
									if($pr->role_id == $role->id)
										$selected = "checked";
								}
								
							}
							echo "<input   type='checkbox' name='userrole[]'  value='". $role->id ."'". $selected ." />" .$role->label ."<br/>";
							//$selected = False;
							//$value= $gender->id;
							//$text = $gender->label;
							//if($genderid == $value){$selected = 'selected';}
								
							//echo '<option value="'. $value .'" '.$selected.'>'. $text . '</option>';
						}?>
						
						</td>
					</tr>
					<tr>
						<td colspan="2">
						<?php echo form_submit('submit','submit'); ?>
						<?php echo form_close(); ?>
							
							
						</td>
					</tr>
					</table>
        		</div>  			
  				  				
  			</div>
  		</div>
	</div>
</div>