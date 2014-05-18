<button id="toggle-navigation" class="toggle-navigation"><?php echo compete_themes_toggle_nav_svg(); ?></button>

<div id="menu-primary" class="menu-container menu-primary" role="navigation">

    <?php // get_search_form(); ?>

    <?php wp_nav_menu( array( 'theme_location' => 'primary', 'container' => 'false', 'menu_class' => 'menu-primary-items', 'menu_id' => 'menu-primary-items', 'items_wrap' => '<ul id="%1$s" class="%2$s" role="menubar">%3$s</ul>', 'fallback_cb' => 'compete_themes_wp_page_menu') ); ?>

</div><!-- #menu-primary .menu-container -->

<?php get_search_form(); ?>