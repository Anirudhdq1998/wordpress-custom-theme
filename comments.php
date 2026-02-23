<?php
if ( post_password_required() ) {
    return;
}
?>

<div id="comments" class="comments-area">

    <?php if ( have_comments() ) : ?>

        <h2 class="comments-title">
            <?php
            $count = get_comments_number();
            printf(
                esc_html( _nx( '%1$s comment', '%1$s comments', $count, 'comments title', 'mytheme' ) ),
                number_format_i18n( $count )
            );
            ?>
        </h2>

        <ol class="comment-list">
            <?php
            wp_list_comments( array(
                'style'      => 'ol',
                'short_ping' => true,
                'avatar_size'=> 40,
            ) );
            ?>
        </ol>

        <?php mytheme_pagination(); ?>

    <?php endif; ?>

    <?php comment_form(); ?>

</div><!-- #comments -->
