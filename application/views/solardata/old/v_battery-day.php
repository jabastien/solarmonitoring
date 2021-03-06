	<div class="grid_8 alpha omega tabs">
					<?php $this->load->view('includes/solar-data-subnav'); ?>
			
				
					<ul id="solar-detail-toggle">
						<li><a href="<?php echo base_url(); ?>solar-data">Basic Solar Data</a></li>
						<li><a class="strong" href="<?php echo base_url(); ?>technical-solar-data/kwh">Technical Solar Data</a></li>
					</ul>
					<div class="solar-data-tab" id="first" style="display: block;">
						<ul id="period">
						<li><a href="<?php echo base_url(); ?>technical-solar-data/battery">Today</a></li>
						<li><a class="" href="<?php echo base_url(); ?>technical-solar-data/battery/week">Week</a></li>
						<li><a class="" href="<?php echo base_url(); ?>technical-solar-data/battery/month">Month</a></li>
						<li><a <?php if (classactive($period, 'year') { echo 'class="period-active"';} ?> href="<?php echo base_url(); ?>technical-solar-data/battery/year">Year</a></li>
						<li><a class="" href="<?php echo base_url(); ?>technical-solar-data/battery/since-inception">Since Inception</a></li>
						</ul>
						<?php $this->load->view('includes/chart'); ?>
					</div>
					
				</div>
				<div class="grid_8 alpha omega white-bg">
				<p class="download"><a href="#">Download spreadsheet of current display</a></p>
				</div>
				<div id="solar-detail-wrap" class="grid_8 alpha omega white-bg">
					<table id="solar-detail">
						<tr>
					    <th>Date / Time </th>
					    <th>Battery Voltage</th>
					    <th>Amps (out)</th>
					    <th>kWh (out)</th>
					   </tr>

					   <?php 
					   	
					   if (is_array($batteryday))
					   {
					   		switch($period)
					   		{
					   			case 'year':
					   			foreach ($batteryday as $item)
								   {
								   		echo "<tr>";
								   		echo "<td>" .  $item['date'] . "  " . rangeIntervalFrom24($item['hour']) . "</td>";
								   		echo "<td>" .  $item['batt_v'] . "</td>";
								   		echo "<td>" .  $item['out_current'] . "</td>";
								   		echo "<td>" .  $item['out_kwh'] . "</td>";

								   		echo "</tr>";
								   }
								  break;

								  case 'day':
					   			  foreach ($batteryday as $item)
								   {
								   		echo "<tr>";
								   		echo "<td>" .  $item['date'] . "  " . rangeIntervalFrom24($item['hour']) . "</td>";
								   		echo "<td>" .  $item['batt_v'] . "</td>";
								   		echo "<td>" .  $item['out_current'] . "</td>";
								   		echo "<td>" .  $item['out_kwh'] . "</td>";

								   		echo "</tr>";
								   }

							}

					   }
					   else
					   {
					   	echo '<tr><td colspan="4">No results found for this date range</td></tr>';
					   }
					   
					   ?>

					 
					</table>
				</div>