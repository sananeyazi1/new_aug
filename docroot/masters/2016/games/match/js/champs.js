var allNames = ['smith1934', 'nicklaus1966', 'palmer1964', 'ballesteros1980', 'woods1997', 'player1974', 'sarazen1935', 'couples1992', 'watson1981', 'mize1987'];

var origXPos = [];
var origYPos = [];
var attempts = 0;
var correct = 0;

var captions = [];
captions[0] = "Horton Smith won the first Augusta National Invitation Tournament in 1934. Smith held at least a share of the lead each day. He was a fan of the course and tournament from the start. \"There is nothing monotonous about that course, and it is one of the most beautiful I ever played,\" Smith said. \"Each one of the holes presents something new.\"";
captions[1] = "Jack Nicklaus had become accustomed to setting Masters records. In a three-year span, he had established marks for margin of victory and the 72-hole scoring record. Plus, he had equaled the lowest round at Augusta National and was the tournament's youngest champion. The only thing left to do, it seemed, was to become the first back-to-back winner. In 1966, he did just that.";
captions[2] = "Arnold Palmer was due a breather at the Masters Tournament. In his first three victories at Augusta National Golf Club, Palmer had to produce spectacular finishes or survive a three-man playoff to earn his wins. In 1964, he faced no such obstacles in becoming the tournament's first four-time winner.";
captions[3] = "Seventeen years after Jack Nicklaus became the youngest Masters winner - and 17 years before Tiger Woods' record-setting performance at age 21 - there was Seve Ballesteros. Ballesteros grabbed the 1980 Masters Tournament by the throat with an opening 66 and never trailed after sharing the opening-round lead. The Spaniard became the first European to win the Masters and he added a second victory in 1983.";
captions[4] = "In 1997, Tiger Woods teed off in the final round with history for the taking. A final-round 69  gave him the lowest 72-hole score in Masters history and a 12-stroke victory, making him the first black major champion and, at 21, the youngest winner in tournament history. He might have had more success at the Masters in the 2000s, but the Woods era began in 1997. He set 20 Masters records and tied six others.";
captions[5] = "At the time of his second Masters triumph in 1974, Gary Player was well established as one of the game's top players and one of only four men to have won all four of the game's major championships. He also was known as a physical fitness buff whose stamina and work ethic were legendary.";
captions[6] = "In 1935, Gene Sarazen gave the tournament a signature moment. With one mighty swing - and a good deal of luck - The Squire, as he was known, helped put the Masters on the map. His double-eagle on No. 15 became known as the \"shot heard 'round the world.\"";
captions[7] = "Fred Couples came to the 12th tee in 1992 with the lead. Every golfer knows that to fire at the pin, tucked in its traditional Sunday placement in the right corner, is folly. Couples was trying to play it safe, but he blocked his tee shot. It hit the bank on the far side of Rae's Creek but, defying gravity, did not roll back into the water. From there, Couples chipped up close to save par and went on to win by two strokes.";
captions[8] = "Hord Hardin had become the club's third chairman, and his first major project was to oversee the conversion of the greens from bermuda to bentgrass. That occurred before the 1981 Masters, and that suited Tom Watson just fine. America's top player was up for the challenge and his second Masters victory.";
captions[9] = "Call it fate, call it luck, call it anything. Just be sure to call Larry Mize a Masters champion. The Augusta native was a decided underdog when he found himself in a sudden-death playoff with Greg Norman in 1987. Mize hit a 140-foot chip shot for an improbable birdie and the Masters had its first hometown winner.";

function tattoosInit() {
	//console.log("ready");
	
	$("#detail").hide();
	$("#shareCon").hide();

	$( ".draggable" ).draggable({ revert: "valid" });
	$( ".droppable" ).droppable({
      hoverClass: "boxHover",
      drop: function( event, ui ) {
        $( this )
         var dragid = ui.draggable.attr("id").substring(1, ui.draggable.attr("id").length);
         var dropid = $(this).attr("id").substring(1, $(this).attr("id").length);
         var dataid = $(this).attr("data-id")
         if (dragid == dropid) {
	   			$("#" + dragid + "inside").css("display", "block");
				$("#t" + dropid + " .messageright").css("display", "inline").delay(1500).fadeOut( "slow" );
				ui.draggable.css("visibility", "hidden");
				attempts ++;
				correct ++;
				$("#numAttempts").text(attempts);
				$("#numCorrect").text(correct);
				showInfo(dataid);

				$(this).click(function() {
					showInfo(dataid);
				});

				if (correct == 10) {
					$("#share").text("It took you " + attempts + " attempts to match them all. Share your score!")
					$("shareBtns").html("hello world");
					$("#shareCon").show();
				}

	         } else {
	         	//console.log("wrong");
	         	$("#t" + dropid + " .messagewrong").css("display", "inline").delay(1500).fadeOut( "slow" );
	         	attempts ++;
	         	$("#numAttempts").text(attempts);
	         }
      	}
    });

    $( ".droppable2" ).droppable();

    $("#detail").click(function() {
		$("#detail").hide();
		$("#detail").animate({ opacity: '0' }, 500);
	});

} 

function showInfo(which) {
	$("#detail").show();
	$("#detail").animate({ opacity: '1' }, 500);
	$("#detail #desc").text(captions[which]);

	var img = new Image();
	img.src = "http://www.augusta.com/masters/2016/games/match/imgs/big-" + allNames[which] + ".jpg";
	$("#detail #photoCon").empty();
	$("#detail #photoCon").append(img);


}


$(document).ready(function() {
	tattoosInit();

});