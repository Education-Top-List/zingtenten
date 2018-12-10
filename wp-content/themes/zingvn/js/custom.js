
	jQuery(document).ready(function(){

				// SCROLL TO DIV
		jQuery(window).scroll(function(){
			if(jQuery(this).scrollTop()>500){
				jQuery('.scrolltop').addClass('go_scrolltop');
			}
			else if(jQuery(this).scrollTop()>50){
				jQuery('.header').addClass('fixedheader');
			}
			else{
				jQuery('.scrolltop').removeClass('go_scrolltop');
				jQuery('.header').removeClass('fixedheader');
			}
		});
		jQuery('.scrolltop').click(function (){
		    jQuery('html, body').animate({
		      scrollTop: jQuery("html").offset().top
		    }, 1000);
		 }); 
			// SLIDE
		jQuery('.list_hot_post_others').slick({
			dots: false,
			infinite: true,
			speed: 300,
			slidesToShow: 3,
			slidesToScroll: 1,
			autoplay: true,
			autoplaySpeed: 2000,
					// fade: true,
					cssEase: 'linear',
					responsive: [
					{
						breakpoint: 1024,
						settings: {
							slidesToShow: 2,
							slidesToScroll: 1,
							infinite: false,
							dots: false
						}
					},
					{
						breakpoint: 600,
						settings: {
							slidesToShow: 1,
							slidesToScroll: 1
						}
					},
					{
						breakpoint: 480,
						settings: {
							slidesToShow: 1,
							slidesToScroll: 1
						}
					}
					]
				});
	});
	
