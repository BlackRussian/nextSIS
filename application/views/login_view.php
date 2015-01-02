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
    <title>Login page - nextSIS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Le styles -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap-responsive.min.css');?>" type="text/css">
	<link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css');?>" type="text/css">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/typica-login.css');?>" type="text/css">

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le favicon -->
    <link rel="shortcut icon" href="favicon.ico">
		
	</head>
	<body>
    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="/home">SCHOOL NAME and Crest or default logo</a>
        </div>
      </div>
    </div>

	<div class="container">

	    <div id="login-wraper">
	    	<?php echo form_open('login/authenticate', 'method="post" class="form login-form"'); ?>
	            <fieldset>
	            <legend>Sign in to <span class="blue">nextSIS</span></legend>
	            <?php $this->load->view('shared/display_errors.php');?>
	            <div class="body">
	                <label>Username</label>
	                <input type="text" name="username">
	                <label>Password</label>
	                <input type="password" name="password">
	            </div>
	            <div class="footer">
	                <label class="checkbox inline">
	                    <input type="checkbox" id="inlineCheckbox1" value="option1"> Remember me
	                </label>          
	                <button type="submit" class="btn btn-success">Login</button>
	            </div>  
	            </fieldset>
	        <?php echo form_close(); ?>
	    </div>
	</div>

	<footer class="white navbar-fixed-bottom">
	  Don't have an account yet? <a href="register.html" class="btn btn-black">Register</a>
	</footer>
	<script src="/assets/vendors/jquery-1.9.1.min.js"></script>
	<script src="/assets/js/bootstrap.min.js"></script>
    <script src="/assets/js/backstretch.min.js"></script>
    <script type="text/javascript">
    	jQuery(document).ready(function($) {
			$.backstretch([
		      "/assets/loginbg/bg1.png", 
		      "/assets/loginbg/bg2.png"
		  	], {duration: 3000, fade: 750});
				
		});
    </script>
</body>
</html>		
