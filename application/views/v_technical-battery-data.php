	<div class="grid_8 alpha omega tabs">
					<?php $this->load->view('includes/solar-data-subnav'); ?>
				
					<ul id="solar-detail-toggle">
						<li><a href="<?php echo base_url(); ?>solar-data">Basic Solar Data</a></li>
						<li><a class="strong" href="<?php echo base_url(); ?>technical-solar-data/kwh">Technical Solar Data</a></li>
					</ul>
					<div class="solar-data-tab" id="first" style="display: block;">
						<ul id="kwh-period">
						<li><a class="kwh-period kwh-period-active" href="<?php echo base_url(); ?>technical-solar-data/battery">Today</a></li>
						<li><a class="kwh-period" href="<?php echo base_url(); ?>technical-solar-data/battery/week">Week</a></li>
						<li><a class="kwh-period" href="<?php echo base_url(); ?>technical-solar-data/battery/month">Month</a></li>
						<li><a class="kwh-period" href="<?php echo base_url(); ?>technical-solar-data/battery/year">Year</a></li>
						<li><a class="kwh-period" href="<?php echo base_url(); ?>technical-solar-data/battery/since-inception">Since Inception</a></li>
						</ul>
						<div id="big-chart">
						</div>
					</div>
					<div class="solar-data-tab" id="second" style="display: none;">
						<p>Tab 2</p>
					</div>
					<div class="solar-data-tab" id="third" style="display: none;">
						<p>Tab 3</p>
					</div>
					<div class="solar-data-tab" id="fourth" style="display: none;">
						<p>Tab 4</p>
					</div>
					<div class="solar-data-tab" id="fifth" style="display: none;">
						<p>Tab 5</p>
					</div>
				</div>
				<div class="grid_8 alpha omega white-bg clear">
				<p class="download"><a href="#">Download spreadsheet of current display</a></p>
				</div>
				<div id="solar-detail-wrap" class="grid_8 alpha omega white-bg">
					<table id="solar-detail">
						<tr>
					    <th>Date / Time </th>
					    <th>kW</th>
					    <th>Battery Voltage</th>
					    <th>Amps</th>
					   </tr>

					   <?php 
					   	
					   if (is_array($detailarray))
					   {
					   		foreach ($detailarray as $item)
						   {
						   		echo "<tr>";
						   		//echo "<td>" .  date('M-d-y g:i A', $item['localtime']) . "</td>";
						   		echo "<td>" .  $item['localtime'] . "</td>";
						   		echo "<td>" .  $item['kw'] . "</td>";
						   		echo "<td>" .  $item['batt_v'] . "</td>";
						   		echo "<td>" .  $item['amps'] . "</td>";

						   		echo "</tr>";
						   }


					   }
					   else
					   {
					   	echo '<tr><td colspan="4">No results found for this date range</td></tr>';
					   }
					   
					   ?>

					 
					</table>
				</div>