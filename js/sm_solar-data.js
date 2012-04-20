// helper functions
function is_int(value){ 
  if((parseFloat(value) == parseInt(value)) && !isNaN(value)){
      return true;
  } else { 
      return false;
  } 
}
function checkfornodata(data, label)
{
	if (data == 0.00)
		{ label = "no data"; } 
	else 
		{ label = Math.round(data*10)/10 + ' ' + label; }
	return label;
}

function intervalfrom24(h) {
	if(h > 12) 
	{

    h = h - 12;
    e = parseInt(h)+1;
    h = h + ':00 - ' + e + ':00 PM';
  	}
  	else
  	{ 
  		if (h == 11)
  		{
  			h = '11:00 AM - noon';
  		}
  		if (h == 12)
  		{
  			e = 1;
  			h = 'noon - ' + e + ':00 PM';
  		}
  		if (h < 12)
  		{
  			e = parseInt(h)+1;
  			h = h + ':00 - ' + e + ':00 AM';
  		}
  	}
 
  return h;
}
// end helpers
/*
var xarray = [];
var yarray = [];
*/
function grabAndFillKwh(data, type, today)
{
	if (today == null) { today = false}	;
	
	 
	  $.each(data, function(index)
	  {			
	  			
			  	if (type == 'hour')
		  		{
		  			var label = checkfornodata(this.kWh, 'Wh');
		  			// if today, only show hours up until now()
		  			if (today)
		  			{
		  				var d = new Date();
						var n = d.getHours();
						n = n + 2;  // for MST to EST offset
		  				
		  			}
		  			else
		  			{
		  				n = 20;
		  			}
		  			
		  			if (this.hour > 5 && this.hour < 21 && this.hour < n +1 )
				  	{
				  		
				  		var l1 = '<td>' + this.kWh + '</td>';
						var l2 = '<td>' + label + '</td>'; 
						var date =  '<td>' + intervalfrom24(this.hour) + '</td>'; 
						//var xlabel =  '<th>' + this.localhour + ' hour</th>'; 
						$('tbody.data > tr:first').append(l1);

						$('tbody.line1 > tr:first').append(l2);
						$('tbody.line2 > tr:first').append(date);
						
						
				  	}	


		  		}
		  		else
		  		{
		  			var label = checkfornodata(this.kwh, 'kWh');
		  			var l1 = '<td>' + this.kwh + '</td>';
					var l2 = '<td>' + label+ '</td>'; 
					var date =  '<td>' + this.date + '</td>'; 
					//var xlabel =  '<th>' + this.localhour + ' hour</th>'; 
					$('tbody.data > tr:first').append(l1);

					$('tbody.line1 > tr:first').append(l2);
					$('tbody.line2 > tr:first').append(date);
					var xlabel =  '<th>' + this.date + '</th>'; 
					$('#d1 > tfoot > tr:first').append(xlabel);
		  		}
			  
			 
			  	
			  });
 	
  	
}



function grabAndFillBattery(data, type, today)
{
	
	if (today == null) { today = false}	;
	 
	  $.each(data, function(index)
			  {
			  		var label = checkfornodata(this.batt_v, 'Volts');
			  		if (type == 'hour')
			  		{
				  		// if today, only show hours up until now()
			  			if (today)
			  			{
			  				var d = new Date();
							var n = d.getHours();
							n = n + 2;  // for MST to EST offset
			  				
			  			}
			  			else
			  			{
			  				n = 20;
			  			}
			  			
			  			if (this.hour > 5 && this.hour < 21 && this.hour < n +1 )
					  	{	
						  		var l1 = '<td>' + this.batt_v + '</td>';
								var l2 = '<td>' + label + '</td>'; 
								var date =  '<td>' + intervalfrom24(this.hour) + '</td>'; 
								//var xlabel =  '<th>' + this.localhour + ' hour</th>'; 
								$('tbody.data > tr:first').append(l1);

								$('tbody.line1 > tr:first').append(l2);
								$('tbody.line2 > tr:first').append(date);
								
							
					  	}	


			  		}
			  		else
			  		{
			  			var l1 = '<td>' + this.batt_v+ '</td>';
						var l2 = '<td>' + label + '</td>'; 
						var date =  '<td>' + this.date + '</td>'; 
						
						$('tbody.data > tr:first').append(l1);

						$('tbody.line1 > tr:first').append(l2);
						$('tbody.line2 > tr:first').append(date);
						var xlabel =  '<th>' + this.date + '</th>'; 
						$('#d1 > tfoot > tr:first').append(xlabel);
			  		}
			  		
				
			  	
			  });
 	
  	
}
function grabAndFillAmps(data, type, today)
{
	if (today == null) { today = false}	;
	
	 
	  $.each(data, function(index)
			  {
			  		var label = checkfornodata(this.out_current, 'Amps');
			  		var d2label = checkfornodata(this.batt_v, 'Volts');
			  		if (type == 'hour')
			  		{
			  				// if today, only show hours up until now()
			  			if (today)
			  			{
			  				var d = new Date();
							var n = d.getHours();
							n = n + 2;  // for MST to EST offset
			  				
			  			}
			  			else
			  			{
			  				n = 20;
			  			}
			  			
			  			if (this.hour > 5 && this.hour < 21 && this.hour < n +1 )
					  	{
					  		
					  		var l1 = '<td>' + this.out_current + '</td>';
							var l2 = '<td>' + label + '</td>'; 
							var date =  '<td>' + intervalfrom24(this.hour) + '</td>'; 
							
							// second chart data
							var d2l1 = '<td>' + this.batt_v + '</td>';
							var d2l2 = '<td>' + d2label + '</td>'; 

							$('tbody.data > tr:first').append(l1);

							$('tbody.line1 > tr:first').append(l2);
							$('tbody.line2 > tr:first').append(date);
							
							// second chart data
							$('table#d2 > tbody.data > tr:first').append(d2l1);
							$('table#d2 > tbody.line1 > tr:first').append(d2l2);
							$('table#d2 > tbody.line2 > tr:first').append(date);
							
					  	}	


			  		}
			  		else
			  		{
			  		var l1 = '<td>' + this.out_current+ '</td>';
					var l2 = '<td>' + label + '</td>'; 
					var date =  '<td>' + this.date + '</td>'; 

					// second chart data
					var d2l1 = '<td>' + this.batt_v+ '</td>';
					var d2l2 = '<td>' + d2label + '</td>'; 
					
					$('tbody.data > tr:first').append(l1);

					$('tbody.line1 > tr:first').append(l2);
					$('tbody.line2 > tr:first').append(date);
					var xlabel =  '<th>' + this.date + '</th>'; 
					$('#d1 > tfoot > tr:first').append(xlabel);

					// second chart data
			  		$('table#d2 > tbody.data > tr:first').append(d2l1);
					$('table#d2 > tbody.line1 > tr:first').append(d2l2);
					$('table#d2 > tbody.line2 > tr:first').append(date);
					$('table#d2 > tfoot > tr:first').append(xlabel);
			  			
			  		}
			  	

			  		
				
			  	
			  });
 	
  	
}
function grabAndFillPV(data, type, today)
{
	if (today == null) { today = false}	;
	
	 
	  $.each(data, function(index)
			  {
			  		var label = checkfornodata(this.in_current, 'Amps');
			  		var d2label = checkfornodata(this.in_voltage, 'Volts');
			  		if (type == 'hour')
			  		{
			  				// if today, only show hours up until now()
			  			if (today)
			  			{
			  				var d = new Date();
							var n = d.getHours();
							n = n + 2;  // for MST to EST offset
			  				
			  			}
			  			else
			  			{
			  				n = 20;
			  			}
			  			
			  			if (this.hour > 5 && this.hour < 21 && this.hour < n +1 )
					  	{
					  		
					  		var l1 = '<td>' + this.in_current + '</td>';
							var l2 = '<td>' + label + '</td>'; 
							var date =  '<td>' + intervalfrom24(this.hour) + '</td>'; 
							
							// second chart data
							var d2l1 = '<td>' + this.in_voltage + '</td>';
							var d2l2 = '<td>' + d2label + '</td>'; 

							$('table#d1 > tbody.data > tr:first').append(l1);

							$('table#d1 > tbody.line1 > tr:first').append(l2);
							$('table#d1 > tbody.line2 > tr:first').append(date);

							// second chart data
							$('table#d2 > tbody.data > tr:first').append(d2l1);
							$('table#d2 > tbody.line1 > tr:first').append(d2l2);
							$('table#d2 > tbody.line2 > tr:first').append(date);
							
							
					  	}	


			  		}
			  		else
			  		{
			  		var l1 = '<td>' + this.in_current+ '</td>';
					var l2 = '<td>' + label + '</td>'; 
					var date =  '<td>' + this.date + '</td>'; 
					var xlabel =  '<th>' + this.date + '</th>'; 

					// second chart data
					var d2l1 = '<td>' + this.in_voltage + '</td>';
					var d2l2 = '<td>' + d2label + '</td>'; 
					
					
					$('table#d1 > tbody.data > tr:first').append(l1);

					$('table#d1 > tbody.line1 > tr:first').append(l2);
					$('table#d1 > tbody.line2 > tr:first').append(date);
					
					$('table#d1 > tfoot > tr:first').append(xlabel);

					// second chart data
			  		$('table#d2 > tbody.data > tr:first').append(d2l1);
					$('table#d2 > tbody.line1 > tr:first').append(d2l2);
					$('table#d2 > tbody.line2 > tr:first').append(date);
					$('table#d2 > tfoot > tr:first').append(xlabel);
			  		}
			  	

			  		
				
			  	
			  });
 	
  	
}
function getXLabels(type)
{
	var labelarray = [];
	switch(type)
	{
		case 'day':
		labelarray = ['6', '7', '8', '9', '10', '11', 'noon', '1', '2', '3', '4', '5', '6', '7', '8'];
		
		break;
	}
	return labelarray;
	

}

 function buildBigChart(type, period, linecount)
 {
 	
 	

	//  draw our own x labels if we need to 
	la = getXLabels(period);
	for (i=0; i < la.length; i++)
	{
		var xlabel =  '<th>' + la[i] + '</th>'; 
		$('#d1 > tfoot > tr:first').append(xlabel);
		if (linecount > 0)
		{
			$('#d2 > tfoot > tr:first').append(xlabel);
		}
		
	}
	
	switch(period)
	{
		case 'day':
		my_x_label_step = 2;
		my_y_labels_count = 4;
		break;

		case 'week':
		my_x_label_step = 2;
		my_y_labels_count = 4;
		break;

		case 'month':
		my_x_label_step = 7;
		my_y_labels_count = 4;

		case 'year':
		my_x_label_step = 1;
		my_y_labels_count = 4;

		case 'inception':
		my_x_label_step = 12;
		my_y_labels_count = 4;
		break;

		default:
		my_x_label_step = 7;
		my_y_labels_count = 4;
		break;

	}

  	
	

	// draw legend
	
 	paper.rect(420, 17, 7, 7).attr({'fill': '#39536E', 'fill-opacity': 100, 'stroke': '#39536E'});
	paper.text(450, 21, type).attr({'fill': '#777777', font: "12px ITC Franklin Gothic, Helvetica, Arial" });
	// draw Y-axis units
	paper.text(50, 20, type).attr({'fill': '#45535b', font: "12px Helvetica, Arial" });
	
	if (linecount == null)
	{
		mousecoord = 'rect';
	}
	else
	{
		mousecoord = 'circle';
	}

	// setup chart
	var opts = {
        data_holder: "d1", // table element holding the data to display
        width: 590,
        height: 340,
        // chart gutter dimension
        gutter: {
            top: 40,
            right: 0,
            bottom: 50,
            left: 35
    },
    // whether to fill the area below the line
    show_area: false,
    // way to capture mouse events
    mouse_coords: mousecoord,
    // whether to display background grid
    no_grid: false,
    // X axis: either false or a step integer
    x_labels_step: my_x_label_step,
    // Y axis: either false or a labels count
    y_labels_count: my_y_labels_count,
    // animation (on data source change) settings
    animation: {
        speed: 600,
        easing: "backOut"
    },
    // color settings
    colors: {
        master: "#39536E",
        line1: "#ffffff",
        line2: "#ffffff",
    },
    // text style settings
    text: {
        axis_labels: {
            font: "12px Helvetica, Arial",
            fill: "#45535B"
        },
        popup_line1: {
            font: "bold 11px Helvetica, Arial",
            fill: "#ffffff"
        },
        popup_line2: {
            font: "bold 11px Helvetica, Arial",
            fill: "#ffffff"
        }
    }
};

paper.lineChart(opts); // draw the line chart in an initiated Raphael object


} // end bigchart

// draw2
function addlinetochart(dataholder, yaxislabel, lineunits)  
{
// draw legend color box
 	paper.rect(480, 17, 7, 7).attr({'fill': '#90d2df', 'fill-opacity': 100, 'stroke': '#90d2df'});
	paper.text(510, 21, lineunits).attr({'fill': '#777777', font: "12px ITC Franklin Gothic, Helvetica, Arial" });
	// draw Y-axis units
	paper.text(595, 20, yaxislabel).attr({'fill': '#45535b', font: "12px Helvetica, Arial" });
		// setup chart2
		var opts2 = {
	        data_holder: "d2", // table element holding the data to display
	        width: 590,
	        height: 340,
	        // chart gutter dimension
	        gutter: {
	            top: 40,
	            right: 0,
	            bottom: 50,
	            left: 35
	    },
	    // whether to fill the area below the line
	    show_area: false,
	    // way to capture mouse events
	    mouse_coords: "circle",
	    // whether to display background grid
	    no_grid: true,
	    // X axis: either false or a step integer
	    x_labels_step: false,
	    // Y axis: either false or a labels count
	    y_labels_count: my_y_labels_count,
	    y_label_side: 'r',
	    // animation (on data source change) settings
	    animation: {
	        speed: 600,
	        easing: "backOut"
	    },
	    // color settings
	    colors: {
	        master: "#90d2df",
	        line1: "#ffffff",
        	line2: "#ffffff",
	    },
	    // text style settings
	    text: {
	        axis_labels: {
	            font: "12px Helvetica, Arial",
	            fill: "#45535B"
	        },
	        popup_line1: {
	            font: "bold 11px Helvetica, Arial",
	            fill: "#b2b7a0"
	        },
	        popup_line2: {
	            font: "bold 11px Helvetica, Arial",
	            fill: "#ffffff"
	        }
	    }
	};
	paper.lineChart(opts2); 

}

function create_energy_gen_bar()
{
	var curkwh = $('#energy-generation').find('p').children('span').first().text();
	curkwh = curkwh.split('W')[0];
	curkwh = Math.round((curkwh/2400)*100);

	maxkwh = $('#energy-generation').find('p').children('span').eq(1).text();
	maxkwh = maxkwh.split('W')[0];
	maxkwh = Math.round((maxkwh/2400)*100);

	var l = curkwh+ maxkwh;
	var w = 100 - curkwh - maxkwh;
	$('.bar1').css({width: curkwh + '%'});
	$('.bar2').css({left: curkwh + '%', width: maxkwh + '%'});
	$('.bar3').css({left: l + '%', width: w + '%'});

}
function create_battery_SOC_bar()
{
	var curSOC = $('#battery-history').find('p').first().text();
	curSOC = curSOC.split('%')[0];
	
	var w = 100 - curSOC;
	$('.bar1').css({width: curSOC + '%'});
	$('.bar3').css({left: curSOC + '%', width: w + '%'});

}
function graph_laptops()
{
	var laptops = $('span.count').text();
	laptops = Math.round((laptops/400)*10);
	laptops = laptops*10;
	$('#laptop-graphic-wrapper').children('img').addClass('percent-' + laptops);
}

/*
function kwh_hour_success(data)
{
	   // setup x and y arrays
	

			  $.each(data, function(index)
			  {
			  	if (this.localhour > 5 && this.localhour < 21)
			  	{
			  		xarray.push(this.localhour);
			  		yarray.push(this.kwh);
			  	}	
			  	
			  });
			  
}
function kwh_day_success(data)
{
	   // setup x and y arrays
	

			  $.each(data, function(index)
			  {
			  	
			  		xarray.push(this.date);
			  		yarray.push(this.kwh);
			  	
			  	
			  });
			  
}
function kwh_month_success(data)
{
	   // setup x and y arrays
	

			  $.each(data, function(index)
			  {
			  	
			  		xarray.push(this.date);
			  		yarray.push(this.kwh);
			  	
			  	
			  });
			  
}
function battery_hour_success(data)
{
	   // setup x and y arrays
	

			    $.each(data, function(index)
			  {
			  	if (this.localhour > 5 && this.localhour < 21)
			  	{
			  		xarray.push(this.localhour);
			  		yarray.push(this.b_voltage);
			  	}	
			  	
			  });
			  
}
function battery_day_success(data)
{
	   // setup x and y arrays
	

			    $.each(data, function(index)
			  {
			  	
			  		xarray.push(this.date);
			  		yarray.push(this.avg_batt_v);
			
			  	
			  });
			  
}
function battery_month_success(data)
{
	   // setup x and y arrays
	

			    $.each(data, function(index)
			  {
			 
			  		xarray.push(this.date);
			  		yarray.push(this.avg_batt_v);
			
			  	
			  });
			  
}
*/

/*
function grabAndFillDayBattery(data)
{
	//populate x and y arrays
	
	 
	  $.each(data, function(index)
			  {

			  	

			  	if (this.hour > 5 && this.hour < 21)
			  	{
			  		
			  		

			  		var l1 = '<td>' + this.batt_v + '</td>';
					var l2 = '<td>' + this.batt_v + ' Volts</td>'; 
					var date =  '<td>' + intervalfrom24(this.hour) + '</td>'; 
					//var xlabel =  '<th>' + this.localhour + ' hour</th>'; 
					$('tbody.data > tr:first').append(l1);

					$('tbody.line1 > tr:first').append(l2);
					$('tbody.line2 > tr:first').append(date);
					
					
			  	}	
			 
			  	
			  });
 	
  	
}
function grabAndFillWeekKwh(data)
{
	//populate x and y arrays
	
	 
	  $.each(data, function(index)
			  {

			  		

			  		var l1 = '<td>' + this.kwh + '</td>';
					var l2 = '<td>' + this.kwh + ' kWh</td>'; 
					var date =  '<td>' + this.date + '</td>'; 
					//var xlabel =  '<th>' + this.localhour + ' hour</th>'; 
					$('tbody.data > tr:first').append(l1);

					$('tbody.line1 > tr:first').append(l2);
					$('tbody.line2 > tr:first').append(date);
					var xlabel =  '<th>' + this.date + '</th>'; 
					$('#d1 > tfoot > tr:first').append(xlabel);
				
			  	
			  });
 	
  	
}
function grabAndFillMonthKwh(data)
{
	//populate x and y arrays
	
	 
	  $.each(data, function(index)
			  {

			  		

			  		var l1 = '<td>' + this.kwh + '</td>';
					var l2 = '<td>' + this.kwh + ' kWh</td>'; 
					var date =  '<td>' + this.date + '</td>'; 
					//var xlabel =  '<th>' + this.localhour + ' hour</th>'; 
					$('tbody.data > tr:first').append(l1);

					$('tbody.line1 > tr:first').append(l2);
					$('tbody.line2 > tr:first').append(date);

					var xlabel =  '<th>' + this.date + '</th>'; 
					$('#d1 > tfoot > tr:first').append(xlabel);
				
			  	
			  });
 	
  	
}
*/


