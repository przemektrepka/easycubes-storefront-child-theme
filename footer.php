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

  <footer id="colophon" class="site-footer" role="contentinfo">
    <div class="container">
      <?php
      /**
       * Functions hooked in to storefront_footer action
       *
       * @hooked storefront_footer_widgets - 10
       * @hooked storefront_footer_nav         - 20
       */
      do_action( 'storefront_child_footer' );
      ?>
    </div>
  </footer><!-- #colophon -->

  <?php wp_footer(); ?>
  <?php do_action( 'storefront_child__footer_fixed_overlay' ); ?>

	<?php do_action( 'storefront_after_footer' ); ?>

</body>
</html>
