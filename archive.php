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
                        <div class="cows">
                            <h1>Cows!</h3>

                            
                            <div id="cows">
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

                                    <div class="post">
                                        <div class="entry"> 
                                            <p class="cows-head"><?php the_title();?></p>
                                            <?php the_content(); ?>
                                            <hr>
                                        </div>
                                    </div> 
                                    <!-- end .post -->

                                <?php 
                                    endwhile; endif;
                                    wp_reset_query(); 
                                    //break;
                                ?>
                            </div> 
                            <!-- end #cows -->
                        </div> 
                        <!-- end .cows -->
                    <?php break; ?>



                    <?php case "pigs": ?>
                        <div class="pigs">
                            <h1>Pigs!</h3>

                            <div id="pigs">
                                <?php
                                    $cat = get_query_var( 'cat' );
                                    $catArgs = array($cat);
                                    $args = array(
                                        'post_type' => 'pigs',
                                        'category__and' => $catArgs,
                                        'posts_per_page' => 1
                                    );
                                    $query = new WP_Query($args);
                                    if( $query->have_posts()) : ?><?php while($query->have_posts() ) : $query->the_post(); 
                                ?>

                                    <div class="post">
                                        <div class="entry">
                                            <p class="pigs-head"><?php the_title();?></p>
                                            <?php the_content(); ?>
                                            <hr>
                                        </div>
                                    </div> 
                                    <!-- end .post -->

                                <?php 
                                    endwhile; endif;
                                    wp_reset_query(); 
                                    //break;
                                ?>
                            </div> 
                            <!-- end #pigs -->
                        </div> 
                        <!-- end .pigs -->
                    <?php break; ?>





                <?php case "chickens": ?>
                <div id="chicken-spotlight" class="wrap">
                <?php
                    $cat = get_query_var( 'cat' );
                    $args = array(
                        'post_type' => 'chickens',
                        'order' => 'DSC',
                        'posts_per_page' => 1,
                        'cat' => $cat
                    );
                    $query = new WP_Query($args);                
                    if($query->have_posts()) : ?><?php while($query->have_posts()) : $query->the_post(); 
                ?>
                    <div class="post">
                        <h1><?php the_title(); ?></h3>
                        <div class="entry row clearfix">
                            <div class="featured-chicken-image">
                                <?php the_post_thumbnail(); ?>
                            </div>
                            <div class="post-content">
                                <?php the_content(); ?>
                            </div>
                        </div>
                    </div>
                    <!-- end .post -->
                    <?php 
                        endwhile; endif;
                        wp_reset_query();
                    ?>
                    <div class="row previous-chicken">
                        <div>
                            <p>Previously featured chickens:</p>
                            <div id="carousel-row">
                                <?php
                                    $per_page_count = 2;
                                    $count_chickens = wp_count_posts( 'chickens' )->publish;
                                    $chicken_total = round($count_chickens/$per_page_count, 0, PHP_ROUND_HALF_UP);
                                ?>
                            </div>

                            <p id="carouselPages" aria-live="polite" aria-label="Use these buttons to page through the previously featured chicken">
                                <?php
                                // global $wp_query;
                                $big = 999999999; // need an unlikely integer
                                $pagination = paginate_links( array(
                                    'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                                    'format' => '?paged=%#%',
                                    'current' => max( 1, get_query_var('paged') ),
                                    'total' => $chicken_total, //$caro->max_num_pages, // adding 1 shouldn't be necessary
                                    'show_all' => 'True'
                                    ) 
                                );
                                $pagination = preg_replace("/<a\s(.+?)>(.+?)<\/a>/is", "<span role='button' tabindex='0'>$2</span>", $pagination);
                                echo "<span role='button' tabindex='0'>« Back</span> " . $pagination; 
                                ?>
                            </p>
                            <?php wp_reset_query(); ?>           
                        </div>
                    </div>
                </div> 
                <!-- end #chicken-spotlight -->

                <script>
                    jQuery('.page-numbers.current').attr({'tabindex':0, 'role':'button'});
                    // AJAX for clicking on chicken images
                    function imageClick(){
                        jQuery('.chicken-link a').on('click', function(e){
                            e.preventDefault();
                            var postId = jQuery(this).attr('data-post-id');
                            jQuery.get('<?php echo get_stylesheet_directory_uri(); ?>/chicken-ajax.php', {
                                  'p': postId,
                                  'cat': '<?php echo intval( $cat ); ?>'
                              }, function(data){
                              jQuery('#chicken-spotlight .post').html(data);
                            });        
                        });
                    }
                    imageClick();

                    // AJAX for moving through carousel
                        var currentPage = parseInt( jQuery('.current').html() );
                        var lastPage = parseInt( jQuery('#carouselPages span:last').prev().html() );
                        var firstPage = parseInt( jQuery('#carouselPages span:first').next().html() );
console.log('a '+currentPage+' '+ lastPage+' '+firstPage);
                        // set up the function to page through carousel
                        function carouselNav(){
                            jQuery('#carousel-row').animate({'opacity': 0}, 'fast');
                            currentPage = parseInt( jQuery('.current').html() );
console.log('b '+currentPage+' '+ lastPage+' '+firstPage);
                            function setCurrent(n){
                                jQuery('.current').removeClass('current');
                                jQuery('#carouselPages span').each(function(){
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
                                        'cat': '<?php echo intval( $cat ); ?>'
                                    }
                                    setCurrent(currentPage);
                                    break;
                                case "Next »":
                                    currentPage = currentPage + 1;
                                    if ( currentPage > lastPage ){ currentPage = firstPage; }
                                    args = {
                                        'carousel': true,
                                        'paged': currentPage,
                                        'cat': '<?php echo intval( $cat ); ?>'
                                    }
                                    setCurrent(currentPage);
                                    break;
                                default:
                                    args = {
                                        'carousel': true,
                                        'paged': parseInt(page),
                                        'cat': '<?php echo intval( $cat ); ?>'
                                    }
                                    setCurrent(page);
                                    break;
                            } // end switch

                            jQuery.get('<?php echo get_stylesheet_directory_uri(); ?>/chicken-ajax.php', args, function(data){
                              jQuery('#carousel-row').html(data);
                              jQuery('#carousel-row').animate({'opacity': 1}, 'fast');
                            });                          
                        }

                        // execute carousel pagination based on input method
                        jQuery('#carouselPages span').on('click', carouselNav);
                        jQuery('#carouselPages span').on('keyup', function(e){
                            var key = e.which;
                            if ( key == 13 ){ $(document.activeElement).click() }
                        });
                </script>



<script>
    // jQuery('document').on('ready', function(){
        args = {
            'carousel': true,
            'paged': 1,
            'cat': '<?php echo intval( $cat ); ?>'
        }
        jQuery.get('<?php echo get_stylesheet_directory_uri(); ?>/chicken-ajax.php', args, function(data){
          jQuery('#carousel-row').html(data);
        }); 
    // });
</script>                

                <?php
                    break;
                ?>










                <?php default:
                    // must have post_type in query and it must be empty
                    $cat = get_query_var( 'cat' );
                    $args = array(
                        // 'posts_per_page' => 1,
                        'cat' => $cat,
                        'post_type' => array(
                            'cows',
                            'pigs',
                            'chickens'
                        )
                    );
                    $query = new WP_Query($args);
                    if( $query->have_posts()) : ?><?php while($query->have_posts() ) : $query->the_post();
                     ?>
                    <div class="post wrap">
                    <h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                        <div class="entry">   
                            <?php the_post_thumbnail(); ?>
                            <?php the_content(); ?>
                        </div>
                    </div>
                    <?php 
                        endwhile; endif;
                        wp_reset_query(); 
                        break;
                    ?>

                <?php } // end switch
            } // end post_type isset



            else {
                    // post_type is not in query
                    $cat = get_query_var( 'cat' );
                    $args = array(
                        // 'posts_per_page' => 1,
                        'cat' => $cat
                    );
                    $query = new WP_Query($args);
                    if( $query->have_posts()) : ?><?php while($query->have_posts() ) : $query->the_post();
                 ?>
                <div class="post wrap">
                <!-- ELSE -->
                <h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                    <div class="entry">   
                        <?php the_post_thumbnail(); ?>
                        <?php the_content(); ?>
                    </div>
                </div>
                <?php endwhile; endif; wp_reset_query(); ?> 
            <?php } ?>


</div> 
<!-- end #main -->

<?php get_footer(); ?>
