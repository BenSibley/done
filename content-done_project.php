<?php

if( is_home() ) { ?>
    <div class='excerpt <?php hybrid_post_class(); ct_contains_featured(); ?>'>
        <div>
            <div class='excerpt-header'>
                <div class='excerpt-date'>
                    <?php echo get_the_date('F jS, Y'); ?>
                </div>
                <h1 class='excerpt-title'>
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </h1>
            </div>
            <div class="featured-image-container">
                <a href="<?php the_permalink(); ?>">
                    <?php ct_featured_image(); ?>
                    <span>read more <?php echo ct_right_arrows_svg(); ?></span>
                </a>
            </div>
            <div class='excerpt-content'>
                <article>
                    <?php ct_excerpt(); ?>
                </article>
            </div>
        </div>
    </div>
<?php
} elseif( is_single() ) { ?>
    <div class='entry <?php hybrid_post_class(); ct_contains_featured(); ?>'>
        <div class='entry-header'>
            <?php ct_featured_image(); ?>
            <div class="title-container">
                <p class="entry-author entry-client-top">
                    <?php echo get_post_meta( $post->ID, 'ct-done-project-client-meta-box', true ); ?>
                </p>
                <h1 class='entry-title'><?php the_title(); ?></h1>
            </div>
        </div>
        <div class="entry-content">
            <article>
                <?php the_content(); ?>
                <?php wp_link_pages(array('before' => '<p class="singular-pagination">' . __('Pages:','ct_replace_me'), 'after' => '</p>', ) ); ?>
            </article>
        </div>
        <div class='entry-meta'>
            <?php ct_project_client_display(); ?>
            <?php ct_project_date_display(); ?>
            <?php ct_project_category_display(); ?>
        </div>
        <div class="author-meta">
            <?php echo get_avatar( get_the_author_meta( 'ID' ), 120 );?>
            <div class="name-container">
                <h3><a href="<?php the_author_meta('user_url'); ?>"><?php the_author(); ?></a></h3>
                <span><?php the_author_meta('ct-job-title'); ?></span>
            </div>
            <div class="author-social-icons">
                <?php ct_author_social_icons(); ?>
            </div>
            <p><?php echo get_the_author_meta('description'); ?></p>
        </div>
        <?php ct_further_reading(); ?>
    </div>
<?php
} else { ?>
    <div class='excerpt <?php hybrid_post_class(); ct_contains_featured(); ?>'>
        <div>
            <div class='excerpt-header'>
                <div class='excerpt-date'>
                    <?php echo get_the_date('F jS, Y'); ?>
                </div>
                <h1 class='excerpt-title'>
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </h1>
            </div>
            <div class="featured-image-container">
                <a href="<?php the_permalink(); ?>">
                    <?php ct_featured_image(); ?>
                    <span>read more <?php echo ct_right_arrows_svg(); ?></span>
                </a>
            </div>
            <div class='excerpt-content'>
                <article>
                    <?php ct_excerpt(); ?>
                </article>
            </div>
        </div>
    </div>
<?php
}

