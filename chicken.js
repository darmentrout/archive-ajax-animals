


jQuery('.page-numbers.current').attr({'tabindex':0, 'role':'button'});


// AJAX for clicking on chicken images
function imageClick(){
	jQuery('.chicken-link a').on('click', function(e){
		e.preventDefault();
		var postId = jQuery(this).attr('data-post-id');
		jQuery.get(chickenVars.stylesheetDirUri+'/chicken-ajax.php', {
			'p': postId,
			'cat': chickenCat
		},
		function(data){
			jQuery('.chickens').html(data);
		});        
	});
}
imageClick();



// AJAX for moving through carousel
var currentPage = parseInt( jQuery('.current').html() );
var lastPage = parseInt( jQuery('#carousel-chickens span:last').prev().html() );
var firstPage = parseInt( jQuery('#carousel-chickens span:first').next().html() );

// set up the function to page through carousel
function carouselNav(){

	jQuery('#carousel-row').animate({'opacity': 0}, 'fast');

	currentPage = parseInt( jQuery('.current').html() );

	function setCurrent(n){
		jQuery('.current').removeClass('current');
		jQuery('#carousel-chickens span').each(function(){
			if ( jQuery(this).html() == n ){
				jQuery(this).addClass('current');
			}
		});
	}

	var page = jQuery(this).html();
	var args;

	switch(page){
		case "« Back":
			currentPage = currentPage - 1;
			if ( currentPage < 1 ){ currentPage = lastPage }
			args = {
				'carousel': true,
				'paged': currentPage,
				'cat': chickenCat
			}
			setCurrent(currentPage);
			break;

		case "Next »":
			currentPage = currentPage + 1;
			if ( currentPage > lastPage ){ currentPage = firstPage; }
			args = {
				'carousel': true,
				'paged': currentPage,
				'cat': chickenCat
			}
			setCurrent(currentPage);
			break;

		default:
			args = {
				'carousel': true,
				'paged': parseInt(page),
				'cat': chickenCat
			}
			setCurrent(page);
			break;

	} // end switch

	jQuery.get(chickenVars.stylesheetDirUri+'/chicken-ajax.php', args, function(data){
		jQuery('#carousel-row').html(data);
		jQuery('#carousel-row').animate({'opacity': 1}, 'fast');
	});        

} // end carouselNav


// get rid of the unnecessary page-numbers class
jQuery('.page-numbers').removeClass('page-numbers');


// execute carousel pagination based on input method
jQuery('#carousel-chickens span').on('click', carouselNav);
	jQuery('#carousel-chickens span').on('keyup', function(e){
	var key = e.which;
	if ( key == 13 ){ jQuery(document.activeElement).click() }
});



// load up the first round of chickens
	args = {
	'carousel': true,
	'paged': 1,
	'cat': chickenCat
}
jQuery.get(chickenVars.stylesheetDirUri+'/chicken-ajax.php', args, function(data){
	jQuery('#carousel-row').html(data);
}); 
