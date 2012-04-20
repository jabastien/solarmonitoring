<div class="grid_8 alpha omega text-template">
	<h3>Alerts</h3>
	<table class="standard">
	<tbody>
		<tr>
	    <th>Date / Time </th>
	    <th>Alert Detail</th>
	    <th>Alert Level</th>
    
    </tr>
		<?php if (is_array($all_alerts))
		{
			foreach ($all_alerts as $alert)
		   	{
		   		echo "<tr>";
		   		echo "<td>" .  $alert['created_date'] . "</td>";
		   		echo "<td>" .  $alert['detail'] . "</td>";
		   		echo "<td>" .  $alert['level'] . "</td>";
		   		

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