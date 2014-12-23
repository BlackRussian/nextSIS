<div class="span9">
	<div class="row-fluid">
     	<div class="block">
       		<div class="block-content collapse in">
          		<div class="span12">
					<h1><?php echo $this->lang->line("people");?></h1>
						<table>
						<tr>
							<td>
							First Name
							</td>
							<td>
							Middle Name
							</td>
							<td>
							Surname
							</td>
							<td>
							&nbsp;
							</td>
						</tr>
					 	<?php if(isset($query)){  foreach($query as $person){?>
							<tr>
								<td>
									<?php echo $person->first_name ?>
								</td>
								<td>
									<?php echo $person->middle_name ?>
								</td>
								<td>
									<?php echo $person->surname ?>
								</td>
								<td>
									<a href="edit/<?php echo urlencode($person->id); ?>"><?php echo $this->lang->line("edit_person");?></a>
								</td>
							</tr>
						<?php }}?>
						</table>
        		</div>  			
  			</div>			
		</div>
	</div>
</div>