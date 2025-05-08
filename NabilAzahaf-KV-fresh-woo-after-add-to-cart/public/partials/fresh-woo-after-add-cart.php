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

<div id="fresh-woo-after-add-cart-add-to-cart">
    <div class='fresh-woo-after-add-cart-overlay'>
        <div class='fresh-woo-after-add-cart-content'>
            <div class='fresh-woo-after-add-cart-footer'>
                <?php foreach ($buttons as $button) : ?>
                    <a href="<?= $button['url'] ?>"><?= __($button['text'], 'fresh-woo-after-add-cart') ?></a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>