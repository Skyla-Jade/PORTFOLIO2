<?php gracey_core_template_part( 'plugins/woocommerce/widgets/dropdown-cart', 'templates/parts/opener' ); ?>
<?php if ( is_object( WC()->cart ) ) { ?>
	<div class="qodef-m-dropdown">
		<div class="qodef-m-dropdown-inner">
			<?php
			// Hook to include additional content before cart items
			do_action( 'gracey_core_action_woocommerce_before_side_area_cart_content' );
			
			if ( ! WC()->cart->is_empty() ) {
				gracey_core_template_part( 'plugins/woocommerce/widgets/dropdown-cart', 'templates/parts/loop' );
				
				gracey_core_template_part( 'plugins/woocommerce/widgets/dropdown-cart', 'templates/parts/order-details' );
				
				gracey_core_template_part( 'plugins/woocommerce/widgets/dropdown-cart', 'templates/parts/button' );
			} else {
				// Include posts not found
				gracey_core_template_part( 'plugins/woocommerce/widgets/dropdown-cart', 'templates/parts/posts-not-found' );
			}
			?>
		</div>
	</div>
<?php } ?>
