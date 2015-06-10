	function loadImage(width,height){
			var src = document.getElementById("bee").src,
				angle = 0;
			document.getElementById("holder").innerHTML = "";
			
			var R = Raphael("holder", width, $(window).width()+50);
			R.circle(320, 240, 50).attr({fill: "#fff", "fill-opacity": .5, "stroke-width": 0});
			if (height>width) {
				size = height/width;	
				marginw =10+(height-width)/10; //height/8;	
				marginh =50;
			} else{
				size = 1.25;
				marginw =10;	
				marginh =50+(width-height)/8; //width/2;
							
			}
				marbut1=$(window).width()*1/3-40;	
				marbut2=$(window).width()*2/3-40;
			var img = R.image(src, marginw,marginh,  width/size, height/size);
			var butt1 = R.set(),
				butt2 = R.set();
			butt1.push(R.circle(24.833, 26.917, 26.667).attr({stroke: "#ccc", fill: "#fff", "fill-opacity": .4, "stroke-width": 2}),
					   R.path("M12.582,9.551C3.251,16.237,0.921,29.021,7.08,38.564l-2.36,1.689l4.893,2.262l4.893,2.262l-0.568-5.36l-0.567-5.359l-2.365,1.694c-4.657-7.375-2.83-17.185,4.352-22.33c7.451-5.338,17.817-3.625,23.156,3.824c5.337,7.449,3.625,17.813-3.821,23.152l2.857,3.988c9.617-6.893,11.827-20.277,4.935-29.896C35.591,4.87,22.204,2.658,12.582,9.551z").attr({stroke: "none", fill: "#000"}),
					   R.circle(24.833, 26.917, 26.667).attr({fill: "#fff", opacity: 0}));
			butt2.push(R.circle(24.833, 26.917, 26.667).attr({stroke: "#ccc", fill: "#fff", "fill-opacity": .4, "stroke-width": 2}),
					   R.path("M37.566,9.551c9.331,6.686,11.661,19.471,5.502,29.014l2.36,1.689l-4.893,2.262l-4.893,2.262l0.568-5.36l0.567-5.359l2.365,1.694c4.657-7.375,2.83-17.185-4.352-22.33c-7.451-5.338-17.817-3.625-23.156,3.824C6.3,24.695,8.012,35.06,15.458,40.398l-2.857,3.988C2.983,37.494,0.773,24.109,7.666,14.49C14.558,4.87,27.944,2.658,37.566,9.551z").attr({stroke: "none", fill: "#000"}),
					   R.circle(24.833, 26.917, 26.667).attr({fill: "#fff", opacity: 0}));
			butt1.translate(marbut1, 0);
			butt2.translate(marbut2, 0);
			butt1[2].click(function () {
				angle -= Number(document.getElementById("angle1").value);
				img.stop().animate({transform: "r" + angle}, 1000, "<>");	
				document.getElementById("angle").value=angle; 
				
			}).mouseover(function () {
				butt1[1].animate({fill: "#fc0"}, 300);
			}).mouseout(function () {
				butt1[1].stop().attr({fill: "#000"});
			});
			butt2[2].click(function () {
				angle += Number(document.getElementById("angle1").value);
				img.animate({transform: "r" + angle}, 1000, "<>");	document.getElementById("angle").value=angle;
			}).mouseover(function () {
				butt2[1].animate({fill: "#fc0"}, 300);
			}).mouseout(function () {
				butt2[1].stop().attr({fill: "#000"});
			});
			
		};