<?php
/**
 * Comments template.
 *
 * @package EuMilitar
 */

if ( post_password_required() ) {
	return;
}
?>

<section id="comments" class="comments-area">
	<?php if ( have_comments() ) : ?>
		<header class="comments-area__header">
			<span class="ds-badge ds-badge--brand"><?php esc_html_e( 'Discussão', 'eumilitar-neo-brutalism-wordpress-theme' ); ?></span>
			<h2 class="comments-title">
				<?php
				printf(
					/* translators: 1: number of comments, 2: post title. */
					esc_html( _nx( '%1$s comentário em %2$s', '%1$s comentários em %2$s', get_comments_number(), 'comments title', 'eumilitar-neo-brutalism-wordpress-theme' ) ),
					esc_html( number_format_i18n( get_comments_number() ) ),
					'<span>' . esc_html( get_the_title() ) . '</span>'
				);
				?>
			</h2>
		</header>

		<ol class="comment-list">
			<?php
			wp_list_comments(
				array(
					'avatar_size' => 56,
					'short_ping'  => true,
					'style'       => 'ol',
				)
			);
			?>
		</ol>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
			<nav class="comments-pagination ds-pagination" aria-label="<?php esc_attr_e( 'Paginação de comentários', 'eumilitar-neo-brutalism-wordpress-theme' ); ?>">
				<?php
				paginate_comments_links(
					array(
						'next_text' => esc_html__( 'Comentários recentes', 'eumilitar-neo-brutalism-wordpress-theme' ),
						'prev_text' => esc_html__( 'Comentários anteriores', 'eumilitar-neo-brutalism-wordpress-theme' ),
					)
				);
				?>
			</nav>
		<?php endif; ?>
	<?php endif; ?>

	<?php if ( ! comments_open() && get_comments_number() ) : ?>
		<p class="comments-closed"><?php esc_html_e( 'Comentários encerrados para este artigo.', 'eumilitar-neo-brutalism-wordpress-theme' ); ?></p>
	<?php endif; ?>

	<?php
	comment_form(
		array(
			'class_form'         => 'comment-form',
			'class_submit'       => 'ds-button ds-button--primary comment-form__submit',
			'label_submit'       => esc_html__( 'Publicar comentário', 'eumilitar-neo-brutalism-wordpress-theme' ),
			'title_reply'        => esc_html__( 'Deixe um comentário', 'eumilitar-neo-brutalism-wordpress-theme' ),
			'title_reply_before' => '<h2 id="reply-title" class="comment-reply-title">',
			'title_reply_after'  => '</h2>',
		)
	);
	?>
</section>
