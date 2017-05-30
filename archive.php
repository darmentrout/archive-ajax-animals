<?php get_header(); ?>

<!--
    animal archive
-->

<div id="main"> 
<!-- main template content -->

<?php
if ( isset($_GET["post_type"]) ) {

    switch ( $_GET["post_type"] ) {

        case "cows": ?>
            <div id="theCows">
                <h1>Cows!</h1>
                <div class="cows">
                    <?php
                        $cat = get_query_var( 'cat' );
                        $catArgs = array($cat);
                        $args = array(
                            'post_type' => 'cows',
                            'category__and' => $catArgs
                        );
                        $query = new WP_Query($args);
                        if( $query->have_posts()) : ?><?php while($query->have_posts() ) : $query->the_post(); 
                    ?>
                    <div class="cow-post">
                        <h2 class="cow-title"><?php the_title();?></h2>
                        <div class="cow-content"><?php the_content(); ?></div>
                    </div> 
                    <!-- end .cow-post -->
                    <?php 
                        endwhile; 
                        endif;
                        wp_reset_query(); 
                    ?>
                </div> 
                <!-- end .cows -->
            </div> 
            <!-- end #theCows -->
        <?php break; ?>


        <?php case "pigs": ?>
            <div id="thePigs">
                <h1>Random Pigs!</h1>
                <div class="pigs">
                    <?php
                        $cat = get_query_var( 'cat' );
                        $catArgs = array($cat);
                        $args = array(
                            'post_type' => 'pigs',
                            'category__and' => $catArgs,
                            'posts_per_page' => 1,
                            'orderby' => 'rand'
                        );
                        $query = new WP_Query($args);
                        if( $query->have_posts()) : ?><?php while($query->have_posts() ) : $query->the_post(); 
                    ?>
                    <div class="pig-post">
                        <h2 class="pig-title"><?php the_title();?></h2>
                        <div class="pig-content"><?php the_content(); ?></div>
                    </div>
                    <?php 
                        endwhile; 
                        endif;
                        wp_reset_query(); 
                    ?>
                </div> 
                <!-- end .pigs -->
            </div> 
            <!-- end #thePigs -->
        <?php break; ?>


        <?php case "chickens": ?>
            <div id="theChickens">
                <h1>Chickens!</h1>
                <?php
                    $cat = get_query_var( 'cat' );
                    // I wanted to add the following using wp_localize_script but no dice
                    echo "<script>chickenCat = " . intval( $cat ) . ";</script>";
                    $args = array(
                        'post_type' => 'chickens',
                        'order' => 'DSC',
                        'posts_per_page' => 1,
                        'cat' => $cat
                    );
                    $query = new WP_Query($args);
                    if($query->have_posts()) : ?><?php while($query->have_posts()) : $query->the_post(); 
                ?>
                <div class="chickens">
                    <h2><?php the_title(); ?></h2>
                    <div class="chicken-post">
                        <div class="chicken-image">
                            <?php the_post_thumbnail(); ?>
                        </div>
                        <div class="chicken-content">
                            <?php the_content(); ?>
                        </div>
                    </div>
                    <!-- end .chicken-post -->
                    <?php 
                        endwhile; 
                        endif;
                        wp_reset_query();
                    ?>
                </div>

                <div id="previous-chickens">
                <h2>Previously featured chickens:</h2>
                <div id="carousel-row"></div>
                <div id="carousel-chickens" aria-live="polite" aria-label="Use these buttons to page through the previously featured chickens">
                    <?php
                        $per_page_count = 2;
                        $count_chickens = wp_count_posts( 'chickens' )->publish;
                        $chicken_total = round($count_chickens/$per_page_count, 0, PHP_ROUND_HALF_UP);
                        $big = 999999999; // need an unlikely integer; thanks wp codex!
                        $pagination = paginate_links( 
                            array(
                                'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                                'format' => '?paged=%#%',
                                'current' => max( 1, get_query_var('paged') ),
                                'total' => $chicken_total,
                                'show_all' => 'True'
                            )
                        );
                        $pagination = preg_replace(
                            "/<a\s(.+?)>(.+?)<\/a>/is", 
                            "<span role='button' tabindex='0'>$2</span>", 
                            $pagination
                        );
                        echo "<span role='button' tabindex='0'>« Back</span> " . $pagination; 
                    ?>
                </div>
                <?php wp_reset_query(); ?>
                </div>
                <!-- end #previous-chickens -->

            </div> 
            <!-- end #theChickens -->

        <?php break; ?>


        <?php default:
            // must have post_type in query and it must be empty
            $cat = get_query_var( 'cat' );
            $args = array(
                'cat' => $cat,
                'post_type' => array(
                    'cows',
                    'pigs',
                    'chickens'
                )
            );
            $query = new WP_Query($args);
            if( $query->have_posts()) : ?><?php while($query->have_posts() ) : $query->the_post(); ?>
            <div class="post wrap">
                <h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
                <div class="entry">   
                    <?php the_post_thumbnail(); ?>
                    <?php the_content(); ?>
                </div>
            </div>
            <?php 
                endwhile; 
                endif;
                wp_reset_query(); 
            break;


    } // end switch
} // end post_type isset



else {
    // post_type is not in query
    if( have_posts()) : ?><?php while(have_posts() ) : the_post(); ?>
    <div class="post wrap">
        <h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
        <div class="entry">   
            <?php the_post_thumbnail(); ?>
            <?php the_content(); ?>
        </div>
    </div>
    <?php 
    endwhile; 
    endif; 

} 

?>


</div> 
<!-- end #main -->

<?php get_footer(); ?>
