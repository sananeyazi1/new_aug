(function($) {
	var images = new Array();
	$(document).ready(function() {
		$('.sprite').each(function() {
			var image = {
				src : $(this).attr('src'),
				image : $(this)[0]
			}
			images.push(image);
		});
	});
	
	$(window).load(function() {

		var viewportmeta = $('meta[name="viewport"]');
		viewportmeta[0].content = "width=(device-width-2), minimum-scale=1.0, maximum-scale=1.0";

		var container = $('.src-image:first');
		var containerWidth = 1023;
		var containerHeight = 767;

		$('.visuallyhidden').hide();

		var totalImages = images.length;
		var srcImage = $('.src-image:first')[0];
		
		var sprite = new Hook.Animation.SpriteSheet();
		sprite.init(srcImage, images, 30);
		
		function play() {
			sprite.setIndex(1);
			sprite.play();
		}
		
		setTimeout(play, 2000);
		
		$(".image-container").click(function() {
			play();
		});

		window.addEventListener('orientationchange', updateOrientation, false);
		window.addEventListener('resize', updateOrientation, false);
		
		var currentOrientation = -1;
		
		function updateOrientation() {
			if(getOrientation() != currentOrientation) {
				currentOrientation = getOrientation();
			}
		}

		function getOrientation() {
			var currentOrientation = 0;

			if($('html').width() > $('html').height()) {
				currentOrientation = 90;
			} else {
				currentOrientation = 0;
			}

			return currentOrientation;
		}

		updateOrientation();
		
	});

})(jQuery)

$(window).load(function() {

	var box = $('#container').find('#box');
	var buttons = $('#container').find('#buttons');

	//$('#close').hide();

	$('.popup').click(function() {
		console.log('open');
		box.animate({
			opacity : 1,
			top : 350
		}, 800, "easeOutCirc");
		//$(this).addClass('pulse');
		$('#close').show();
	}).clearQueue();

	$('#close').click(function() {
		//var pulse = $('#buttons').find('.pulse');
		//pulse.removeClass('pulse');
		console.log('close');
		box.css({
			'opacity' : '0',
			'top' : '400px'
		});
		box.clearQueue();
		//$('#close').hide();
	})

	$('#loading').hide();

});

if(!Normous)
	var Normous = {};
Normous.Log = function(m) {

	if(!Normous.getUniqueId) {
		Normous.getUniqueId = function() {
			if(Normous.uniq == undefined) {
				HNormous.uniq = 'Session' + (1000 + Math.floor(Math.random() * 100000));
			}

			return Normous.uniq;
		}
	}

	//var img = new Image();
	//var date = new Date();
	//var time = date.getTime();
	//img.src = 'http://byhook.normmcgarry.com/log.php?m=' + encodeURIComponent(m) + '&s=' + Normous.getUniqueId() + '&t=' + time;
}

