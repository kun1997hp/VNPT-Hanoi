<div class="searchform">
    <?php if(get_theme_mod('oxane_replace_search_bar')): ?>
        <?php if(get_theme_mod('oxane_short_menu')): ?>
            <div class="short-menu">
                    <?php
                    // Get the Appropriate Walker First.
                    $walker = has_nav_menu('short') ? new Oxane_Menu_With_Icon : '';
                    //Display the Menu.
                    wp_nav_menu( array( 'theme_location' => 'short', 'walker' => $walker ) ); ?>
            </div>
        <?php elseif('oxane_mobile_text'): ?>
            <div id="top_bar">
                <div class="contact">
                    <i class="fa fa-envelope"><p><?php echo get_theme_mod('oxane_email_text'); ?></p></i>
                </div>
                <div class="contact">
                    <i class="fa fa-mobile"><p><?php echo get_theme_mod('oxane_mobile_text'); ?></p></i>
                </div>
            </div>
        <?php endif; ?>
    <?php else: ?>
        <form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url( '/' )); ?>">
            <label>
                <span class="screen-reader-text"><?php echo _x( 'Search for:', 'label', 'oxane' ) ?></span>
                <input type="search" class="search-field" placeholder="<?php echo esc_attr_x( 'Search...', 'placeholder', 'oxane' ) ?>" value="<?php echo get_search_query() ?>" name="s" title="<?php echo esc_attr_x( 'Search for:', 'label', 'oxane' ) ?>" />
                <button><i class="fa fa-search"></i></button>
            </label>
        </form>
    <?php endif; ?>

</div>