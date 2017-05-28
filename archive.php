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
                            <h3>Cows!</h3>

                            
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
                            <h3>Pigs!</h3>

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
                <div id="chicken-spotlight">
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
                        <h3><?php the_title(); ?></h3>
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
                                    $cat = get_query_var( 'cat' );
                                    $args = array(
                                        'post_type' => 'chickens',
                                        'order' => 'DSC',
                                        'posts_per_page' => 6,
                                        //'offset' => 1,
                                        'cat' => $cat
                                    );
                                    $query = new WP_Query($args);                
                                    if($query->have_posts()) : ?><?php while($query->have_posts()) : $query->the_post(); 
                                ?>
                                    <div class="chicken-link" title="<?php the_title(); ?>">
                                        <a href="#" data-post-id="<?php the_ID(); ?>"><?php the_post_thumbnail('small'); ?></a>
                                    </div>
                                <?php
                                    endwhile; endif;
                                    //wp_reset_query();
                                ?>
                            </div>

                            <!-- <p class="carousel-ctrl" style="cursor:pointer;">
                                <span class="carousel-back">&lsaquo; Back</span> | <span class="carousel-next">Next &rsaquo;</span>
                            </p> -->

                            <p id="carouselPages" aria-live="polite" aria-label="Use these buttons to page through the previously featured chicken">
                                <?php
                                $big = 999999999; // need an unlikely integer
                                $pagination = paginate_links( array(
                                    'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                                    'format' => '?paged=%#%',
                                    'current' => max( 1, get_query_var('paged') ),
                                    'total' => $query->max_num_pages,
                                    'show_all' => 'True'
                                    ) );
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

                        // set up the function to page through carousel
                        function carouselNav(){
                            jQuery('#carousel-row').animate({'opacity': 0}, 'fast');
                            currentPage = parseInt( jQuery('.current').html() );

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

                            jQuery.get('<?php echo get_stylesheet_directory_uri() ?>/chicken-ajax.php', args, function(data){
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

                <?php
                    break;
                ?>










                <?php default: ?>
                    <?php if(have_posts()) : ?><?php while(have_posts()) : the_post(); ?>
                    <div class="post">
                    <!-- DEFAULT -->
                    <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
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
            else { ?>
                <?php
                    $cat = get_query_var( 'cat' );
                    $args = array(
                        'posts_per_page' => 1,
                        'cat' => $cat
                    );
                    $query = new WP_Query($args);
                    if( $query->have_posts()) : ?><?php while($query->have_posts() ) : $query->the_post();
                 ?>
                <div class="post">
                <!-- ELSE -->
                <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
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
