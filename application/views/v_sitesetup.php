<html>
<head>
	<title>Site Setup</title>
<link href="./css/reset.css" media="all" type="text/css" rel="stylesheet">
<link href="./css/960.css" media="all" type="text/css" rel="stylesheet">
<style>
#site-setup
{
color: maroon;
font-size: 20px;
line-height: 2em;
}
</style>
</head>
<body>
<div class="container_12" style="text-align: center">

<div id="site-setup" class="grid_12" style="margin-top: 40px">
	<p>You don't have a default site setup.  You need to enter a record into the site table to setup your default site</p>	
	<p>You can set it up manually using phpmyadmin or you can edit and then run the example script located here: install/sitecreate.sql </p>
	<h2>MAKE SURE YOU EDIT THE CONTENTS OF THE SCRIPT SO IT'S APPROPRIATE FOR YOUR SITE!!</h2>
	<p>If you think you have one setup, make sure you don't have more than one!</p>
</div>
<?php
	/*		
	echo form_open('site/submit');
	echo form_label('Site Name', 'sitename');
	echo form_input('sitename', set_value('sitename',''));
	echo '<br class="clear" />';
	echo form_label('&nbsp', '');
	echo form_submit('submit', 'Submit');
	echo form_close();
	*/
	

?>
<!-- 
	<div id="errors">
		<?php echo validation_errors(); ?>
	</div>
-->

</div>
</body>
</html>