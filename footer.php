<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package storefront
 */

?>

		</div>

  <?php wp_footer(); ?>
  <?php do_action( 'storefront_child__footer_fixed_overlay' ); ?>

	<?php do_action( 'storefront_after_footer' ); ?>

</body>
</html>
