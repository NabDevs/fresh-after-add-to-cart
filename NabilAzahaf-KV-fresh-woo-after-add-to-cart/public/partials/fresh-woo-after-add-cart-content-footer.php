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

<div class='fresh-woo-after-add-cart-footer'>
    <?php foreach ($buttons as $button) : ?>
        <?php if ($button['type'] == 'action') : ?>
            <a class='fresh-woo-after-add-cart-button' href="<?= $button['action'] ?>"><?= __($button['text'], 'fresh-woo-after-add-cart') ?></a>
        <?php elseif ($button['type'] == 'close') : ?>
            <a class='fresh-woo-after-add-cart-button fresh-woo-after-add-cart-button-outline' href="#" onclick="hide_fresh_woo_after_add_cart()"><?= __($button['text'], 'fresh-woo-after-add-cart') ?></a>
        <?php endif; ?>
    <?php endforeach; ?>
</div>