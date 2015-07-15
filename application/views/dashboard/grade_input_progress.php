<?php
	//echo 'test1';
	if(isset($teachercourses))
	{
	if(is_array($teachercourses)){
		
		$display = '<div class="row-fluid"><div class="block"><div class="navbar navbar-inner block-header"><div class="muted pull-left">Grade Input Progress</div></div>';
		$display .= '<div class="block-content collapse in">';
		foreach($teachercourses as $s)
		{
			
			echo $s->title;
			$display .= '<div class="span3">';
			$display .= '<div class="chart-bottom-heading"><span class="label label-info">' . $s->title .'</span></div>';
			foreach($subjectgradecount as $gc)
			{
				
				//echo $gc->title;
				
				if($s->term_course_id == $gc->term_course_id)
				{
					
					$per = 0;
					if($gc->registeredStudentCount > 0)
						//$per = round((7 / 9) * 100);
						$per = round(($gc->gradesEntered / $gc->registeredStudentCount) * 100,1);
					
					$display .= '<div class="chart" data-percent="' . $per .'">' . $per . '%</div>';
					$display .= '<div class="chart-bottom-heading"><span class="label label-info">' . $gc->gradetype .'</span></div>';
				}
				
				
			}
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
		
	}
	}
	//echo 'test2';
?> 