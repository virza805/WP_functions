
<?php

// add to cart ajax 
add_action('wp_footer', 'get_fetch_price_script');
function get_fetch_price_script(){
    $ajax_nonce = wp_create_nonce( 'add_to_cart_nonce' );
?>
<script type="text/javascript" charset="UTF-8">

 // submit single_add_to_cart_button
jQuery(document).ready(function() {
    jQuery('.single_add_to_cart_button').on('click', function(e) {
        e.preventDefault();

        let form = jQuery("form.cart");
        form.block({ message: null, overlayCSS: { background: '#fff', opacity: 0.6 } });
        
        if(jQuery(this).closest('button').attr('name')) {
            jQuery(form).append(
                jQuery("<input type='hidden'>").attr( { 
                    name: jQuery(this).attr('name'), 
                    value: jQuery(this).attr('value') })
            );
        }

        let formData   = jQuery(this).closest('form.cart').serialize();
        let urlForm    = jQuery(this).closest('form.cart').attr("action");
        
        // WP Ajax Call with submit function | echo admin_url('admin-ajax.php')
        jQuery.ajax({
            type: 'POST',
            url: urlForm,
            data: formData,
            success: function(response) {
                
                jQuery(document.body).trigger('wc_fragment_refresh');
                form.unblock();

                // Create a jQuery object from the response
                let $response            = jQuery(response);
                let $desiredSection      = $response.find('.woocommerce-notices-wrapper');
                let notification_massage = $desiredSection.html();

                jQuery(document.body).find('.woocommerce-notices-wrapper').html(notification_massage);
                // console.log(notification_massage);
                
            }
        });

    });
});

</script>
<?php 
}

