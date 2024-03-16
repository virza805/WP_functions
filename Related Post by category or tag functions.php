<?php echo do_shortcode("[related_news]"); ?>
<!--use this short code in -->
<?php 
// /////////////  Related Post //////////

add_shortcode('related_news','related_section_func');
function related_section_func($jekono){
	$result = shortcode_atts(array(
		'title' =>'',
		'des' =>'',
		
	),$jekono);

	extract($result);

	ob_start(); 
	
////========= You can use this code to get related posts from the same tags Start =========/////

// $tags = wp_get_post_terms( get_queried_object_id(), 'post_tag', ['fields' => 'ids'] );
// $args = [
//     'post__not_in'        => array( get_queried_object_id() ),
//     'posts_per_page'      => 5,
//     'orderby'             => 'rand',
//     'tax_query' => [
//         [
//             'taxonomy' => 'post_tag',
//             'terms'    => $tags
//         ]
//     ]
// ];
// $the_query = new WP_Query( $args );

////========= You can use this code to get related posts from the same tags end =========/////


////========= Use this code to get related posts from the same category =========/////

$args = array(
    'category__in' => wp_get_post_categories( get_queried_object_id() ),
    'posts_per_page' => 3,
    'orderby'       => 'rand',
    'post__not_in' => array( get_queried_object_id() )
    );
$the_query = new WP_Query( $args );

if ( $the_query->have_posts() ) : ?>

<style>
    .related-post-sec {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-wrap: wrap;
        flex-wrap: wrap;
        margin-right: -15px;
        margin-left: -15px;
        align-content: space-around;
        justify-content: space-between;
        align-items: center;
    }

    .post-item {
        width: 32% !important;
        display: block;
        align-items: center;
        margin: 13px 0;
    }

    .post-item .feture-image img {
        width: 364px;
    }

    .info-box {
        border: 2px solid #f6f6f6;
        padding: 10px 8px;
    }

    .info-box p {
        color: #676767;
    }

    .info-box a {
        color: #cea048;
    }

    .feture-image img {
        height: 250px;
    }
</style>
<div class="related-border-top">
    <p>
        Category: <b>
            <?php 
                $category_name = get_the_category( get_queried_object_id() );
                    foreach($category_name as $cd){
                        echo $cd->cat_name; // Category name
                }
            ?>
        </b>
    </p>
    <h2 class="related-post-title">Related Post</h2>
</div>

<div class="related-post-sec">
    <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>

    <div class="post-item">
        <div class="feture-image">

            <?php  echo  the_post_thumbnail();?>

        </div>
        <div class="info-box">
            <h3> <?php  echo the_title();?> </h3>
            <p class="catagory"> <?php echo the_time('d M Y'); ?></p>

            <p><?php echo wp_trim_words(get_the_content(),'20',''); ?><a href="<?php the_permalink();?>"><i
                        class="fa fa-angle-double-right" aria-hidden="true"></i><?php echo esc_html('Read More');?></a>
            </p>
        </div>
    </div>
    <!--End 2 post item -->

    <?php endwhile; ?>



</div>
<?php wp_reset_postdata(); ?>

<?php endif; ?>

<?php
	return ob_get_clean();
}

 ?>

<?php 
    $category = get_the_terms( get_the_ID(), 't_cat', array('hide_empty'=> true));

    $project_cat_slug = array();

        foreach($category as $p_cat):
            $project_cat_slug[] = $p_cat -> slug;
        endforeach;  

    $project_cat_name = join(', ',  $project_cat_slug);
    // echo $category ;
?>
<p><?php echo $project_cat_name ; ?>-<?php echo the_time(' M Y'); ?></p>

<?php 

// Show Category List Form Post 

// //do_shortcode("[category_show]");//  Show Category List by Post //////////

add_shortcode('category_show','category_show_fun');
function category_show_fun(){
	ob_start(); ?>

<!-- Category:  -->
<style>
    ul.cat-style {
        list-style: none;
    }
    ul.cat-style li.categories {
        display: flex;
        align-items: center;
        align-content: center;
        justify-content: center;
        flex-direction: column;
    }

    ul.cat-style li.categories ul {
        list-style: none;
        display: flex;
        align-content: center;
        justify-content: center;
        align-items: center;
        padding: 0;
        flex-wrap: wrap;
    }

    ul.cat-style li.categories ul li {
        margin: 8px 3px;
    }

    ul.cat-style li.categories b {
        margin: 15px 0;
        font-size: 32px;
        color: #148541;
    }
    ul.cat-style li.categories ul li a {
        padding: 8px 16px;
        background: #070707;
        color: #fff;
        transition: .4s;
    }
    ul.cat-style li.categories ul li:hover a{
        background: #148541;
    }

</style>

<ul class="cat-style">
    <?php wp_list_categories( array(
        'orderby'    => 'name',
		'order'   => 'ASC', // RAND
		'exclude_tree' => 41,
		'title_li' => '<b>' . __( 'Categories', 'textdomain' ) . '</b>',
    ) ); ?> 
</ul>
	
	<?php
	return ob_get_clean();
}
?>


<?php
function discount_circle_remove_on_poen_menu_script() {
?>
<script type="text/javascript">
 $('.fusion-icon-bars').on('click', function () {
    $('.fusion-logo-link').toggleClass('open');
});
</script>
<?php
}
add_action('wp_footer', 'discount_circle_remove_on_poen_menu_script');



// Add toggle for FAQ's section

add_action('wp_footer', 'get_footer_custom_script');
  function get_footer_custom_script(){
    ?>
	<script>
		(function ($) {
			"use strict";
			
			jQuery(document).ready(function($){

				$('.fusion-icon-bars').on('click', function () {
					$('.fusion-logo-link').toggleClass('open');
				});
				
			});

			// this is off canvs menu on
			$(".menu-btn").on('click', function(){
            $(".offcanvs-menu").addClass("active");
            $(".offcanvs-menu-overlay").addClass("active");
			});
			
			$(".menu-close i.fa, .offcanvs-menu-overlay").on('click', function(){
				$(".offcanvs-menu").removeClass("active");
				$(".offcanvs-menu-overlay").removeClass("active");
			});



			jQuery(window).load(function(){

			});

		}(jQuery));
    </script>
<?php 
  }
// Use old editor for post
add_filter('use_block_editor_for_post', '__return_false', 10);




