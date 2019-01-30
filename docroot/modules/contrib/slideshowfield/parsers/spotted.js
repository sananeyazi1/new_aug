Drupal.slideshowfield = {
    parse:function(url){
        xmlhttp=new XMLHttpRequest();
        xmlhttp.open("GET",url,false);
        xmlhttp.send();
        xmlDoc=xmlhttp.responseXML;
        console.log(xmlDoc);
    }
};
