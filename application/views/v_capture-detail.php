<div class="grid_8 alpha omega text-template">
	<h3>Capture Detail</h3>
	<table class="standard">
	<tbody>
		<tr>
	    <th>Date / Time </th>
	    <th>Port</th>
	    <th>In Current</th>
	    <th>In Voltage</th>
	    <th>Battery Voltage</th>
	    <th>Out Current</th>
	    <th>Out kWh</th>
	    <th>Out aH</th>
    
    </tr>
		<?php if (is_array($detail))
		{
			foreach ($detail as $d)
		   	{
		   		echo "<tr>";
		   		echo "<td>" .  $d['created_date'] . "</td>";
		   		echo "<td>" .  $d['port'] . "</td>";
		   		echo "<td>" .  $d['in_i'] . "</td>";
		   		echo "<td>" .  $d['in_v'] . "</td>";
		   		echo "<td>" .  $d['batt_v'] . "</td>";
		   		echo "<td>" .  $d['out_i'] . "</td>";
		   		echo "<td>" .  $d['out_kwh'] . "</td>";
		   		echo "<td>" .  $d['out_ah'] . "</td>";
		   		

		   		echo "</tr>";
		   	}


		}
		else
		{
			echo '<tr><td colspan="3">No results found for this date range</td></tr>';
		}
		?>
	</tbody>	
	</table>
</div>