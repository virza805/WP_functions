<?php 

add_shortcode('project_slid','project_slid_section_func');

function project_slid_section_func($jekono){

	$result = shortcode_atts(array(

		'count' =>'',

		

	),$jekono);



	extract($result);



	ob_start(); 

	?>

        <!--Start project section-->

        <div class="project-section sec-pdd-90">

            <div class="container-bad">

                

                <!--Slider-->      

                <div class="project-slider project-carousel">

                    

                    <!--Slide-->

                    <?php 

        				$q = new WP_Query(array(

        					'post_type' => 'project',

        					'posts_per_page' => $count,



        				));

        				while($q->have_posts()):$q->the_post();

        			 ?>



                    <article class="slide-item">

                        <div class="slide-image">

                            <figure>

                            <?php  echo  the_post_thumbnail();?>

                                <div class="overlay">

                                    <div class="slide-content">

                                    <p><?php echo 

                                        wp_trim_words(get_the_content(),'10','');

                                    ?> <a href="<?php the_permalink();?>"><i class="fa fa-angle-double-right" aria-hidden="true"></i><?php echo esc_html('Read More');?></a></p>

                                      

                                    </div>

                                </div>

                            </figure>

                        </div>

                        <div class="info-box">

                            <h3><?php  echo the_title();?></h3>

                            <p class="catagory"><?php echo the_time('d M Y')?></p>

                        </div>

                    </article>

                <?php endwhile;?>

               

                </div>

                

            </div>    

        </div>

        <!--End project section-->



	<?php

	return ob_get_clean();

}



 ?>