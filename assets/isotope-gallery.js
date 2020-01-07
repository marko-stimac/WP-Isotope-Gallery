jQuery(function ($) {

     // init Isotope
     var $grid = $('.js-isotope__gallery').isotope({
     	itemSelector: '.js-isotope__link',
     	masonry: {
     		columnWidth: 200,
     		gutter: 5
     	}
     });

     // bind filter button click
     $('.js-isotope__buttons').on('click', 'button', function () {
     	var filterValue = $(this).attr('data-filter');
          // use filterFn if matches value
          $grid.isotope({
          	filter: filterValue
          });
     });

     // change is-checked class on buttons
     $('.js-isotope__buttons').each(function (i, buttonGroup) {
     	var $buttonGroup = $(buttonGroup);
     	$buttonGroup.on('click', 'button', function () {
     		$buttonGroup.find('.is-checked').removeClass('is-checked');
     		$(this).addClass('is-checked');
     	});
     });

     // Fancybox gallery
     var $fancybox = $('a.js-fancybox');
     if ($fancybox.length) {
     	$fancybox.fancybox({
     		keyboard: true,
     		arrows: true
     	}).attr('data-fancybox', 'group');
     }

});