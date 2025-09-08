
function makePieChart(text,data) {
    return new CanvasJS.Chart("piechart", {
        theme: "light2",
        animationEnabled: true,
        title: {
            text,
            fontSize: 18,
            fontColor: "#273B98"
        },
        data: [{
            type: "pie",
            indexLabel: "{y}",
            yValueFormatString: "#,##0.00\"%\"",
            indexLabelPlacement: "inside",
            indexLabelFontColor: "#36454F",
            indexLabelFontSize: 18,
            // indexLabelFontWeight: "bolder",
            showInLegend: true,
            legendText: "{label}",
            dataPoints: data
        }]
    });
}

function makeBarChart(text, data){
    return new CanvasJS.Chart("barchat", {
	title: {
		text,
        fontColor: "#273B98"
	},
	theme: "light1",
	animationEnabled: true,
	axisY: {
		prefix: "IDR ",
		suffix: "",
		includeZero: false,
	},
	data: [
		{
			type: "rangeColumn",
			// yValueFormatString: "$#,##0/Mwh",
			toolTipContent: "{label}<br>Sold: {y[0]}<br>Earning: {y[1]}",
			dataPoints: data
		}
	]
});
}

window.makePieChart = makePieChart;
window.makeBarChart = makeBarChart;