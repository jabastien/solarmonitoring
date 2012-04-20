	<div class="grid_8 alpha omega tabs">
					<?php $this->load->view('includes/solar-data-subnav'); ?>
			
				
					<ul id="solar-detail-toggle">
						<li><a href="<?php echo base_url(); ?>solar-data">Basic Solar Data</a></li>
						<li><a class="strong" href="<?php echo base_url(); ?>technical-solar-data/pv">Technical Solar Data</a></li>
					</ul>
					<div class="solar-data-tab" id="first" style="display: block;">
						<ul id="period">
						<li><a <?php if (classactive($period, 'day')) { echo 'class="period-active"';} ?> href="<?php echo base_url(); ?>technical-solar-data/pv">Today</a></li>
						<li><a <?php if (classactive($period, 'week')) { echo 'class="period-active"';} ?> href="<?php echo base_url(); ?>technical-solar-data/pv/week">Week</a></li>
						<li><a <?php if (classactive($period, 'month')) { echo 'class="period-active"';} ?> href="<?php echo base_url(); ?>technical-solar-data/pv/month">Month</a></li>
						<li><a <?php if (classactive($period, 'year')) { echo 'class="period-active"';} ?> href="<?php echo base_url(); ?>technical-solar-data/pv/year">Year</a></li>
						<li><a <?php if (classactive($period, 'inception')) { echo 'class="period-active"';} ?> href="<?php echo base_url(); ?>technical-solar-data/pv/since_inception">Since Inception</a></li>
						</ul>
						<div id="chart-date-label" class="float-right"><?php if (isset($chartdatelabel)) { echo "Chart Data:  " . $chartdatelabel; } ?></div>
						<br clear="all" />
						<?php $this->load->view('includes/chart'); ?>
					</div>
					
				</div>
				<div class="grid_8 alpha omega white-bg">
				<p class="download"><a target="_blank" href="<?php echo base_url(); ?>technical-solar-data/pv/download">Download spreadsheet of raw data</a></p>
				</div>
				<div id="solar-detail-wrap" class="grid_8 alpha omega white-bg">
					<table id="solar-detail">
				

					   <?php 
					   	
					   	
					   if (is_array($pv))
					   {
					   		switch($period)
					   		{
					   			 case 'day':
					   			 	echo "<tr>";
								    echo "<th>Date / Time </th>";
								    echo "<th>Input Voltage (avg volts)</th>";
								    echo "<th>Input Current (avg amps)</th>";
								    
								    echo "</tr>";

					   			  	foreach ($pv as $item)
								   	{
								   		echo "<tr>";
								   		echo '<td><a href="' . base_url() . 'capture_detail/' .  $item['date'] . '/' . $item['hour'] . '">' .  prettyDate($item['date']) . "  " . rangeIntervalFrom24($item['hour']) . "</td>";
								   		echo "<td>" .  $item['in_voltage'] . "</td>";
								   		echo "<td>" .  $item['in_current'] . "</td>";
								   		

								   		echo "</tr>";
								   	}

								 break;

								 case 'week':
								 	echo "<tr>";
								    echo "<th>Date </th>";
								    echo "<th>Input Voltage (avg volts)</th>";
								    echo "<th>Input Current (avg amps)</th>";
								    echo "</tr>";
								 	foreach ($pv as $item)
								  	{
								   		echo "<tr>";
								   		echo '<td><a href="' . base_url() . "technical-solar-data/pv/day/" .  $item['day'] . '">' . $item['date'] . "</td>";
								   		echo "<td>" .  $item['in_voltage'] . "</td>";
								   		echo "<td>" .  $item['in_current'] . "</td>";
								   		echo "</tr>";
								   	}
						   			break;
								  case 'month':
								  		echo "<tr>";
								    echo "<th>Date </th>";
								    echo "<th>Input Voltage (avg volts)</th>";
								    echo "<th>Input Current (avg amps)</th>";
								    echo "</tr>";
								 foreach ($pv as $item)
								   {
								   		echo "<tr>";
								   		echo '<td><a href="' . base_url() . "technical-solar-data/pv/day/" .  $item['day'] . '">' . $item['date'] . "</td>";
								   		echo "<td>" .  $item['in_voltage'] . "</td>";
								   		echo "<td>" .  $item['in_current'] . "</td>";
								   		echo "</tr>";
								   }
								  break;

					   			case 'year':
								  	echo "<tr>";
								    echo "<th>Date </th>";
								    echo "<th>Input Voltage (avg volts)</th>";
								    echo "<th>Input Current (avg amps)</th>";
								    echo "</tr>";
								 foreach ($pv as $item)
								   {
								   		echo "<tr>";
								   		echo '<td><a href="' . base_url() . "technical-solar-data/pv/day/" .  $item['day'] . '">' . $item['date'] . "</td>";
								   		echo "<td>" .  $item['in_voltage'] . "</td>";
								   		echo "<td>" .  $item['in_current'] . "</td>";
								   		echo "</tr>";
								   }
								 break;

								 case 'inception':
								  	echo "<tr>";
								    echo "<th>Date </th>";
								    echo "<th>Input Voltage (avg volts)</th>";
								    echo "<th>Input Current (avg amps)</th>";
								    echo "</tr>";
								 foreach ($pv as $item)
								   {
								   		echo "<tr>";
								   		echo '<td><a href="' . base_url() . "technical-solar-data/pv/day/" .  $item['day'] . '">' . $item['date'] . "</td>";
								   		echo "<td>" .  $item['in_voltage'] . "</td>";
								   		echo "<td>" .  $item['in_current'] . "</td>";
								   		echo "</tr>";
								   }
								 break;
								  
								 default:
								 echo '<tr><td colspan="4">No results found for this date range</td></tr>';
								 break;

								 

							}

					   }
					   else
					   {
					   	echo '<tr><td colspan="4">No results found for this date range</td></tr>';
					   }
					   
					   ?>

					 
					</table>
				</div>