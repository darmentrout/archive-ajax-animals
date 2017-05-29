<?php
define('WP_USE_THEMES', false);  
require_once('../../../wp-load.php');
?>




<?php 
if( isset($_GET['carousel']) ){
    
    // AJAX for moving through carousel
        $paged = $_GET['paged'] ? $_GET['paged'] : 1;
        $cat = get_query_var( 'cat' );
        $args = array(
            'post_type' => 'chickens',
            'order' => 'DSC',
            'posts_per_page' => 2,
            'cat' => $cat,
            'paged' => $paged
        );
        $caro = new WP_Query($args);                
        if($caro->have_posts()) : ?><?php while($caro->have_posts()) : $caro->the_post(); 
    ?>
        <div class="chicken-link" title="<?php the_title(); ?>">
            <a href="#" data-post-id="<?php the_ID(); ?>"><?php the_post_thumbnail('small'); ?></a>
        </div>
    <?php
        endwhile; endif;
        wp_reset_query();
    ?>

    <script>imageClick();</script>


<?php }

else { 

?>



    <?php
    // AJAX for clicking on chicken images
        $cat = get_query_var( 'cat' );
        $args = array(
            'p' => $_GET['p'],
            'post_type' => 'chickens',
            'order' => 'DSC',
            'posts_per_page' => 1,
            'cat' => $_GET['cat']
        );
        $query = new WP_Query( $args );
        if($query->have_posts()) : ?><?php while($query->have_posts()) : $query->the_post(); 
    ?>

        <h1><?php the_title(); ?></h3>
        <div class="entry row clearfix">
            <div class="featured-chicken-image">
                <?php the_post_thumbnail(); ?>
            </div>
            <div class="post-content">
                <?php the_content(); ?>
            </div>
        </div>

    <?php 
        endwhile; endif;
        wp_reset_query(); 
        die(); 
    ?> 


<?php } // end if(isset) ?>


