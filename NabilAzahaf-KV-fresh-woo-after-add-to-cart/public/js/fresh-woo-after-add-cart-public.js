;(function ($) {
  "use strict"
  jQuery(document.body).on(
    "added_to_cart",
    function (event, fragments, cart_hash, $button) {
      var product_qty = 1
      var product_id = $button.data("product_id")
      var variation_id = $button.data("variation_id")

      if (!product_id) {
        var $form = $button.closest("form.cart")
        var id = $button.val()
        var product_id = $form.find("input[name=product_id]").val() || id
        var variation_id = $form.find("input[name=variation_id]").val() || 0
      }

      if (!product_id) {
        return
      }

      var data = {
        action: "fresh_woo_after_add_cart_after_add_to_cart",
        product_id: product_id,
        variation_id: variation_id,
        product_qty: product_qty,
      }

      jQuery.ajax({
        type: "post",
        url: localized.ajax_url,
        data: data,
        success: function (response) {
          jQuery("body").append(response)
          show_fresh_woo_after_add_cart()
        },
      })
    }
  )

  jQuery(document).ready(function ($) {
    $(document).on(
      "click",
      ".fresh-woo-after-add-cart-add-to-cart-btn",
      function (e) {
        e.preventDefault()
        var $add_to_cart_btn = $(this)
        var product_qty = 1
        var product_id = $add_to_cart_btn.data("product-id")
        var variation_id = $add_to_cart_btn.data("variation-id")

        var data = {
          action: "add_to_cart_fresh-woo-after-add-cart",
          product_id: product_id,
          quantity: product_qty,
          variation_id: variation_id,
        }

        $.ajax({
          type: "post",
          url: wc_add_to_cart_params.ajax_url,
          data: data,
          beforeSend: function (response) {
            $addToCartBtnEl.removeClass("added").addClass("loading")
          },
          complete: function (response) {
            $addToCartBtnEl.addClass("added").removeClass("loading")
          },
          success: function (response) {
            if (response.error & response.product_url) {
              window.location = response.product_url
              return
            } else {
              $addToCartBtnEl.addClass("added")
              $(document.body).trigger("added_to_cart", [
                response.fragments,
                response.cart_hash,
                $addToCartBtnEl,
              ])
            }
          },
        })
      }
    )
  })
})(jQuery)

function show_fresh_woo_after_add_cart() {
  jQuery("#fresh-woo-after-add-cart").addClass("show")
  jQuery(".fresh-woo-after-add-cart-overlay").on("click", function (e) {
    if (e.target != this) return
    hide_fresh_woo_after_add_cart()
  })
  jQuery("body").addClass("fresh-woo-after-add-cart-popup-show")
  new Swiper(".swiper.products", {
    slidesPerView: "auto",
    spaceBetween: 30,
  })
}

function hide_fresh_woo_after_add_cart() {
  jQuery("#fresh-woo-after-add-cart").removeClass("show")
  jQuery("#fresh-woo-after-add-cart").remove()
  jQuery("body").removeClass("fresh-woo-after-add-cart-popup-show")
}
