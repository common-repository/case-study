jQuery(document).ready(function($){
	
	var $container = $('#__casestudypage'),
	colWidth = function () {
		var w = $container.width(), 
			columnNum = 1,
			columnWidth = 0;
			
		if (w > 1400) {
			columnNum  = 5;
		} else if (w > 900) {
			columnNum  = 4;
		} else if (w > 600) {
			columnNum  = 3;
		} else if (w > 400) {
			columnNum  = 2;
		}
		columnWidth = Math.floor(w/columnNum);
		$container.find('.item').each(function() {
			var $item = $(this),
				multiplier_w = $item.attr('class').match(/item-w(\d)/),
				multiplier_h = $item.attr('class').match(/item-h(\d)/),
				width = multiplier_w ? columnWidth*multiplier_w[1]-4 : columnWidth-4,
				height = multiplier_h ? columnWidth*multiplier_h[1]*0.5-4 : columnWidth*0.5-4;
			$item.css({
				width: width,
				height: height
			});
		});
		return columnWidth;
	};
			
	var $optionSets = $('.__sortitems .sortmenu'),
        $optionLinks = $optionSets.find('a');

    $optionLinks.click(function(){ 
        var $this = $(this);
        // don't proceed if already selected
        if ( $this.hasClass('selected') ) {
          return false;
        }
        var $optionSet = $this.parents('.sortmenu');
        $optionSet.find('.selected').removeClass('selected');
        $this.addClass('selected');
		var datavalue = $this.attr('data-option-value');
  
        // make option object dynamically, i.e. { filter: '.my-filter-class' }
        var options = {},
            key = $optionSet.attr('data-option-key'),
            value = $this.attr('data-option-value');
        // parse 'false' as false boolean
        value = value === 'false' ? false : value;
        options[ key ] = value;
        if ( key === 'layoutMode' && typeof changeLayoutMode === 'function' ) {
          // changes in layout modes need extra logic
          changeLayoutMode( $this, options )
        } else {
          // otherwise, apply new options
		  $container.find('.item').css('display','none');
		  $container.find(datavalue).css('display','block');
          
        }      
        return false;
    });
});