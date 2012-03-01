jQuery(document).ready(function($) {
	'use strict';
	$("#slider").nivoSlider({
		effect: radioL10n.nivo_effect,
		slices: 15,
		boxCols: 8,
		boxRows: 4,
		animSpeed: 500,
		pauseTime: radioL10n.nivo_speed,
		startSlide: 0,
		directionNav: true,
		directionNavHide: true,
		controlNav: true,
		controlNavThumbs: true,
		controlNavThumbsFromRel: false,
		controlNavThumbsSearch: '.jpg',
		controlNavThumbsReplace: '_thumb.jpg',
		keyboardNav: true,
		pauseOnHover: true,
		manualAdvance: false,
		captionOpacity: 0.8,
		prevText: 'Prev',
		nextText: 'Next',
		randomStart: false,
		beforeChange: function(){},
		afterChange: function(){},
		slideshowEnd: function(){},
		lastSlide: function(){},
		afterLoad: function(){} 
	});
});
jQuery(document).ready(function($) {
	$(window).load(function(){

		// Fade in images so there isn't a color "pop" document load and then on window load
		$(".wp-post-image").fadeIn(500);

		// clone image
		$('.wp-post-image').each(function(){
			var el = $(this);
			el.css({"position":"absolute"}).wrap("<div class='img_wrapper' style='display: inline-block'>").clone().addClass('img_grayscale').css({"position":"absolute","z-index":"998","opacity":"0"}).insertBefore(el).queue(function(){
				var el = $(this);
				el.parent().css({"width":this.width,"height":this.height});
				el.dequeue();
			});
			this.src = grayscale(this.src);
		});

		// Fade image 
		$('.wp-post-image').mouseover(function(){
			$(this).parent().find('img:first').stop().animate({opacity:1}, 500);
		})
		$('.img_grayscale').mouseout(function(){
			$(this).stop().animate({opacity:0}, 500);
		});
	});

	// Grayscale w canvas method
	function grayscale(src){
		var canvas = document.createElement('canvas');
		var ctx = canvas.getContext('2d');
		var imgObj = new Image();
		imgObj.src = src;
		canvas.width = imgObj.width;
		canvas.height = imgObj.height; 
		ctx.drawImage(imgObj, 0, 0); 
		var imgPixels = ctx.getImageData(0, 0, canvas.width, canvas.height);
		for(var y = 0; y < imgPixels.height; y++){
			for(var x = 0; x < imgPixels.width; x++){
				var i = (y * 4) * imgPixels.width + x * 4;
				var avg = (imgPixels.data[i] + imgPixels.data[i + 1] + imgPixels.data[i + 2]) / 3;
				imgPixels.data[i] = avg; 
				imgPixels.data[i + 1] = avg; 
				imgPixels.data[i + 2] = avg;
			}
		}
		ctx.putImageData(imgPixels, 0, 0, 0, 0, imgPixels.width, imgPixels.height);
		return canvas.toDataURL();
	}
});