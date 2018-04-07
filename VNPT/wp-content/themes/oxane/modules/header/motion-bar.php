<?php if(get_theme_mod('oxane_motionbar_title_set') && get_theme_mod('oxane_motionbar_content_cat') !=''):?>
<div id="motion-bar">
    <div class="container m-container">
        <?php if(get_theme_mod('oxane_motionbar_title_set')):?>
            <div class="motion-head">
                <h4><?php echo get_theme_mod('oxane_motionbar_title_set'); ?></h4>
            </div>
        <?php endif ;?>
        <div class="motion-content">
            <ul id="m-ticker">
                <?php
                $args = array(
                    'post_type' => 'post',
                    'posts_per_page' => 4,
                    'cat'  => esc_html( get_theme_mod('oxane_motionbar_content_cat',0) ),
                    'ignore_sticky_posts' => 1,
                );
                $loop = new WP_Query( $args );
                while ( $loop->have_posts() ) :
                    $loop->the_post(); ?>
                <li>
                    <i class="fa fa-<?php echo get_theme_mod('oxane_motionbar_separator_fa'); ?>"></i><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </li>
                <?php endwhile;?>
                <?php wp_reset_query(); ?>
            </ul>
        </div>
    </div>
</div>
<?php endif;?>

