<div class="box gray-box" id="battery-history">
	<h4 class="very-dark-blue">Battery Charge History:</h4>
	<span class="dark-gray-text font-12">State of Charge</span>
		
		<div class="bar-wrap">
			<div class="bar1"></div>
			<div class="bar3"></div>
		</div>
		<p class="dark-blue"><?php echo $this->load->get_var("batt_current_soc"); ?>%</p>
		
	<!--
	<h4 class="very-dark-blue">Battery Discharge History:</h4>
	<p class="dark-blue">55%</p>
	-->
					
</div>