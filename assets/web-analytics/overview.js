function sqlToJsDate(sqlDate){
    //sqlDate in SQL DATETIME format ("yyyy-mm-dd hh:mm:ss.ms")
    var sqlDateArr1 = sqlDate.split("-");
    //format of sqlDateArr1[] = ['yyyy','mm','dd hh:mm:ms']
    var sYear = sqlDateArr1[0];
    var sMonth = (Number(sqlDateArr1[1]) - 1).toString();
    var sqlDateArr2 = sqlDateArr1[2].split(" ");
    //format of sqlDateArr2[] = ['dd', 'hh:mm:ss.ms']
    var sDay = sqlDateArr2[0];
    var sqlDateArr3 = sqlDateArr2[1].split(":");
    //format of sqlDateArr3[] = ['hh','mm','ss.ms']
    var sHour = sqlDateArr3[0];
    var sMinute = sqlDateArr3[1];
    var sqlDateArr4 = sqlDateArr3[2].split(".");
    //format of sqlDateArr4[] = ['ss','ms']
    var sSecond = sqlDateArr4[0];
    var sMillisecond = sqlDateArr4[1];
    
    return new Date(sYear,sMonth,sDay);
}

function getData(){
	var datos = [];
     $.ajax({
      url: "dashData.php",
      method: "POST",
      async: false,
      data: {'flag': 'flag'},
    }).done(function(data) {
     	for(var i = 0;i<data.length;i++){
     		datos.push({
     			'tipo': data[i].tipo,
     			'fecha': data[i].fechaRegistro,
     			'estatus': data[i].estatus
     		});
     	}
    }).fail(function( jqXHR, textStatus ) {
      debugger
      alert( "Hubo un error: " + textStatus );
    });
    return datos;
}
var datos = getData();
//1st Chart data tag
function getDate(date){
	const monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun",
  "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
	];
	var myDate = new Date(date);
	 return myDate.getDate() + ' ' +  monthNames[myDate.getMonth()] + ' ' + myDate.getFullYear();
}

$(function () {
	var totalRevenue = datos.length;
	

	// data for drilldown charts
	var dataMonthlyRevenueByCategory = {
		"Pendiente": {
			color: "#393f63",
			markerSize: 0,
			name: "Pendiente",
			type: "column",
			yValueFormatString: "###",
			dataPoints: [
		
			]
		},
		"Finalizado": {
			color: "#e5d8b0",
			markerSize: 0,
			name: "Finalizado",
			type: "column",
			yValueFormatString: "###",
			dataPoints: []
		},
		"Cancelado": {
			color: "#ffb367",
			markerSize: 0,
			name: "Cancelado",
			type: "column",
			yValueFormatString: "###",
			dataPoints: [
			]
		}
	};
	
	// data for drilldown charts
	
	// CanvasJS spline area chart to show revenue from Jan 2015 - Dec 2015
	var revenueSplineAreaChart = new CanvasJS.Chart("revenue-spline-area-chart", {
		animationEnabled: true,
		backgroundColor: "transparent",
		axisX: {
			interval: 1,
			title: "Tipo de reporte",
			labelAngle: 180,
			labelFontColor: "#717171",
			labelFontSize: 16,
			lineColor: "#a2a2a2",
			minimum: 0,
			maximum: 3,
			tickColor: "#a2a2a2",
			//valueFormatString: "MMM YYYY"
		},
		axisY: {
			title: "Cantidad",
			interval: 1,
			gridThickness: 0,
			includeZero: false,
			labelFontColor: "#717171",
			labelFontSize: 16,
			lineColor: "#a2a2a2",
			prefix: "",
			tickColor: "#a2a2a2"
		},
		toolTip: {
			borderThickness: 0,
			cornerRadius: 0,
			fontStyle: "normal"
		},
		data: [
			{
				color: "#393f63",
				markerSize: 0,
				type: "splineArea",
				yValueFormatString: "###,###.##",
				dataPoints: [
					{ label: "Bache", y: 0 },
					{ label: "Animal", y: 0 },
					{ label: "Arroyo", y: 0},
					{ label: "Fuego", y: 0 }
				]
			}
		]
	});
	
	
	// CanvasJS pie chart to show annual revenue by category
	var annualRevenueByCategoryPieChart = new CanvasJS.Chart("annual-revenue-by-category-pie-chart", {
		animationEnabled: true,
		backgroundColor: "transparent",
		legend: {
			fontFamily: "calibri",
			fontSize: 14,
			horizontalAlign: "left",
			verticalAlign: "center",
			itemTextFormatter: function (e) {
				return e.dataPoint.name + ": " + Math.round(e.dataPoint.y / totalRevenue * 100) + "%";  
			}
		},
		toolTip: {
			backgroundColor: "#ffffff",
			cornerRadius: 0,
			fontStyle: "normal",
			contentFormatter: function (e) {
				return e.entries[0].dataPoint.name + ": " + CanvasJS.formatNumber(e.entries[0].dataPoint.y, "###") + " - " + Math.round(e.entries[0].dataPoint.y / totalRevenue * 100) + "%";  
			}
		},
		data: [
			{
				click: monthlyRevenueByCategoryDrilldownHandler,
				cursor: "pointer",
				legendMarkerType: "square",
				showInLegend: true,
				startAngle: 90,
				type: "pie",
				dataPoints: [
					{ y: 0, name:"Pendiente", color: "#393f63" },
					{ y: 0, name:"Finalizado", color: "#e5d8b0" },
					{ y: 0, name:"Cancelado", color: "#ffb367" },
				]
			}
		]
	});
	
	// CanvasJS multiseries column chart to show monthly revenue by category
	var monthlyRevenueByCategoryColumnChart = new CanvasJS.Chart("monthly-revenue-by-category-column-chart", {
		animationEnabled: true,
		backgroundColor: "transparent",
		axisX: {
			interval: 2,
			intervalType: "month",
			labelFontColor: "#717171",
			lineColor: "#a2a2a2",
			tickColor: "#a2a2a2"
		},
		axisY: {
			gridThickness: 0,
			interval: 1,
			labelFontColor: "#717171",
			lineColor: "#a2a2a2",
			maximum: datos.length,
			prefix: "",
			tickColor: "#a2a2a2"
		},
		toolTip: {
			backgroundColor: "#737580",
			borderThickness: 0,
			cornerRadius: 0,
			fontColor: "#ffffff",
			fontSize: 16,
			fontStyle: "normal",
			shared: true
		},
		data: []
	});
	function updateSecondChart(chart){
		for(var i = 0;i<datos.length;i++){
			if(datos[i].estatus == 'Pendiente'){
				chart['Pendiente'].dataPoints.push({
					x: new Date(getDate(datos[i].fecha)),
					y: 1
				});
			}else if(datos[i].estatus == 'Finalizado'){
				chart['Finalizado'].dataPoints.push({
					x: new Date(getDate(datos[i].fecha)),
					y: 1
				});
			}else{
				chart['Cancelado'].dataPoints.push({
					x: new Date(getDate(datos[i].fecha)),
					y: 1
				});
			}
		}
	}
	function updateFirstChart(chart,chart2){
		for(var i = 0;i<datos.length;i++){
			if(datos[i].tipo == 'Bache'){
				chart.options.data[0].dataPoints[0].y++;
			}else if(datos[i].tipo == 'Animal'){
				chart.options.data[0].dataPoints[1].y++;
			}else if(datos[i].tipo == 'Arroyo'){
				chart.options.data[0].dataPoints[2].y++;
			}else{
				chart.options.data[0].dataPoints[3].y++;
			}

			if(datos[i].estatus=="Pendiente")
				chart2.options.data[0].dataPoints[0].y++;
			else if(datos[i].estatus=="Finalizado")
				chart2.options.data[0].dataPoints[1].y++;
			else
				chart2.options.data[0].dataPoints[2].y++;
		}
	}

	updateFirstChart(revenueSplineAreaChart,annualRevenueByCategoryPieChart);
	updateSecondChart(dataMonthlyRevenueByCategory);
	populateMonthlyRevenueByCategoryChart();
	monthlyRevenueByCategoryColumnChart.render();
	revenueSplineAreaChart.render();
	//



	
	
	//----------------------------------------------------------------------------------//
	
	
	function populateMonthlyRevenueByCategoryChart() {
		for (var prop in dataMonthlyRevenueByCategory)
			if  (dataMonthlyRevenueByCategory.hasOwnProperty(prop))
				monthlyRevenueByCategoryColumnChart.options.data.push(dataMonthlyRevenueByCategory[prop] );
	}
	
	function monthlyRevenueByCategoryDrilldownHandler(e) {
		monthlyRevenueByCategoryColumnChart.options.data = [];

		for (var i = 0; i < annualRevenueByCategoryPieChart.options.data[0].dataPoints.length; i++)
			if (annualRevenueByCategoryPieChart.options.data[0].dataPoints[i].exploded === true)
				monthlyRevenueByCategoryColumnChart.options.data.push( dataMonthlyRevenueByCategory[annualRevenueByCategoryPieChart.options.data[0].dataPoints[i].name] );

		if (monthlyRevenueByCategoryColumnChart.options.data.length === 0)
			populateMonthlyRevenueByCategoryChart();

		monthlyRevenueByCategoryColumnChart.render();
	}
	

	
	
	
	// binding click event to visitors chart back button to drill up to "New Vs Returning Visitors" doughnut chart

	
	// chart properties cutomized further based on screen width
	function chartPropertiesCustomization () {
		if ($(window).outerWidth() >= 1200 ) {
			
			annualRevenueByCategoryPieChart.options.legend.horizontalAlign = "left";
			annualRevenueByCategoryPieChart.options.legend.verticalAlign = "center";
			annualRevenueByCategoryPieChart.render();
						
		} else if ($(window).outerWidth() < 1200) {
			
			annualRevenueByCategoryPieChart.options.legend.horizontalAlign = "center";
			annualRevenueByCategoryPieChart.options.legend.verticalAlign = "top";
			annualRevenueByCategoryPieChart.render();
			
			
		}
	}

	(function init() {
		console.log(datos);
		chartPropertiesCustomization();
		$(window).resize(chartPropertiesCustomization);
	})();
	
});