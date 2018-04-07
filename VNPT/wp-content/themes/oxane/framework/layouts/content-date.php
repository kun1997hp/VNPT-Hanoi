<?php
/**
 * @package Oxane
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('date grid_2_column col-md-6 col-sm-6 col-xs-12'); ?>>


    <div class="featured-thumb col-md-12 col-sm-12 col-xs-12">
        <?php if (has_post_thumbnail()) : ?>
            <a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail('large'); ?></a>
        <?php else: ?>
            <a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><img src="<?php echo get_template_directory_uri()."/assets/images/placeholder2.jpg"; ?>"></a>
        <?php endif; ?>
    </div><!--.featured-thumb-->

    <div class="out-thumb col-md-12 col-sm-12 col-xs-12">
        <div class="postedon col-md-2 col-sm-2 col-xs-2">
            <div class="date"><?php echo get_the_time( 'j' ); ?></div>
            <div class="month"><?php echo get_the_time( 'M' ); ?></div>
            <div class="year"><?php echo get_the_time( 'Y' ); ?></div>
        </div>
        <div class="content col-md-10 col-sm-10 col-xs-10">
            <header class="entry-header">
                <h1 class="entry-title title-font"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
            </header><!-- .entry-header -->
            <div class="category"><?php the_category(); ?></div>
        </div>
    </div>



</article><!-- #post-## -->