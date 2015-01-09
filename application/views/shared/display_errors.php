<?php
	if(isset($this->form_validation)){
		if($this->form_validation->error_array()){
		    $display = '<div class="alert alert-error"><button class="close" data-dismiss="alert">×</button>';
		    $display .= '<ul>';
		    foreach ($this->form_validation->error_array() as $this_error){
		        $display .= '<li>' . $this_error . '</li>';
		    }
		    $display .= '</ul>';
		    $display .= '</div>';
		    echo $display;
		}
	}
?> 