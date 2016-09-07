<script src="http://canvasjs.com/assets/script/canvasjs.min.js"></script>
<script type="text/javascript">

window.onload = function () {

	var consumption = {{ json_encode($smappeeConsumption) }};
	var alwaysOn = {{ json_encode($smappeeAlwaysOn) }};
	
	var chart = new CanvasJS.Chart("chartContainer", {
		title:{
			text: "Power Consumption",
			fontColor: "#999"        
		},
		backgroundColor : "#000",
		data: [              
		{
			// Change type to "doughnut", "line", "splineArea", etc.
			type: "area",
			color: "rgba(200,200,200, .5)",
			dataPoints: consumption
		},
		
		{
			type : "area",
			color: "rgba(200, 200, 200, .5)",
			dataPoints: alwaysOn
		}
		
		]
	});
	chart.render();
}
</script>
<div id="chartContainer" style="height: 300px; width: 100%;"></div>
