<!DOCTYPE html>
<?php  $session_info = $this->session->userdata('logged_in');?>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">		
		<link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css');?>" type="text/css">

    <!-- TODO: merge two style sheets-->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/DT_bootstrap.css');?>" rel="stylesheet" media="screen">
		<!--link rel="stylesheet" href="<?php echo base_url('assets/css/nextsis.css');?>" type="text/css"-->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/styles.css');?>" type="text/css" media="screen">
    
    <link href="<?php echo base_url('assets/vendors/easypiechart/jquery.easy-pie-chart.css');?>" rel="stylesheet" media="screen">
    
    
    <!--[if lte IE 8]><script language="javascript" type="text/javascript" src="vendors/flot/excanvas.min.js"></script><![endif]-->
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <script src="/assets/vendors/jquery-1.9.1.min.js"></script>
    <script src="/assets/vendors/modernizr-2.6.2-respond-1.1.0.min.js"></script>
    <link rel="shortcut icon" href="<?php echo base_url('assets/img/nextsis.favicon.png');?>">
    <title><?php echo $this->lang->line('student_information_system');?></title>
	</head>
	
	<body>
		<div class="navbar navbar-fixed-top">
  			<div class="navbar-inner">
  				<div class="container-fluid">
  				   	<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </a>
              <a class="brand" href="/home">nextSIS&gt;</a>
  				   	<div class="nav-collapse collapse">
                <ul class="nav pull-right">
                            <li class="dropdown">
                                <a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown"> <i class="icon-user"></i>&nbsp;<?php echo $session_info['fullname'];?>&nbsp;<i class="caret"></i>

                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a tabindex="-1" href="/person/profile">Profile</a>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <a tabindex="-1" href="/person/logout">Logout</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>    
                  <?php if(isset($nav) && !empty($nav)) {echo $nav;}else{echo "nav failed";} ?>		   		
  				   	</div>
  				</div>
  			</div>
  		</div>
      <div class="container-fluid">
        <div class="row-fluid">