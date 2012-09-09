    
    <script type="text/javascript" src="http://mbostock.github.com/d3/d3.js?2.1.3"></script>
    <script type="text/javascript" src="http://mbostock.github.com/d3/d3.geom.js?2.1.3"></script>
    <script type="text/javascript" src="http://mbostock.github.com/d3/d3.layout.js?2.1.3"></script>
    <center>
	<?php echo "<h1>".$title."</h1>"?>
 
  <body>
    <script type="text/javascript">
	
	var h = 400;
	var w = 1100;
	
	var top_margin = 10;
	var bottom_margin = 30;
	var left_margin = 100;
	var right_margin = 50;
	
	var chart_left = left_margin;
	var chart_right = w - right_margin;
	var chart_top = top_margin;
	var chart_bottom = h - bottom_margin;
	
	var num_ticks = 10;
	var data_max = <?php echo json_encode($max); ?>;
	var dates= <?php echo json_encode($dates); ?>;
	var days = dates.length;
	var alljobs= <?php echo json_encode($alljobs); ?>;
	//var values = [ 858,1235,4321,234,532,2345,321,1367,4321,4219,3521,2876,2149,1400,2700,3780,1452,1673,1682];
	var colors=["red","blue","green","grey","fuchsia","purple","orange","yellow","palegreen","cyan"];
	//declare the svg
	 var vis = d3.select("body")
        .append("svg:svg")
            .attr("width", w)
            .attr("height", h);

	// draw axes
	//horizontal
	vis.append("svg:line")
		.attr("x1" , chart_left)
		.attr("y1" , chart_bottom)
		.attr("x2" , chart_right)
		.attr("y2" , chart_bottom)
		.attr("stroke" , "black");
	//vertical
	vis.append("svg:line")
		.attr("x1" , chart_left)
		.attr("y1" , chart_top)
		.attr("x2" , chart_left)
		.attr("y2" , chart_bottom)
		.attr("stroke" , "black");
		
	
	var y = d3.scale.linear()
        .domain([data_max, 0])
        .range([0, chart_bottom-chart_top ]);
	//document.write(y(4400));
		
	// Vertical Tick Marks	
	var vrules = vis.selectAll("g.rule")
        .data(y.ticks(num_ticks))
    .enter()
        .append("svg:g");
        
    vrules.append("svg:line")
        .attr("x1" , chart_left-4)
		.attr("y1" , function(d){return chart_top+y(d)})
		.attr("x2" , chart_left+4)
		.attr("y2" , function(d){return chart_top+y(d)})
		.attr("stroke" , "black");
	vrules.append("svg:text")
        .attr("class", "vtick_label")
        .attr("text-anchor", "end")
        .attr("x", chart_left - 10)
		.attr("y" , function(d){return chart_top+y(d)})
        .text(function(d){return d;});
	
	var bbox = vis.selectAll(".vtick_label").node().getBBox();
    vis.selectAll(".vtick_label")
    .attr("transform", function(d)
            {
            return "translate(0," + (bbox.height)/4 + ")";
            });
	
	
	//Horizontal Tick Marks
	var i = 0;
	for(i = 0; i < days;i++){
		vis.append("svg:line")
		.attr("x1" , chart_left+i*((chart_right-chart_left)/(days-1)))
		.attr("y1" , chart_bottom-4)
		.attr("x2" , chart_left+i*((chart_right-chart_left)/(days-1)))
		.attr("y2" , chart_bottom+4)
		.attr("stroke" , "black");
		vrules.append("svg:text")
        .attr("class", "htick_label")
        .attr("text-anchor", "middle")
        .attr("x", chart_left+i*((chart_right-chart_left)/(days-1)))
		.attr("y" , chart_bottom+25)
		.attr("font-size","12")
		.attr("font-style","normal")
        .text(dates[i]);
	}
	var index= 0;
	for(index=0;index<alljobs.length;index++){
	i=0;
	var values= alljobs[index].values;
	var stringpath = "";
	for (i=0;i<values.length;i++){
		if (i == 0){
			stringpath += "M "+ (chart_left+i*((chart_right-chart_left)/(days-1)))+" "+(chart_top + y(values[i]));
		}
		else{
			stringpath += " L "+ (chart_left+i*((chart_right-chart_left)/(days-1)))+" "+(chart_top + y(values[i]));
		}
		if(i == values.length - 1){
		vis.append("svg:text")
        .attr("class", "job_label")
        .attr("text-anchor", "start")
        .attr("x", 15+chart_left+i*((chart_right-chart_left)/(days-1)))
		.attr("y" , chart_top + y(values[i]))
        .text(alljobs[index].jobid);
		}
	}
	
	vis.append("svg:path")
	.style("fill", "none")
	.style("stroke", colors[(index%10)])
	.style("stroke-width", 2)
	.attr("d", stringpath);
	}
	
	
	
	var bbox = vis.selectAll(".job_label").node().getBBox();
    vis.selectAll(".job_label")
    .attr("transform", function(d)
            {
            return "translate(0," + (bbox.height)/4 + ")";
            });
	
	
	
	</script>
  </body>
</html>