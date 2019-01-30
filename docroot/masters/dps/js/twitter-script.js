var tweetUsers = ['aug_masters'];
var buildString = "";

$(document).ready(function(){
	for(var i=0;i<tweetUsers.length;i++)
	{
		if(i!=0) buildString+='+OR+';
		buildString+='from:'+tweetUsers[i];
	}
	
	var fileref = document.createElement('script');
	
	fileref.setAttribute("type","text/javascript");
	fileref.setAttribute("src", "http://search.twitter.com/search.json?q="+buildString+"&callback=TweetTick&rpp=4");
	
	document.getElementsByTagName("head")[0].appendChild(fileref);
});

function TweetTick(ob)
{
	var container=$('#tweet-container');
	container.html='';
	$(ob.results).each(function(el){
	     
		var str = '<li class="rotating-item">'+formatTwitString(this.text)+'</li>';
		container.append(str);
		
	});
	$('#tweet-container li').hide();
    InOut();
	//var interval = setInterval("InOut()", pause);
}

function formatTwitString(str)
{
	str=' '+str;
	str = str.replace(/((ftp|https?):\/\/([-\w\.]+)+(:\d+)?(\/([\w/_\.]*(\?\S+)?)?)?)/gm,'<a href="$1" target="_blank">$1</a>');
	str = str.replace(/([^\w])\@([\w\-]+)/gm,'$1@<a href="http://twitter.com/$2" target="_blank">$2</a>');
	str = str.replace(/([^\w])\#([\w\-]+)/gm,'$1<a href="http://twitter.com/search?q=%23$2" target="_blank">#$2</a>');
	return str;
}
/*function InOut( elem )
{
 var infiniteLoop = setInterval(function(){
 elem.delay()
     .fadeOut()
     .delay()
     .fadein( 
               function(){ InOut( elem.next() ); }
             );},15000);
}*/

function InOut()
{
var initialFadeIn = 1000;

			var itemInterval = 15000;

			var fadeTime = 1000;

			var numberOfItems = $('#tweet-container li').length;

			var currentItem = 0;
			$('#tweet-container li').eq(currentItem).fadeIn(initialFadeIn);
			var infiniteLoop = setInterval(function(){
			
				$('#tweet-container li').eq(currentItem).fadeOut(fadeTime);

				if(currentItem == numberOfItems -1){
					currentItem = 0;
				}else{
					currentItem++;
				}
				$('#tweet-container li').delay(1000);
				$('#tweet-container li').eq(currentItem).fadeIn(fadeTime);
			}, itemInterval);
}