	<div id="energy-generation" class="box gray-box">
		<h4 class="very-dark-blue" style="margin-bottom: 0px">Energy Production</h4>
		<span class="very-dark-blue font-12">Current /</span>
		<span class="white font-12">Daily High</span>
		<div class="bar-wrap">
			<div class="bar1"></div>
			<div class="bar2"></div>
			<div class="bar3"></div>

		</div>
		<p><span class="very-dark-blue"><?php echo $this->load->get_var("current_daily_kwh"); ?> / </span>
			<span class="white"><?php echo $this->load->get_var("max_daily_kwh"); ?> (high)</span>
		</p>
		<hr class="white-dotted" />
		<h4 class="very-dark-blue" style="margin-top:5px">Cumulative Energy Generated to Date</h4>
		<span class="white strong font-22"><?php echo $this->load->get_var("cumulative_kwh"); ?></span>
		<span class="white strong font-14">kilowatt hours</span>
	</div>
