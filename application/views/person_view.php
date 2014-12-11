<div class="container-fluid">
  			<div class="row-fluid">
  				<div class="span4 navleft">
  					<ul class="nav nav-pills nav-stacked">
  						<li class="active"><a href=""><?php echo $this->lang->line("search");?>&nbsp;<i class="icon-search icon-white"></i></a></li>
  						<li><a href="person/add"><?php echo $this->lang->line("add_new_person");?></a></li>
  						<li><a href=""><?php echo $this->lang->line("attendance");?></a></li>
  						<li><a href="grades/listing"><?php echo $this->lang->line("grades");?></a></li>  						  						
  					</ul>
  					<div class="well">
  						<p><b><?php echo $this->lang->line("help");?></b>&nbsp;<?php echo $this->lang->line("sample_help_message");?></p>
  					</div>
  				</div>
  				
        		<div class="span8">
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
  		
	</body>
</html>