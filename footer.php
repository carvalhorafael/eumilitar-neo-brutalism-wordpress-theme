<?php
/**
 * Theme footer.
 *
 * @package EuMilitar
 */

?>
	<footer class="site-footer">
		<?php eumilitar_render_widget_area( 'site-footer' ); ?>
		<p class="site-footer__text">
			<?php echo esc_html( get_bloginfo( 'name' ) ); ?>
		</p>
	</footer>
</div>
<?php wp_footer(); ?>
</body>
</html>
