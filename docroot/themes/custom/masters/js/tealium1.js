jQuery(function ($) {
    utag_data={
        gender: Drupal.settings.tealium.gender,
        zipcode: Drupal.settings.tealium.zipcode,
        birthdate: Drupal.settings.tealium.birthdate,
        msmsusername:Drupal.settings.tealium.username,
        content_type: Drupal.settings.tealium.ctype,
        taxonomy_sections: Drupal.settings.tealium.sections,
        nodeid: Drupal.settings.tealium.nid,
        author: Drupal.settings.tealium.author,
        pub_time: Drupal.settings.tealium.pubdate,
        taxonomy: Drupal.settings.tealium.significant,
    };
    (function(a,b,c,d){
        a=Drupal.settings.tealium.tealium_url;
        b=document;c='script';d=b.createElement(c);d.src=a;d.type='text/java'+c;d.async=true;
        a=b.getElementsByTagName(c)[0];a.parentNode.insertBefore(d,a);
    })();

    $(".slick-arrow").live('click',function() {
        utag.link({
            ga_event_category: "slideshow-masters",
            ga_event_action: "slide-view",
            ga_event_label: Drupal.settings.tealium.title
        });

    });
    var sliders = [".slideshow", ".story-slider", ".featured-slider", ".slideshow-slider", ".slideshow-page"];
    $.each( sliders, function( key, value ) {
        $(value).on('swipe', function(event, slick, direction){
            utag.link({
                ga_event_category: "slideshow-masters",
                ga_event_action: "slide-view",
                ga_event_label: Drupal.settings.tealium.title
            });
        });
    });
});