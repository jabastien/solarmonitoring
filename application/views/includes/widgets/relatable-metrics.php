<div class="box gray-box">
	<h4 class="very-dark-blue">Total Energy Created is Equal to:</h4>
	<!--
	<ul class="slideshow-nav">
		<li><a class="orange" href="#rel-today">Today</a></li>
		<li><a href="#rel-week">Week</a></li>
		<li><a href="#rel-year">Year</a></li>
		<li><a href="#rel-inception">Since Inception</a></li>
	</ul>
	-->
	<div id="slideshow-wrapper">
		
		<div id="relatable-metrics" class="float-left relatable-metrics">
			<div>
				<div id="rel-metrics" class="diesel">
				</div>
				<div class="rel-metrics-text text-align-center" style="padding: 5px 10px; display: block;">
					<span class="white strong font-22"><?php echo $this->load->get_var("rm_diesel"); ?></span>
					<span class="white">litres of <br /> diesel saved</span>
					<p class="text-align-center white">when using a generator vs PV</p>
				</div>
			</div>
			<div>
				<div id="rel-metrics" class="light-bulbs">
				</div>
				<div class="rel-metrics-text text-align-center" style="padding: 5px 10px; display: block;">
					<span class="white strong font-22"><?php echo $this->load->get_var("rm_lightbulb"); ?></span>
					<span class="white">15 watt <br /> CFL lightbulbs</span>
					<p class="text-align-center white">running 8hrs/day 365 days/year</p>
				</div>
			</div>
			<div>
				<div id="rel-metrics" class="currency">
				</div>
				<div class="rel-metrics-text text-align-center" style="padding: 5px 10px; display: block;">
					<span class="white strong font-22"><?php echo $this->load->get_var("rm_currency"); ?></span>
					<span class="white">dollars (gourde?) <br /> saved</span>
					<p class="text-align-center white">vs purchasing diesel to power a generator</p>
				</div>
			</div>
			<!--
			<div>
				<div id="rel-metrics" class="car">
				</div>
				<div class="rel-metrics-text text-align-center" style="padding: 5px 10px; display: block;">
					<span class="white strong font-22"><?php // echo $this->load->get_var("rm_car"); ?></span>
					<span class="white">kg <br /> of C02 emissions</span>
					<p class="text-align-center white">avoided</p>
				</div>
			</div>
			-->
			
			
		</div>
		<a href="#back" class="block float-left relative" id="left-button">
				<img class="arrow" src="./img/lt-arrow.png" />
			</a>
			<a href="#fwd" class="block float-right relative" id="right-button">
			<img class="arrow" src="./img/rt-arrow.png" />
		</a>
		
	</div>
	
					
</div>