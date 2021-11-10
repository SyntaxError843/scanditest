<?php

if ( ! empty( $product ) ) {

    ?>
    
    <label for="products_to_delete[<?php esc_html_e( $product->get_id() ) ?>]" class="w-2/12 cursor-pointer mr-6 relative rounded flex flex-col items-center content-center justify-center border-2 border-black py-12">
        <div class="absolute top-4 left-4"><input type="checkbox" class=".delete-checkbox" id="products_to_delete[<?php esc_html_e( $product->get_id() ) ?>]" name="products_to_delete[<?php esc_html_e( $product->get_id() ) ?>]"></div>
        <div><?php esc_html_e( $product->get_sku() ) ?></div>
        <div><?php esc_html_e( $product->get_name() ) ?></div>
        <div><?php esc_html_e( $product->get_display_price() ) ?></div>
        <div><?php esc_html_e( ucwords( $product->get_attributes()->get_name() ) ) ?>: <?php esc_html_e( $product->get_attributes()->get_value() ) ?></div>
    </label>

    <?php

}