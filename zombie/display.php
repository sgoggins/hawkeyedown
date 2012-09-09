	<script type="text/javascript" src="http://mbostock.github.com/d3/d3.js?2.1.3"></script>
    <script type="text/javascript" src="http://mbostock.github.com/d3/d3.geom.js?2.1.3"></script>
    <script type="text/javascript" src="http://mbostock.github.com/d3/d3.layout.js?2.1.3"></script>
  <body>
  <?php 
	echo "<center><h1>".$title."</h1></center>";
  ?>
<script type="text/javascript">
	var data = <?php echo json_encode($rows); ?>;
		
	 //maximum of data you want to use
	var max = data[0]['counter'];
    var data_max = max*1.1;
	
	    //number of tickmarks to use
    var num_ticks = 8

    //margins
    left_margin = 200,
    right_margin = 70,
    top_margin = 20,
    bottom_margin = 10;


    var w = 1200, //width
        h = 550, //height
        color = function(id) { return '#00b3dc' };

    var x = d3.scale.linear()
        .domain([0, data_max])
        .range([0, w - ( left_margin + right_margin ) ]),
        y = d3.scale.ordinal()
        .domain(d3.range(data.length))
        .rangeBands([bottom_margin, h - top_margin]);


    var chart_top = h - top_margin;
    var chart_bottom = bottom_margin ;
    var chart_left = left_margin;
    var chart_right = w - right_margin;

    /*
* Setup the SVG element and position it
*/
    var vis = d3.select("body")
        .append("svg:svg")
            .attr("width", w)
            .attr("height", h)
        .append("svg:g")
            .attr("id", "barchart")
            .attr("class", "barchart");
	
	
	
    //Ticks
    var rules = vis.selectAll("g.rule")
        .data(x.ticks(num_ticks))
    .enter()
        .append("svg:g")
        .attr("transform", function(d)
                {
                return "translate(" + (chart_left + x(d)) + ")";});
    rules.append("svg:line")
        .attr("class", "tick")
        .attr("y1", chart_top)
        .attr("y2", chart_top + 4)
        .attr("stroke", "black");

    rules.append("svg:text")
        .attr("class", "tick_label")
        .attr("text-anchor", "middle")
        .attr("y", chart_top)
        .text(function(d)
        {
        return d;
        });
    var bbox = vis.selectAll(".tick_label").node().getBBox();
    vis.selectAll(".tick_label")
    .attr("transform", function(d)
            {
            return "translate(0," + (bbox.height) + ")";
            });
			
    var bars = vis.selectAll("g.bar")
        .data(data)
    .enter()
        .append("svg:g")
            .attr("class", "bar")
            .attr("transform", function(d, i) {
                    return "translate(0, " + y(i) + ")"; });

    bars.append("svg:rect")
        .attr("x", left_margin)
        .attr("width", function(d) {
                return (x(d.counter));
                })
        .attr("height", y.rangeBand())
        .attr("fill", color(0))
        .attr("stroke", "black");


    //Labels
	
    var labels = vis.selectAll("g.bar")
        .append("svg:text")
            .attr("class", "label")
            .attr("x", left_margin - 10)
            .attr("text-anchor", "end")
            .text(function(d) {
                    return d.name;
                    });

    var bbox = labels.node().getBBox();
    vis.selectAll(".label")
        .attr("transform", function(d) {
                return "translate(0, " + (y.rangeBand()/2 + bbox.height/4) + ")";
                });


    labels = vis.selectAll("g.bar")
        .append("svg:text")
        .attr("class", "value")
        .attr("x", function(d)
                {
                return x(d.counter) + left_margin + 10;
                })
        .attr("text-anchor", "right")
        .text(function(d)
        {
        return "" + d.counter ;
        });

    bbox = labels.node().getBBox();
    vis.selectAll(".value")
        .attr("transform", function(d)
        {
            return "translate(0, " + (y.rangeBand()/2 + bbox.height/4) + ")";
        });

    //Axes
    vis.append("svg:line")
        .attr("class", "axes")
        .attr("x1", chart_left)
        .attr("x2", chart_left)
        .attr("y1", chart_bottom)
        .attr("y2", chart_top)
        .attr("stroke", "black");
     vis.append("svg:line")
        .attr("class", "axes")
        .attr("x1", chart_left)
        .attr("x2", chart_right)
        .attr("y1", chart_top)
        .attr("y2", chart_top)
        .attr("stroke", "black");
 
    </script>
	
</body>