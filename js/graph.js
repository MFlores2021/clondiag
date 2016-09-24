function draw(file,vwidth) {

	var margin = {top: 40, right: 10, bottom: 80, left: 40},
		width = vwidth - margin.left - margin.right,
		height = 250 - margin.top - margin.bottom;

	var x = d3.scale.ordinal()
		.rangeRoundBands([0, width], .1);

	var y = d3.scale.linear()
		.range([height, 0]);

	var xAxis = d3.svg.axis()
		.scale(x)	
		.orient("bottom");

	var yAxis = d3.svg.axis()
		.scale(y)
		.orient("left");

	var tip = d3.tip()
	  .attr('class', 'd3-tip')
	  .offset([-10, 0])
	  .html(function(d) {
		return "<strong>int:</strong> <span style='color:red'>" + d.int + "</span>";
	  })

	var svg = d3.select("body").append("svg")
		.attr("width", width + margin.left + margin.right)
		.attr("height", height + margin.top + margin.bottom)
	  .append("g")
		.attr("transform", "translate(" + margin.left + "," + margin.top + ")");

	svg.call(tip);

	d3.csv(file, type, function(error, data) {
	  x.domain(data.map(function(d) { return d.virus; }));
	  y.domain([0, d3.max(data, function(d) { return d.int; })]);

	  svg.append("g")
		.attr("class", "x axis")
		.attr("transform", "translate(0," + height + ")")
		.call(xAxis)
	  .selectAll("text")
		.attr("y", 0)
		.attr("x", 9)
		.attr("dy", ".35em")
		.attr("transform", "rotate(90)")
		.style("text-anchor", "start");

	  svg.append("g")
		  .attr("class", "y axis")
		  .call(yAxis)
		.append("text")
		  .attr("y", -9)
		  .attr("dy", ".71em")
		  .style("text-anchor", "end")
		  .text("Intensity");

	  svg.selectAll(".bar")
		  .data(data)
		.enter().append("rect")
		  .attr("class", "bar")
		  .attr("x", function(d) { return x(d.virus); })
		  .attr("width", x.rangeBand())
		  .attr("y", function(d) { return y(d.int); })
		  .attr("height", function(d) { return height - y(d.int); })
		  .attr("fill", function(d) { return d.Colour; })
		  .on('mouseover', tip.show)
		  .on('mouseout', tip.hide);
		  
	 svg.selectAll(".line")
		.data(data)
		.enter().append("line")
		.attr("class", "line")
		.attr("x1", 0)
		.attr("y1", function(d) { return y(d.valor); })
		.attr("x2", function(d) { return x(d.virus)+20; })
		.attr("y2", function(d) { return y(d.valor); })
		.style("stroke", "black")
		.style("stroke-width", 1);
		
	});

	function type(d) {
	  d.int = +d.int;
	  return d;
	}
}