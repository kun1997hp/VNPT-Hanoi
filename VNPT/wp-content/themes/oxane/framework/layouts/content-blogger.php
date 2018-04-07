<?php
/**
 * @package Oxane
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('blogger col-md-12 col-sm-12 col-xs-12'); ?>>

    <div class="featured-thumb col-md-6 col-sm-6 col-xs-12">
        <?php if (has_post_thumbnail()) : ?>
            <a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail('large'); ?></a>
        <?php else: ?>
            <a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><img src="<?php echo get_template_directory_uri()."/assets/images/placeholder2.jpg"; ?>"></a>
        <?php endif; ?>
    </div><!--.featured-thumb-->

    <div class="out-thumb col-md-6 col-sm-6 col-xs-12">
        <div class="content">
            <header class="entry-header">
                <h1 class="entry-title title-font"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
            </header><!-- .entry-header -->
            <div class="postedon ">
                <div class="date "><?php echo get_the_time( 'l, M j, Y' ); ?></div>
            </div>
            <div class="entry-excerpt"><?php echo substr(get_the_excerpt(), 0, 100 ).(get_the_excerpt()?"...": ""); ?></div>
            <div class="read-cat">
                <div class="category hvr-curl-bottom-right"><?php the_category(); ?></div>
                <div class="read-more hvr-curl-bottom-right"><a href="<?php the_permalink(); ?>"><?php echo __('Read More', 'oxane');?></a></div>
            </div>
        </div>

    </div>



</article><!-- #post-## -->