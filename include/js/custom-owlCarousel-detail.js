jQuery(document).ready(function($) {
	var time = 7; // time in seconds
	var $progressBar, $bar, $elem, isPause, tick, percentTime;
	$("#__CaseStudySlider").owlCarousel({
		navigationText : ["", ""],
		lazyLoad:true,
		navigation:true,
		singleItem:true,
		paginationSpeed:1000,
		autoPlay:true,
		goToFirstSpeed:2000,
		autoHeight:true,
		afterInit:progressBar,
		afterMove:moved,
		startDragging:pauseOnDragging
	}); 
	
	function progressBar(elem) {
		$elem = elem;
		buildProgressBar();
		start();
	}
	
	function buildProgressBar() {
		$progressBar = $("<div>",{id:"progressBar"});$bar=$("<div>",{id:"bar"});
		$progressBar.append($bar).prependTo($elem);
	}
	
	function start() {
		percentTime = 0;
		isPause = false;
		tick = setInterval(interval,10)
	};
	
	function interval() {
		if(isPause===false){
			percentTime+=1/time;
			$bar.css({
				width:percentTime+"%"
			});
			if(percentTime >= 100){
				$elem.trigger('owl.next');
			}
		}
	}
	
	function pauseOnDragging() {
		isPause=true;
	}
	
	function moved() {
		clearTimeout(tick);
		start();
	}	
});

var $bar = "";
jQuery(document).ready(function($) {
	var time = 7; // time in seconds
	var $progressBar,$bar,$elem,isPause,tick,percentTime;
	var sync1 = $("#__CaseStudySlider2");
	var sync2 = $("#__CaseStudySlider2_thumb");
	sync1.owlCarousel({
		navigationText : ["", ""],
		lazyLoad:true,
		navigation:true,
		singleItem:true,
		autoPlay:true,
		paginationSpeed:1000,
		goToFirstSpeed:2000,
		autoHeight:true,
		afterMove:moved,
		startDragging:pauseOnDragging,
		afterAction:syncPosition,
		responsiveRefreshRate:200
	});
	
	sync2.owlCarousel({
		items:5,itemsDesktop:[1199,5],
		itemsDesktopSmall:[979,5],
		itemsTablet:[768,5],
		itemsMobile:[479,5],
		pagination:false,
		lazyLoad:true,
		responsiveRefreshRate:100,
		autoPlay:true,
		afterInit:function(el){
			el.find(".owl-item").eq(0).addClass("synced");
		}
	});
	
	function syncPosition(el) {
		var current = this.currentItem;
		$("#__CaseStudySlider2_thumb").find(".owl-item").removeClass("synced").eq(current).addClass("synced")
		if($("#__CaseStudySlider2_thumb").data("owlCarousel") !== undefined) {
			center(current);
		}
	}
	
	$("#__CaseStudySlider2_thumb").on("click", ".owl-item", function(e) {
		e.preventDefault();
		var number = $(this).data("owlItem");
		sync1.trigger("owl.goTo",number);
	});

	function center(number) {
		var sync2visible = sync2.data("owlCarousel").owl.visibleItems;
		var num = number;
		var found = false;
		for(var i in sync2visible) {
			if(num === sync2visible[i]){
				var found = true;
			}
		}
		if(found===false) {
			if(num>sync2visible[sync2visible.length-1]) {
				sync2.trigger("owl.goTo", num - sync2visible.length+2)
			} else {
				if(num - 1 === -1) {
				 num = 0;
				}
				sync2.trigger("owl.goTo", num);
			}
		} else if(num === sync2visible[sync2visible.length-1]) {
			sync2.trigger("owl.goTo", sync2visible[1]);
		} else if(num === sync2visible[0]) {
			sync2.trigger("owl.goTo", num-1);
		}
	}
	
	function progressBar(elem) {
		$elem = elem;
		buildProgressBar();
		start();
	}
	
	function buildProgressBar() {
		$progressBar=$("<div>",{id:"progressBar"});
		$bar = $("<div>",{id:"bar"});
		$progressBar.append($bar).prependTo($elem);
	}
	
	function start() {
		percentTime=0;
		isPause=false;
		tick=setInterval(interval,10);
	};
	
	function interval() {
		if(isPause===false) {
			$bar = $("<div>",{id:"bar"});
			percentTime+=1/time;
			$bar.css({
				width:percentTime+"%"
			});
			if(percentTime>=100) {
				//$elem.trigger('owl.next');
			}
		}
	}
	
	function pauseOnDragging() {
		isPause=true;
	}
	
	function moved() {
		clearTimeout(tick);
		start();
	}	
});