<div <div class="span3" id="sidebar">
	<?php if (isset($sidenav)) {
		echo $sidenav;
		}else{
			
			$script = "<script>$(document).ready(function() {
			  $('#sidebar').hide('fast', function() {
			  	$('#content').removeClass('span9');
			  	$('#content').addClass('span12');
			  	$('.hide-sidebar').hide();
			  	$('.show-sidebar').show();
			  });
			})</script>";
			echo $script;
		} ?>
	<!--div class="well span7">
		Incontext help menu here if needed
	</div-->
</div>