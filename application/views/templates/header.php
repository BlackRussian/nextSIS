<!DOCTYPE html>
<!--
 nextSIS home view
 
 PURPOSE 
 This displays the homepage once the user has logged in.
 
 LICENCE 
 This file is part of nextSIS.
 
 nextSIS is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as
 published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
  
 nextSIS is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
  
 You should have received a copy of the GNU General Public License along with nextSIS. If not, see
 <http://www.gnu.org/licenses/>.
  
 Copyright 2012 http://nextsis.org
-->

<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">		
		<link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css');?>" type="text/css">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap-responsive.min.css');?>" type="text/css">
    
    <link rel="stylesheet" href="<?php echo base_url('assets/vendors/uniform.default.css');?>" type="text/css">
    <link rel="stylesheet" href="<?php echo base_url('assets/vendors/wysiwyg/bootstrap-wysihtml5.css');?>" type="text/css">
    <link rel="stylesheet" href="<?php echo base_url('assets/vendors/chosen.min.css');?>" type="text/css">

 <!-- <link href="vendors/datepicker.css" rel="stylesheet" media="screen">
        <link href="vendors/uniform.default.css" rel="stylesheet" media="screen">
        <link href="vendors/chosen.min.css" rel="stylesheet" media="screen">

        <link href="vendors/wysiwyg/bootstrap-wysihtml5.css" rel="stylesheet" media="screen">-->


    



    <!-- TODO: merge two style sheets-->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/DT_bootstrap.css');?>" rel="stylesheet" media="screen">
		<!--link rel="stylesheet" href="<?php echo base_url('assets/css/nextsis.css');?>" type="text/css"-->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/styles.css');?>" type="text/css" media="screen">
    <!--[if lte IE 8]><script language="javascript" type="text/javascript" src="vendors/flot/excanvas.min.js"></script><![endif]-->
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
    <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
    <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
    
    
    <script src="<?php echo base_url('assets/vendors/modernizr-2.6.2-respond-1.1.0.min.js')?>"></script>
    <script src="<?php echo base_url('assets/vendors/jquery-1.9.1.js');?>"></script>
    
    
    
     <script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js');?>"></script>
     <script src="<?php echo base_url('assets/vendors/jquery.uniform.min.js');?>"></script>
    <script src="<?php echo base_url('assets/vendors/chosen.jquery.min.js')?>"></script>
    <script src="<?php echo base_url('assets/vendors/bootstrap-datepicker.js')?>"></script>
    <script src="<?php echo base_url('assets/vendors/wysiwyg/wysihtml5-0.3.0.js')?>"></script>
    <script src="<?php echo base_url('assets/vendors/wysiwyg/bootstrap-wysihtml5.js')?>"></script>
       
    <script src="<?php echo base_url('assets/vendors/wizard/jquery.bootstrap.wizard.min.js')?>"></script>
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
              <a class="brand" href="home">nextSIS&gt;</a>
  				   	<div class="nav-collapse collapse">
                  <ul class="nav pull-right">
                      <li><a href="person/me"><i class="icon-user"></i>&nbsp;<?php echo $username;?></a></li>
                  </ul>     
                  <?php if(isset($nav) && !empty($nav)) {echo $nav;}else{echo "nav failed";} ?>		   		
  				   	</div>
  				</div>
  			</div>
  		</div>
      <div class="container-fluid">
        <div class="row-fluid">