<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:

if ( !function_exists( 'chld_thm_cfg_locale_css' ) ):
    function chld_thm_cfg_locale_css( $uri ){
        if ( empty( $uri ) && is_rtl() && file_exists( get_template_directory() . '/rtl.css' ) )
            $uri = get_template_directory_uri() . '/rtl.css';
        return $uri;
    }
endif;
add_filter( 'locale_stylesheet_uri', 'chld_thm_cfg_locale_css' );

if ( !function_exists( 'chld_thm_cfg_parent_css' ) ):
    function chld_thm_cfg_parent_css() {
        wp_enqueue_style( 'chld_thm_cfg_parent', trailingslashit( get_template_directory_uri() ) . 'style.css', array(  ) );

        wp_enqueue_style( 'bootstrap', get_template_directory_uri(). '/assets/swiper-bundle.min.css', array(  ) );


	      
	      wp_enqueue_script( 'swiper_bundle_js', get_template_directory_uri() . '/assets/swiper-bundle.min.js', array('jquery'), '20151215', true );
    }
endif;
add_action( 'wp_enqueue_scripts', 'chld_thm_cfg_parent_css', 10 );

// END ENQUEUE PARENT ACTION




// ######## >>>> Custom Post Register for Swiper Slider <<<< ########
add_action( 'init', 'swiper_custom_post' );
function swiper_custom_post() {

    register_post_type( 'swiper',
    array(
        'labels' => array(
            'name' => __('S_Slider'),
            'all_items' => __('All'),
            'edit_item' => __('use this code [swiper count="3"]'),
            'singular_name' => __('sliders')
        ),
        'supports' => array('title', 'editor', 'author', 'thumbnail', 'comments', 'excerpt', 'page-attributes'),
        'public' => true,
        'menu_icon' => 'dashicons-cover-image', // Right side bar menu icon. https://developer.wordpress.org/resource/dashicons/#heart 

        )
    );
}

// ######## >>>> Custom Post-taxonomy Register <<<< ########
function swiper_custom_post_taxonomy() {
    register_taxonomy(
        't_cat',  
        'swiper',                  
        array(
            'hierarchical'          => true,
            'label'                 => 'Category',  
            'query_var'             => true,
            'show_admin_column'     => true,
            'rewrite'               => array(
                'slug'              => 'category', 
                'with_front'        => true 
                )
            )
    );
}
add_action( 'init', 'swiper_custom_post_taxonomy');



/**
 * add Shortcode();
 * use this [swiper]
 */

add_shortcode('swiper','swiper_section_func');
function swiper_section_func($jekono){
	$result = shortcode_atts(array(
		'count' =>'',
		
	),$jekono);

	extract($result);

	ob_start(); 
	?>
   
<!--Start Swiper Slider section-->
<!-- Swiper -->
    <div class="swiper-container mySwiper">
        <div class="swiper-wrapper">
            <?php 
        		$q = new WP_Query(array(
        			'post_type' => 'swiper',
        			'posts_per_page' => $count,

        			));
        		while($q->have_posts()):$q->the_post();
            ?>
          <div class="swiper-slide">
              
              <div class="f_img"><?php echo the_post_thumbnail();?></div>
              <h2><?php  echo the_title();?></h2>
              <div class="text-para">
                    <?php echo wp_trim_words(get_the_content(),'30','');
                     ?> <a href="<?php the_permalink();?>"><?php echo esc_html('Read More');?></a>
              </div>
          </div>

                <?php 
                            //     $category = get_the_terms( get_the_ID(), 't_cat', array('hide_empty'=> true));

                            //     $project_cat_slug = array();
                            //     foreach($category as $p_cat):
                            //         $project_cat_slug[] = $p_cat -> slug;
                            //     endforeach;  

                            //     $project_cat_name = join(', ',  $project_cat_slug);
                            //    # echo $category ;
                            ?>
                <?php // echo $project_cat_name ; ?>


            <?php endwhile;?>

<!-- 
          <div class="swiper-slide"><h2>Slide 2</h2></div>
          <div class="swiper-slide"><h2>Slide 3</h2></div>
          <div class="swiper-slide">Slide 4</div> -->
        </div>
        <div class="swiper-pagination"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
    </div>
<!-- Swiper End -->

<!--The End Swiper Slider section-->

	<?php
	return ob_get_clean();
}
 


add_action('wp_footer', 'get_swiper_custom_script');
  function get_swiper_custom_script(){
    ?>
<script>
    var titles = ['Slide 1', 'Slide 2', 'Slide 3', 'Slide 4']
    var mySwiper = new Swiper ('.swiper-container', {
        // If we need pagination
        pagination: {
        el: '.swiper-pagination',
                clickable: true,
            renderBullet: function (index, className) {
            return '<span class="' + className + '">' + (titles[index]) + '</span>';
            },
        },

        // Navigation arrows
        navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
        },
    })
    </script>
<?php 
  }