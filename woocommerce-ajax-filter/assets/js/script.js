
// handler
// Sends the selected parameters (category and sorting) to AJAX request.
jQuery(document).ready(function($) {
    $('#waf-filter-form').on('submit', function(e) {
        e.preventDefault(); // Prevent page reloading

        var category = $('#waf-category').val();
        var sort = $('#waf-sort').val();

        $.ajax({
            url: waf_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'waf_filter_products',
                category: $('#waf-category').val(),
                sort: $('#waf-sort').val()
            },
            success: function(response) {
                $('.product-list').replaceWith(response);
                // console.log('Container reload');
            },
            error: function(response) {
                console.log('Errore:', response);
            }
        });

    });
});

