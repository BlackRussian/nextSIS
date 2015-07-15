<?php
	//echo 'test1';
	
	
		
		$display = '<div class="row-fluid"><div class="block"><div class="navbar navbar-inner block-header"><div class="muted pull-left">Course Setup Status</div></div>';
		$display .= '<div class="block-content collapse in">';
		
			
			if(isset($termcoursecount))
			{
				$display .= '<div class="span3">';
				//$display .= '<div class="chart-bottom-heading"><span class="label label-info">blank</span></div>';
					
					
						
						$display .= '<div class="chart" data-percent="' . $termcoursecount .'">' . $termcoursecount . '</div>';
						$display .= '<div class="chart-bottom-heading"><span class="label label-info">Course Count</span></div>';
					
				$display .= '</div>';
				
				$display .= '<div class="span3">';
				//$display .= '<div class="chart-bottom-heading"><span class="label label-info"></span></div>';
					
						$gbper = round(($gradebookcount/$termcoursecount) * 100,1);
						
						$display .= '<div class="chart" data-percent="' . $gradebookcount .'">' . $gbper . '%</div>';
						$display .= '<div class="chart-bottom-heading"><span class="label label-info">Gradebook Created</span></div>';
					
				$display .= '</div>';
			}
			
		
		$display .= '</div></div></div>';
		echo $display;
		/*if($this->form_validation->error_array()){
		    $display = '<div class="alert alert-error"><button class="close" data-dismiss="alert">×</button>';
		    $display .= '<ul>';
		    foreach ($this->form_validation->error_array() as $this_error){
		        $display .= '<li>' . $this_error . '</li>';
		    }
		    $display .= '</ul>';
		    $display .= '</div>';
		    echo $display;
		}*/
		
	
	
	//echo 'test2';
?> 