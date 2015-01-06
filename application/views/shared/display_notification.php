<?php
	if($this->session->flashdata('msgerr')){
	    $display = '<div class="alert alert-error"><button class="close" data-dismiss="alert">×</button>';
	    $display .= $this->session->flashdata('msgerr');
	    $display .= '</div>';
	    echo $display;
	}
	if($this->session->flashdata('msgsuccess')){
		$display = '<div class="alert alert-success"><button class="close" data-dismiss="alert">×</button>';
	    $display .= $this->session->flashdata('msgsuccess');
	    $display .= '</div>';
	    echo $display;
	}
?> 