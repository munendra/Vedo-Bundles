jQuery(document).ready(function () {
    data = {
        action: 'vedoBundles_getall'
    };
    jQuery.get("../wp-admin/admin-ajax.php", data, function (response) {
        console.log(response);
    });

    jQuery('#btnFilterVideo').click(function () {
        _data = {
            action: 'vedoBundles_filter',
            categoryId: jQuery('#categoryId').val(),
            vandorId: jQuery('#vandorId').val()
        };
        jQuery.get("../wp-admin/admin-ajax.php", _data, function (response) {
            console.log(response);
        });
    });
});



