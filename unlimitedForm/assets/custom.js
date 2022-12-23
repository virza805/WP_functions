/*************************************************
|||||       SLIDER CONTENT       |||||
************************************************/


"use strict";
	
//project Carousel Slider
if ($('.project-carousel').length) {
    $('.project-carousel').owlCarousel({
        loop:true,
        margin:30,
        nav:true,
        autoplayHoverPause:true,
        autoplay: true, // false
        smartSpeed: 700,
        navText: [ '<span class="fa fa-angle-left"></span>', '<span class="fa fa-angle-right"></span>' ],
        responsive:{
            0:{
                items:1
            },
            600:{
                items:1
            },
            800:{
                items:2
            },
            1024:{
                items:3
            },
            1200:{
                items:4
            }
        }
    });    		
}





