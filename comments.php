<?php
/* If a post password is required or no comments are given and comments/pings are closed, return. */
if ( post_password_required() || ( !have_comments() && !comments_open() && !pings_open() ) )
        return;

if ( comments_open() ) { ?>

    <section id="comments" class="comments">
        <div class="comments-number">
            <h3>
                <?php comments_number( __( 'Be First to Comment', 'ct_replace_me' ), __( 'One Comment', 'ct_replace_me'), __( '% Comments', 'ct_replace_me' ) ); ?>
            </h3>
        </div>
            <ol class="comment-list">
                    <?php wp_list_comments(array( 'callback'=>'ct_customize_comments', 'max_depth'=>'7') ); ?>
            </ol><!-- .comment-list -->
            <?php    
            if( (get_option('page_comments') == 1) && (get_comment_pages_count() > 1) ) { ?>
                <nav class="comment-pagination">
                    <p class="prev"><?php previous_comments_link("" . ct_left_arrows_svg() . " Older Comments"); ?></p><p class="next"><?php next_comments_link("Newer Comments" . ct_right_arrows_svg() . ""); ?></p>
                </nav>
            <?php } ?>
            <?php comment_form(); ?>       
<?php 
} elseif(!comments_open() && have_comments() && pings_open() ) { ?>
    <section id="comments" class="comments">
        <div class="comments-number">
            <h3>
<?php comments_number( __( 'Be First to Comment', 'ct_replace_me' ), __( 'One Comment', 'ct_replace_me'), __( '% Comments', 'ct_replace_me' ) ); ?>
            </h3>
        </div>
            <ol class="comment-list">
                    <?php wp_list_comments(array( 'callback'=>'ct_customize_comments', 'max_depth'=>'3') ); ?>
            </ol><!-- .comment-list -->
            <?php    
            if( (get_option('page_comments') == 1) && (get_comment_pages_count() > 1) ) { ?>
                <nav class="comment-pagination">
                    <p class="prev"><?php previous_comments_link("" . ct_left_arrows_svg() . " Older Comments"); ?></p><p class="next"><?php next_comments_link("Newer Comments" . ct_right_arrows_svg() . ""); ?></p>
                </nav>
            <?php } ?>
            <p class="comments-closed pings-open">
                    <?php printf( __( 'Comments are closed, but <a href="%s" title="Trackback URL for this post">trackbacks</a> and pingbacks are open.', 'ct_replace_me' ), esc_url( get_trackback_url() ) ); ?>
            </p><!-- .comments-closed .pings-open -->
<?php
} elseif ( !comments_open() && have_comments() ) { ?>
    <section id="comments" class="comments">
        <div class="comments-number">
            <h3>
<?php comments_number( __( 'Be First to Comment', 'ct_replace_me' ), __( 'One Comment', 'ct_replace_me'), __( '% Comments', 'ct_replace_me' ) ); ?>
            </h3>
        </div>
            <ol class="comment-list">
                    <?php wp_list_comments(array( 'callback'=>'ct_customize_comments', 'max_depth'=>'3') ); ?>
            </ol><!-- .comment-list -->
            <?php    
            if( (get_option('page_comments') == 1) && (get_comment_pages_count() > 1) ) { ?>
                <nav class="comment-pagination">
                    <p class="prev"><?php previous_comments_link("" . ct_left_arrows_svg() . " Older Comments"); ?></p><p class="next"><?php next_comments_link("Newer Comments" . ct_right_arrows_svg() . ""); ?></p>
                </nav>
            <?php } ?>
            <p class="comments-closed">
                <?php _e( 'Comments are closed.', 'ct_replace_me' ); ?>
            </p><!-- .comments-closed -->
<?php 
} else { ?>

    <p class="comments-closed">
            <?php _e( 'Comments are closed.', 'ct_replace_me' ); ?>
    </p><!-- .comments-closed -->

<?php } ?>
  
    </section><!-- #comments -->