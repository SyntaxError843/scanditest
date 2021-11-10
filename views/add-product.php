<?php

/**
 * Exit if accessed directly
 */
! defined( 'ABSPATH' ) && exit();

$title = 'Product Add';

ob_start();

?>

<form action="/add-product" method="post" id="product-form">
<?php set_csrf(); ?>
    <div class="w-full px-12">
        <div class="flex w-full pt-6 pb-2 border-b-2">
            <h1 class="text-2xl mr-auto">Product Add</h1>
            <div class="ml-auto capitalize">
                <button class="capitalize rounded leading-tight mr-4 border-2 border-black px-3 py-1 shadow-md cursor-pointer hover:bg-gray-100 transition">save</button>
                <a href="/" class="mr-4 leading-tight rounded border-2 border-black px-3 py-1 shadow-md cursor-pointer hover:bg-gray-100 transition">cancel</a>
            </div>
        </div>

        <div class="w-full pt-6">
            <div class="flex w-5/12 flex flex-col content-center items-center">
                <div class="w-full flex justify-between mb-4">
                    <label class="cursor-pointer" for="sku">SKU</label>
                    <input class="rounded border-2 border-black px-2" type="text" maxlength="255" name="sku" id="sku" required>
                </div>
                <div class="w-full flex justify-between mb-4">
                    <label class="cursor-pointer" for="name">Name</label>
                    <input class="rounded border-2 border-black px-2" type="text" maxlength="255" name="name" id="name" required>
                </div>
                <div class="w-full flex justify-between mb-4">
                    <label class="cursor-pointer" for="price">Price ($)</label>
                    <input class="rounded border-2 border-black px-2" type="number" min="0" step="0.01" name="price" id="price" required>
                </div>
            </div>
        </div>

        <div class="w-full pt-6">
            <div class="flex w-5/12 flex flex-col content-center items-center">
                <div class="w-full flex items-center content-center justify-between mb-4">
                    <label class="cursor-pointer" for="productType">Type Switcher</label>
                    <select class="w-6/12 py-2 border-2 rounded border-black bg-white" name="product_type" id="productType">
                        <option value="DVD">DVD</option>
                        <option value="Furniture">Furniture</option>
                        <option value="Book">Book</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="w-full pt-6">
            <div id="DVD" class="flex w-5/12 border-2 border-black rounded p-4 flex flex-col content-center items-center">
                <div class="w-full flex justify-between mb-4">
                    <label class="cursor-pointer" for="size">Size (MB)</label>
                    <input class="rounded border-2 border-black px-2" type="number" min="0" name="size" id="size" required>
                </div>
                <div class="text-sm italic">Please provide size in MB</div>
            </div>
            <div id="Furniture" class="flex hidden w-5/12 border-2 border-black rounded p-4 flex flex-col content-center items-center">
                <div class="w-full flex justify-between mb-4">
                    <label class="cursor-pointer" for="height">Height (CM)</label>
                    <input class="rounded border-2 border-black px-2" type="number" min="0" name="height" id="height" required>
                </div>
                <div class="w-full flex justify-between mb-4">
                    <label class="cursor-pointer" for="width">width (CM)</label>
                    <input class="rounded border-2 border-black px-2" type="number" min="0" name="width" id="width" required>
                </div>
                <div class="w-full flex justify-between mb-4">
                    <label class="cursor-pointer" for="length">length (CM)</label>
                    <input class="rounded border-2 border-black px-2" type="number" min="0" name="length" id="length" required>
                </div>
                <div class="text-sm italic">Please provide dimensions in HxWxL format</div>
            </div>
            <div id="Book" class="flex hidden w-5/12 border-2 border-black rounded p-4 flex flex-col content-center items-center">
                <div class="w-full flex justify-between mb-4">
                    <label class="cursor-pointer" for="weight">Weight (KG)</label>
                    <input class="rounded border-2 border-black px-2" type="number" min="0" name="weight" id="weight" required>
                </div>
                <div class="text-sm italic">Please provide weight in KG</div>
            </div>
        </div>
    </div>
</form>

<script src="<?php print( 'public/js/product-add-form.js' ) ?>"></script>

<?php

$body = ob_get_clean();

require_once ABSPATH . 'templates/base.php';