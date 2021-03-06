	<script type="text/javascript" src="http://mbostock.github.com/d3/d3.js?2.1.3"></script>
    <script type="text/javascript" src="http://mbostock.github.com/d3/d3.geom.js?2.1.3"></script>
    <script type="text/javascript" src="http://mbostock.github.com/d3/d3.layout.js?2.1.3"></script>
 
<center>
 <body>
  <?php 
	echo "<h1>".$title."</h1>";
  ?>

<script type="text/javascript" charset="utf-8">
var w = 900, h = 600;

var labelDistance = .5;

var vis = d3.select("body").append("svg:svg").attr("width", w).attr("height", h);
var num_nodes = <?php echo json_encode($numusers); ?>;
var nodes = <?php echo json_encode($nodes); ?>;
var labelAnchors = [];
var labelAnchorLinks = [];
var links = <?php echo json_encode($links); ?>;


for(var i = 0; i < num_nodes; i++) {

labelAnchors.push({
node : nodes[i]
});
labelAnchors.push({
node : nodes[i]
});
};

for(var i = 0; i < num_nodes; i++) {
labelAnchorLinks.push({
source : i * 2,
target : i * 2 + 1,
weight : 1
});
};

/*
for(var i =0; i<  links.length; i++){
document.write(links[i]['source']+" . ");
document.write(links[i]['target']+" . ");
document.write(links[i]['weight']);
document.write("<br>");
}
*/
var force = d3.layout.force().size([w, h]).nodes(nodes).links(links).gravity(1).linkDistance(15).charge(-130).linkStrength(function(x) {
return x.weight * 10
});


force.start();

var force2 = d3.layout.force().nodes(labelAnchors).links(labelAnchorLinks).gravity(1).linkDistance(labelDistance).linkStrength(5).charge(-2000).size([w, h]);
force2.start();

var link = vis.selectAll("line.link").data(links).enter().append("svg:line").attr("class", "link").style("stroke", "#AAA");

var node = vis.selectAll("g.node").data(force.nodes()).enter().append("svg:g").attr("class", "node");
node.append("svg:circle").attr("r", 6).style("fill", "#A99");
node.call(force.drag);

var anchorLink = vis.selectAll("line.anchorLink").data(labelAnchorLinks).enter().append("svg:line").attr("class", "anchorLink");

var anchorNode = vis.selectAll("g.anchorNode").data(force2.nodes()).enter().append("svg:g").attr("class", "anchorNode");
anchorNode.append("svg:circle").attr("r", 1).style("fill", "#FFF");

anchorNode.append("svg:text").text(function(d, i) {
return i % 2 == 0 ? "" : ""
}).style("fill", "#966");

var updateLink = function() {
this.attr("x1", function(d) {
return d.source.x;
}).attr("y1", function(d) {
return d.source.y;
}).attr("x2", function(d) {
return d.target.x;
}).attr("y2", function(d) {
return d.target.y;
});

}

var updateNode = function() {
this.attr("transform", function(d) {
return "translate(" + d.x + "," + d.y + ")";
});

}


force.on("tick", function() {

force2.start();

node.call(updateNode);

anchorNode.each(function(d, i) {
if(i % 2 == 0) {
d.x = d.node.x;
d.y = d.node.y;
} else {
var b = this.childNodes[1].getBBox();

var diffX = d.x - d.node.x;
var diffY = d.y - d.node.y;

var dist = Math.sqrt(diffX * diffX + diffY * diffY);

var shiftX = b.width * (diffX - dist) / (dist * 2);
shiftX = Math.max(-b.width, Math.min(0, shiftX));
var shiftY = 0;
this.childNodes[1].setAttribute("transform", "translate(" + shiftX + "," + shiftY + ")");
}
});


anchorNode.call(updateNode);

link.call(updateLink);
anchorLink.call(updateLink);

});

</script>
</body>
</center>

