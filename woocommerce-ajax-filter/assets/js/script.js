
// handler
// Sends the selected parameters (category and sorting) to AJAX request.
jQuery(document).ready(function($) {
    $(document).on('submit', '#waf-filter-form', function(e) {
        e.preventDefault();

        var category = $('#waf-category').val();
        var sort = $('#waf-sort').val();

        $.ajax({
            url: waf_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'waf_filter_products',
                category: category,
                sort: sort
            },
            success: function(response) {
                // only update the contents of the goods without deleting the container.
                $('.product-list').html(response);
            },
            error: function(response) {
                console.log('Errore:', response);
            }
        });

    });
});


