<div class="box gray-box">
	<h4 class="very-dark-blue float-left">Recent Alerts:</h4>
	<span class="since upper white float-right font-12"><a href="<?php echo base_url(); ?>alerts">View All</a></span>
	<br class="clear">
	<table id="alerts">
	<?php $alert_array = $this->load->get_var("alerts");	
		if (is_array($alert_array))
		{
			foreach ($alert_array as &$alert)
			{	
				echo "<tr>";
				echo "<td>" . $alert['detail'] . "</td>";
				echo "<td>" . date("m/d/y", strtotime($alert['created_date'])) . "</td>";
				//echo "<td>" . $alert['level'] . "</td>";

				echo "</tr>";
			}
		
		}
		else
		{
			echo "<tr><td colspan=2>No Alerts Found</td></tr>";
		}
	?>

	</table>
					
</div>