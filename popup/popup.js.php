<?php

// Test Popup Start now \\

//  echo do_shortcode("[popup no='' title='' smtitle='' des='']"); 

add_shortcode('popup','table_popup_func');
function table_popup_func($jekono){
	$result = shortcode_atts(array(
		'no' =>'',
		'title' =>'',
		'smtitle' =>'',
		'des' =>'',
		
	),$jekono);

	extract($result);

	ob_start(); ?>

<span data-title="<?=$title?>" data-smtitle="<?=$smtitle?>" data-des="<?=$des?>" class="Click-here"><?=$no?></span>

<?php
	return ob_get_clean();
}

// add javaScript hook for footer 
add_action('wp_footer', 'get_footer_script');
function get_footer_script(){
  ?>
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>
<script >
	$(".Click-here").on('click', function() {
      $("#popup_title").text($(this).attr("data-title"));
      $("#popup_smtitle").text($(this).attr("data-smtitle"));
      $("#popup_des").html($(this).attr("data-des"));
      $(".popup-model-main").addClass('model-open');
    }); 
    $(".close-btn, .bg-overlay").click(function(){
      $(".popup-model-main").removeClass('model-open');
    });

	
//     // class add Or remove for popup
// 	let tclass = document.getElementsByClassName("Click-here");
// 	tclass[0].addEventListener("onclick", addClass);

// 	function addClass() {
// 			let element = document.getElementsByClassName("popup-model-main");
// 			element.classList.add("model-open");
// 	}

// 	let ctclass = document.getElementsByClassName("close-btn");
// 	ctclass[0].addEventListener("onclick", removeClass);
// 	function removeClass() {
// 			let element = document.getElementsByClassName("popup-model-main");
// 			element.classList.remove("model-open");
// 	}
</script>

<?php
}



