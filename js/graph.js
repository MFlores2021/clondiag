function draw(file,vwidth) {

	var margin = {top: 40, right: 10, bottom: 80, left: 40},
		width = vwidth - margin.left - margin.right,
		height = 250 - margin.top - margin.bottom;

	//var x = d3.scaleOrdinal([0, width], .1);
	var x = d3.scaleBand()
          .range([0, width])
          .padding(0.1);

	var y = d3.scaleLinear()
		.range([height, 0]);

	var xAxis = d3.axisBottom(x); 

	var yAxis = d3.axisLeft(y);

	var svg = d3.select("body").append("svg")
		.attr("width", width + margin.left + margin.right)
		.attr("height", 2*height + margin.top + margin.bottom)
	  .append("g")
		.attr("transform", "translate(" + margin.left + "," + margin.top + ")");

	var svg1 = d3.select("body").append("svg")
		.attr("width", width + margin.left + margin.right )
		.attr("height", height + margin.top*2 + margin.bottom)
	  .append("g")
		.attr("transform", "translate(" + margin.left + "," + (margin.top -height/4 ) + ")");


	d3.csv(file, type, function(error, data) {
		data.sort(function(a, b) { return a.sort - b.sort; });
	  x.domain(data.map(function(d) { return d.virus; }));
	  y.domain([0, d3.max(data, function(d) { return d.int; })]);

	var tip = d3.tip().attr('class', 'd3-tip').offset([-height, 0]).direction('s');

	  svg.call(tip);

	svg.append("text")
      .attr("class", "title")
      .attr("x", width/2)
      .attr("y", 0 - (margin.top / 3))
      .attr("text-anchor", "middle")
      .text("Viruses contamination");

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
		  .attr("width", x.bandwidth())
		  .attr("y", function(d) { return y(d.int); })
		  .attr("height", function(d) { return height - y(d.int); })
		  .attr("fill", function(d) { 
		  	 if (d.Colour =="lightgray" && d.int> d.valor){ return "steelblue";}
			 else  return d.Colour; 
			})
		  .on("click", filterbar)
		  .on('mouseover', function(d) {
                tip
                    .html(function() {
                        return "<strong>int:</strong> <span style='color:red'>" + parseFloat(d.int).toFixed(3) + "</span>";
                      }).offset([ y(d.int)-height-50, 0])
                    .show()
                ;
              })
		  .on('mouseout', tip.hide);

	 svg.selectAll(".line")
		.data(data)
		.enter().append("line")
		.attr("class", "line")
		.attr("x1", 0)
		.attr("y1", function(d) { return y(d.valor); })
		.attr("x2", function(d) { return x(d.virus)+50; })
		.attr("y2", function(d) { return y(d.valor); })
		.style("stroke", "black")
		.style("stroke-width", 1);
		
	});


function filterbar(e){    

	var sname = d3.select(this)._groups[0][0].__data__.virus;
	var file2 = file.replace("splot", "cplot");

	d3.csv(file2, type, function(error, data) {
		data.sort(function(a, b) { return a.sort - b.sort; });

	var data = data.filter(function(d) {
	var lname = d.virus .split("#",1);
						return  lname == sname });  

	var tip = d3.tip().attr('class', 'd3-tip').offset([-height, 0]).direction('s');

	svg.call(tip);

	  x.domain(data.map(function(d) { return  d.virus; }));
	  y.domain([0, d3.max(data, function(d) { return d.int; })]);

	  svg1.selectAll("*").remove();
	  
	 svg1.append("text")
      .attr("class", "title")
      .attr("x", width/2)
      .attr("y", -1 )
      .attr("text-anchor", "middle")
      .text("Virus detail");

	  svg1.append("g")
		.attr("class", "x axis")
		.attr("transform", "translate(0," + height + ")")
		.call(xAxis)
	  .selectAll("text")
		.attr("y", 0)
		.attr("x", 9)
		.attr("dy", ".35em")
		.attr("transform", "rotate(90)")
		.style("text-anchor", "start");

	  svg1.append("g")
		  .attr("class", "y axis")
		  .call(yAxis)
		.append("text")
		  .attr("y", -9)
		  .attr("dy", ".71em")
		  .style("text-anchor", "end")
		  .text("Intensity");

	  svg1.selectAll(".rect")
		  .data(data)
		  .enter().append("rect")
		  .attr("class", "bar")
		  .attr("x", function(d) { return x(d.virus); })
		  .attr("width", x.bandwidth())
		  .attr("y", function(d) { return y(d.int); })
		  .attr("height", function(d) { return height - y(d.int); })
		  .attr("fill", function(d) { 
		  	 if (d.int> d.valor){ return "steelblue";}
			 else  return "lightgray"; 
			});

	 svg1.selectAll(".line")
		.data(data)
		.enter().append("line")
		.attr("id", "linex")
		.attr("class", "line")
		.attr("x1", 0)
		.attr("y1", function(d) { return y(d.valor); })
		.attr("x2", function(d) { return x(d.virus)+x(d.virus)/2; })
		.attr("y2", function(d) { return y(d.valor); })
		.style("stroke", "black")
		.style("stroke-width", 1);
		
	});
}
	function type(d) {
	  d.int = +d.int;
	  return d;
	}
}