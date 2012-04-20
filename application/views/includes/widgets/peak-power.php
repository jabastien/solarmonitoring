<div class="box gray-box">
	<!--
	<h4 class="very-dark-blue">Peak Power kWh:</h4>
	<p>stuff</p>
	-->
	<h4 class="very-dark-blue">Cumulative Amp Hours used</h4>
	<table id="amp-hours-used">
	<tr><td>Today</td><td class="text-align-right"><?php echo $this->load->get_var("current_daily_ah"); ?></td></tr>	
	<tr><td>This Week</td><td class="text-align-right"><?php echo $this->load->get_var("past_week_ah"); ?></td></tr>	
	<tr><td>This Month</td><td class="text-align-right"><?php echo $this->load->get_var("past_month_ah"); ?></td></tr>	
	<tr><td>This Year</td><td class="text-align-right"><?php echo $this->load->get_var("past_year_ah"); ?></td></tr>	
	</table>	

					
</div>