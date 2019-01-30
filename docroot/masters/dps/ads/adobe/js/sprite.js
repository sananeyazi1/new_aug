if(!Hook) var Hook = {};
if(!Hook.Animation) Hook.Animation = {};

(Hook.Animation.SpriteSheet = function() {
	var $this = this;
	this.images = null;
	this.src = null;
	this.activeImageIndex = 0;
	this.activeImage = {
		src : null
	}
	
	this.onCompleteCallbacks = new Array();
	
	if(window.requestAnimFrame == undefined) {
		
		( function() {
			var lastTime = 0;
			var vendors = ['ms', 'moz', 'webkit', 'o'];
			for(var x = 0; x < vendors.length && !window.requestAnimationFrame; ++x) {
				window.requestAnimationFrame = window[vendors[x] + 'RequestAnimationFrame'];
				window.cancelAnimationFrame = window[vendors[x] + 'CancelAnimationFrame'] || window[vendors[x] + 'CancelRequestAnimationFrame'];
			}
			
			if(!window.requestAnimationFrame) {
				window.requestAnimationFrame = function(callback, element) {
					var currTime = new Date().getTime();
					var timeToCall = Math.max(0, 16 - (currTime - lastTime));
					var id = window.setTimeout(function() {
						callback(currTime + timeToCall);
					}, timeToCall);
					lastTime = currTime + timeToCall;
					return id;
				};
			}
			if(!window.cancelAnimationFrame) {
				window.cancelAnimationFrame = function(id) {
					clearTimeout(id);
				};
			}
		}());
	}
	
	this.setActiveImage = function(image) {
		$this.activeImage = image;
		$this.src.setAttribute('src',$this.activeImage.src);
		if($this.activeImage.width != undefined) {
			$this.src.setAttribute('width',$this.activeImage.width);
		}
		if($this.activeImage.height != undefined) {
			$this.src.setAttribute('height',$this.activeImage.height);
		}
		//console.log($this.activeImage.src);
	}
	
	this.setIndex = function(index) {
		//console.log('Hook.Animation.Sprite.setIndex() ' + index);
		if(index >= $this.images.length || index < 0) {
			if($this.isPlaying) {
				$this.stop();
			}
			return;
		}
		$this.activeImageIndex = index;
		$this.setActiveImage($this.images[index]);
	}
	
	this.isPlaying = false;
	this.animationId = -1;
	this.lastFrameTime = null;
	this.frameRate = null;
	
	this.play = function() {
		//console.log('Hook.Animation.Sprite.play()');
		//console.log($this.activeImageIndex)
		$this.lastFrameTime = new Date().getTime();
		$this.isPlaying = true;
		
		function onPlay() {
			if(!$this.isPlaying) {
				return;
			}
			$this.animationId = window.requestAnimationFrame(onPlay);
			var currTime = new Date().getTime();
			var frameSpeed = 1000/$this.frameRate;
			if($this.lastFrameTime + frameSpeed < currTime) {
				$this.nextFrame();
				$this.lastFrameTime = currTime;
			}
		}
		$this.animationId = window.requestAnimationFrame(onPlay);
	}
	
	this.stop = function() {
		//console.log('Hook.Animation.Sprite.stop()');
		$this.isPlaying = false;
		window.cancelAnimationFrame($this.animationId);
		
		for(var i in $this.onCompleteCallbacks) {
			var callback = $this.onCompleteCallbacks[i];
			console.log(callback.scope);
			callback.callback.apply(callback.scope, [$this]);
		}
	}
	
	this.nextFrame = function() {
		//console.log('Hook.Animation.Sprite.nextFrame()' + $this.activeImageIndex);
		$this.setIndex($this.activeImageIndex+1);
	}
	
	this.prevFrame = function() {
		$this.setIndex($this.activeImageIndex-1);
	}
	
	this.addOnCompleteCallback = function(callback, scope) {
		var callbackObject = {
			callback : callback,
			scope : scope
		}
		$this.onCompleteCallbacks.push(callbackObject);
	}
	
	this.removeOnCompleteCallback = function(callback) {
		for(var i in $this.onCompleteCallbacks) {
			var callbackObject = $this.onCompleteCallbacks[i];
			if(callbackObject.callback == callback) {
				$this.onCompleteCallbacks.splice(i,1);
				return;
			}
		}
	}
	
	return {
		init: function(src, images, frameRate, onComplete) {
			$this.images = images;
			$this.src = src;
			$this.frameRate = frameRate;
			if(onComplete != undefined) {
				$this.addOnCompleteCallback(onComplete, this);
			}
		},
		setIndex: function(index) {
			$this.setIndex(index);
		},
		getIndex: function() {
			return $this.activeImageIndex;
		},
		nextFrame: function() {
			$this.nextFrame();
		},
		prevFrame: function() {
			$this.prevFrame();
		},
		play : function() {
			$this.play();
		},
		stop : function() {
			$this.stop();
		},
		isPlaying : function() {
			return $this.isPlaying;
		},
		addOnCompleteCallback : function(callback, scope) {
			$this.addOnCompleteCallback(callback, scope);
		},
		removeOnCompleteCallback : function(callback) {
			$this.removeOnCompleteCallback(callback);
		}
	}
	
});
