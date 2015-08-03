<?php

if( !class_exists( 'FWWL_Wishlist' ) ) {
	
	class FWWL_Wishlist {

		function FWWL_Wishlist() {}

		function product_in_wishlist( $product_id, $user_id ) {

			global $wpdb;

			$item =  $wpdb->get_var( 'SELECT product_id FROM ' . FWWL::$table_name . ' WHERE user_id = ' . $user_id . ' AND product_id = ' . $product_id );

			if( $item == NULL ) {
				return false;
			} else {
				return true;
			}

		}	

		function show_button( $product_id ) {
			?>

			<div class="summary">
				<a href="#" class="fwwl-btn" data-product="<?php echo $product_id; ?>"><?php _e( 'Add to my wishlist', 'fwwl' ); ?></a>
			</div>
			
			<?php
		}	

		function add_product_to_wishlist( $product_id, $user_id ) {

			global $wpdb;

			$result = $wpdb->insert( 
				FWWL::$table_name, 
				array( 
					'product_id' => $product_id, 
					'user_id' => $user_id
				), 
				array( 
					'%d', 
					'%d' 
				) 
			);

			if( !$result ) {
				return false;
			} else {
				return true;
			}

		}	

		function render_list( $user_id ) {

			global $wpdb;

			$items =  $wpdb->get_results( 'SELECT product_id FROM ' . FWWL::$table_name . ' WHERE user_id = ' . $user_id );

			if( count( $items ) > 0 ) {
				echo '<table class="fwwl-table"><thead><tr><th colspan="2">' . __( 'Product', 'fwwl' ) . '</th>';
				echo '<th>' . __( 'Price', 'fwwl' ) . '</th></tr></thead><tbody>';
				foreach( $items as $item ) {
					$the_post = get_post( $item->product_id );
					$the_product = new WC_Product( $item->product_id );
					$product_name = $the_post->post_title;
					$product_thumbnail = get_the_post_thumbnail( $item->product_id, 'thumbnail' );
					$product_price = $the_product->get_price_html();
					$product_permalink = get_the_permalink( $item->product_id );
					echo '<tr><td><a href="' . $product_permalink . '">' . $product_thumbnail . '</a></td><td><a href="' . $product_permalink . '">' . $product_name . '</a></td><td>' . $product_price . '</td></tr>';
				}
				echo '</tbody></table>';
			} else {
				echo '<h3>' . __( 'Your wishlist is empty', 'fwwl' ) . '</h3>';
			}

		}	

		function remove_product_from_wishlist( $product_id ) {
			
			global $wpdb;

			$result = $wpdb->delete( 
				FWWL::$table_name, 
				array( 
					'product_id' => $product_id
				), 
				array( 
					'%d'
				) 
			);

			if( !$result ) {
				return false;
			} else {
				return true;
			}			
		
		}		

	}

}