<!DOCTYPE html>
<html>
<meta content="GreenWifi Stuff" name='description'>
<title>GreenWifi | IIT | University of Colorado at Boulder | Solar Monitoring System</title>
<link rel="stylesheet" type="text/css" media="all" href="<?php echo base_url();?>css/reset.css" />
<link rel="stylesheet" type="text/css" media="all" href="<?php echo base_url();?>css/960.css" />
<link href='http://fonts.googleapis.com/css?family=Open+Sans|Open+Sans+Condensed:300|Lato:300,700' rel='stylesheet' type='text/css'>
<link rel="stylesheet" type="text/css" media="all" href="<?php echo base_url();?>css/greenwifi-960.css" />
<script src="<?php echo base_url();?>js/jquery1.7.1-min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>js/jquery.bxSlider.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>js/raphael-1.5.2-min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>js/sm_raphael_linechart.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>js/sm_solar-data.js" type="text/javascript"></script> 
<script charset="utf-8" type="text/javascript">



$(document).ready(function() {



var slider = $('#relatable-metrics').bxSlider({
    controls: false
  });	
  $('#left-button').click(function(){
    slider.goToPreviousSlide();
    return false;
  });

  $('#right-button').click(function(){
    slider.goToNextSlide();
    return false;
  });

// run the function to calculate laptops charged
graph_laptops();

// load active widgets
	if ($('#battery-history').length > 0)
		{
			create_battery_SOC_bar();
		}
	if ($('#energy-generation').length > 0)
		{
			create_energy_gen_bar();
		}



if ($('#big-chart').length > 0)
{

	
	$.ajax({
		 type: "GET",
		 url: "<?php if (isset($api)) { echo base_url(); echo $api['url']; }   ?>" ,
		 dataType: "json",
		 success: function(data)
		 {
		 	//fill table data
		 	<?php if (isset($api)) { echo $api['success']; }  ?>
		 },
		
		 complete: function(data)
		 {
		 	// build graph
		 	<?php if (isset($api)) { echo $api['complete']; }  ?>

		 }
		});

	//setup chart
	var chartwidth = 610;
	var chartheight = 320;
	paper = Raphael("big-chart", chartwidth, chartheight); // init the raphael obj and give it a width plus height
  
}
 



	
	
 });

  

</script>

<body>
	
<div class="wrapper">
	<div class="container">
	
		<div class="container_12">
			<div class="grid_8"> <!-- start grid_8 for page-body -->
