(function ($) {
    Drupal.behaviors.slideshowfield = {
        attach: function (context, settings) {
            var stash = "";
            var skipHashChangeEvent = false;
            // One of five slides should be an ad.
            var frequency = Drupal.settings.slideshowfield.ads.frequency;
//            lrecurl = Drupal.settings.slideshowfield.ads.basepath + '/dfp/dfp.html?size=300x250_1&mmo_ccc=latestbookingsshawneecountyjailjuly&adunit=/11365842/cjonline.com/slideshow/2015-07-03/latest-bookings-shawnee-county-jail-july-2015';

		var syncCookieValue;
    		if(jQuery.cookie('syncwall-active-subscriber') == 'true'){
        		syncCookieValue = 'y';
    		}else{
        		syncCookieValue = 'n';
    		}

            if (typeof googletag !== "undefined") {
                var ctype;
                var taxonomy;
                if (typeof  Drupal.settings.tealium != "undefined") {
                    ctype = Drupal.settings.tealium.ctype;
                } else {
                    ctype = ""
                }
                if (typeof  Drupal.settings.tealium != "undefined") {
                    taxonomy = Drupal.settings.tealium.sections;
                } else {
                    taxonomy = ""
                }
            }
            $(".slideshow>div:nth-child("+ frequency +"n)").after('<div id="300250ad" data-slick-ad="1" style="text-align:center" class="adslot clearfix ad-box"> </div>');


  var addiv = '<div id="300250ads"> </div>';

  googletag.cmd.push(function () {
                        //Adslot 1 declaration
                       googletag.defineSlot(NMTdata.ads.dfp_adunit_prefix + NMTdata.ads.dfp_adunit, [300, 250], "300250ads")
                            .addService(googletag.pubads())
                            .setTargeting("pos", ["300x250_1"])
                            .setTargeting("content_type", ctype)
                            .setTargeting("Taxonomy", taxonomy)
                            .setTargeting("pplogin", syncCookieValue)
                            .setCollapseEmptyDiv(false)
			    .setTargeting('ccaud',[nmtAuds])
                            .setTargeting("ccc", NMTdata.ads.dfp_ccc);
                        googletag.pubads().enableSingleRequest();
                        googletag.enableServices();

                    });


            $(".slideshow .adslot").each(function (index, value) {
                    value.id = '300250ad'+index;

                }
            );

            var _ = $('.slideshow');

            var doHashMagic = function () {
                if (skipHashChangeEvent) {
                    skipHashChangeEvent = false;
                    return;
                }
                hash = location.hash.replace(/^#slide-/, '');

                var noslides = $(".slick-track > div").size();
                if (!hash){
                    hash = 1;
                }
                $('.slide-number').html(hash);
                $('.slide-total').html("of " + (noslides - 2));

                if (isNumber(hash)) {
                    _.slick('slickGoTo', parseInt(hash) - 1);
                }
            };

           _.on('init', function(event, slick){
		  preLoadSlide();
		}); 

            _.slick({
                lazyLoad: 'ondemand',
                cssEase: 'linear',
                accessibility: false,
                adaptiveHeight: true,
                appendArrows: '.slideshow-title',
                prevArrow: '<button type="button" class="slick-prev slick-arrow glyph glyph-btn glyph-arrow-right"></button>',
                nextArrow: '<button type="button" class="slick-next slick-arrow glyph glyph-btn glyph-arrow-right"></button>'
            });


            _.on('afterChange', function (event, slick, currentSlide) {
                window.location.hash = '#slide-' + (currentSlide + 1).toString();
            });


_.on('swipe', function(event, slick, direction){
  
     var adid = $('.slick-active').attr('id');

         if($('.slick-active').attr('data-slick-ad') == 1)
         {

          $('#'+adid).html(addiv);

           googletag.display('300250ads');

         }
        else
        {
           $('#300250ads').remove();
        }
         googletag.pubads().refresh();
	 preLoadSlide();

});


            $(window).hashchange(function () {
                doHashMagic();
            });

            window.onpopstate = function () {
                skipHashChangeEvent = false;
                doHashMagic();
            };

      $('.node-slideshow .slick-arrow').on('click',function() {

	var adid = $('.slick-active').attr('id');

	 if($('.slick-active').attr('data-slick-ad') == 1)
	 { 

	  $('#'+adid).html(addiv);

	   googletag.display('300250ads');

	 }             
	else
	{
	   $('#300250ads').remove();
	} 
	 googletag.pubads().refresh();

	 preLoadSlide();

       });

            doHashMagic()
        }
    };

    function isNumber(n) {
        return !isNaN(parseFloat(n)) && isFinite(n);
    }

      function preLoadSlide()
       {
	 var img_src = $('.slick-active').next().find('.slide-photo img').attr('data-lazy');
	 $('.slick-active').next().find('.slide-photo img').attr('src', img_src);
         var img_src = $('.slick-active').next().next().find('.slide-photo img').attr('data-lazy');
	 $('.slick-active').next().next().find('.slide-photo img').attr('src', img_src);
       }

}(jQuery));
