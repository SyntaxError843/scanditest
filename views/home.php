<?php

/**
 * Exit if accessed directly
 */
! defined( 'ABSPATH' ) && exit();

$title = 'Product List';

ob_start();

?>

<form action="/delete-product" method="post">
<?php set_csrf(); ?>
    <div class="w-full px-12">
        <div class="flex w-full pt-6 pb-2 border-b-2">
            <h1 class="text-2xl mr-auto">Product List</h1>
            <div class="ml-auto uppercase">
                <a href="/add-product" class="mr-4 rounded border-2 border-black px-2 py-1 shadow-md cursor-pointer hover:bg-gray-100 transition">add</a>
                <button id="delete-product-btn" class="mr-4 uppercase rounded border-2 border-black px-2 py-1 shadow-md cursor-pointer hover:bg-gray-100 transition">mass delete</button>
            </div>
        </div>

        <div class="w-full flex items-center content-center pt-6">
            <?php if ( ! empty( $products ) ) {

                foreach( $products as $product ) {

                    require ABSPATH . 'templates/partials/_product.php';

                }

            } else {

                ?>No products available,&nbsp;<a href="/add-product" class="text-blue-400 mr-auto hover:text-blue-300 cursor-pointer transition underline">add new?</a><?php

            } ?>
        </div>
    </div>
</form>

<?php

$body = ob_get_clean();

require_once ABSPATH . 'templates/base.php';