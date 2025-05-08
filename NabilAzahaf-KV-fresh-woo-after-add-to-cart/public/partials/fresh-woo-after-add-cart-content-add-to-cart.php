<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link        
 * @since      1.0.0
 *
 * @package    Popsicle
 * @subpackage Popsicle/public/partials
 */
?>


<div class='fresh-woo-after-add-cart-add-to-cart'>

    <div class='product-added'>

        <?php
        $product_name      = $data['added_product']->get_name();
        $variation      = $data['variation'];
        $thumbnail         = $data['added_product']->get_image();
        $product_price     = $data['added_product']->get_price_html();
        $product_permalink = $data['added_product']->get_permalink();
        ?>
        <div class='product-image'>
            <?php if (!empty($thumbnail)) : ?>
                <?php echo $thumbnail; ?>
            <?php endif; ?>
        </div>
        <div class='product-details'>
            <div class='product-title'>
                <?php echo '<p class=""><strong>' . wp_kses_post($product_name) . '</strong></p>'; ?>
                <?php echo "<p class='variation'>{$variation}</p>"; ?>
            </div>
            <div class='product-price'>
                <?php echo $product_price; ?>
            </div>
        </div>
    </div>

    <?php if (count($data['products']) > 0) : ?>
        <h3 class='fresh-woo-after-add-cart-add-to-cart-title'><?= __('You might also like:', 'fresh-woo-after-add-cart') ?></h3>
        <div class='products swiper'>
            <div class='swiper-wrapper'>
                <?php foreach ($data['products'] as $cross_sell_product) : ?>

                    <?php
                    $product_name      = $cross_sell_product->get_name();
                    $thumbnail         = $cross_sell_product->get_image();
                    $product_price     = $cross_sell_product->get_price_html();
                    $product_permalink = $cross_sell_product->get_permalink();
                    ?>

                    <div class='product swiper-slide'>

                        <div class='product-image'>
                            <?= $cross_sell_product->get_image() ?>
                        </div>
                        <div class="product-details">
                            <div class='product-title'>
                                <?php echo '<p class=""><strong>' . wp_kses_post($product_name) . '</strong></p>'; ?>
                            </div>
                            <p class='product-price'>
                                <?= $cross_sell_product->get_price_html(); ?>
                            </p>
                            <?php if ($cross_sell_product->is_type('simple')) : ?>
                                <a class='fresh-woo-after-add-cart-button single_add_to_cart button' href='<?= $cross_sell_product->add_to_cart_url() ?>'>
                                    <img width="15" height="20" src="/wp-content/plugins/fresh-woo-after-add-cart/public/images/icon-cart-white.svg">
                                    <?= __('add to cart', 'fresh-woo-after-add-cart') ?>
                                </a>
                            <?php else : ?>
                                <a class='fresh-woo-after-add-cart-button single_add_to_cart button' href='<?= $cross_sell_product->add_to_cart_url() ?>'>
                                    <img width="15" height="20" src="/wp-content/plugins/fresh-woo-after-add-cart/public/images/icon-cart-white.svg">
                                    <?= __('view options', 'fresh-woo-after-add-cart') ?>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</div>