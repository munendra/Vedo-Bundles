jQuery(document).ready(function () {
    data = {
        action: 'vedoBundles_getall'
    };
    jQuery.get("../wp-admin/admin-ajax.php", data, function (response) {
        initGrid(response);
    });
});
jQuery(function () {
    var loading = jQuery("#loading");
    jQuery(document).ajaxStart(function () {
        loading.show();
    });

    jQuery(document).ajaxStop(function () {
        loading.hide();
    });

});
function loadGrid() {
    data = {
        action: 'vedoBundles_getall'
    };
    jQuery.get("admin-ajax.php", data, function (response) {
        initGrid(response);
    });
}

function initGrid(data) {
    var jsonObject = JSON.parse(data);
    jQuery("#videoList").jsGrid({
        width: "100%",
        pageSize: 20,
        filtering: false,
        editing: true,
        sorting: true,
        paging: true,
        inserting: true,
        loadIndication: true,
        loadIndicationDelay: 500,
        loadMessage: "Please, wait...",
        loadShading: true,
        autoload: false,
        confirmDeleting: true,
        deleteConfirm: "Are you sure?",
        data: jsonObject.videoList,
        onItemDeleted: function (deletedRow) {
            jQuery.get("admin-ajax.php?action=vedoBundles_delete&id=" + deletedRow.item.id, function () {
                loadGrid();
            });
        },
        onItemInserted: function (data) {
            var postData = {
                action: 'vedoBundles_add',
                data: data.item
            };
            jQuery.post("admin-ajax.php", postData, function () {
                loadGrid();
            });

        },
        onItemUpdated: function (data) {
            var postData = {
                action: 'vedoBundles_update',
                data: data.item
            };
            jQuery.post("admin-ajax.php", postData, function () {
                loadGrid();
            });
        },
        fields: [{
            name: "Url",
            title: "Video URL",
            type: "text",
            width: 100,
            validate: "required",
            itemTemplate: function (value, item) {
                return '<a title="' + item.Title + '" target="_blank" href="' + value + '">' + value + '</a>';
            }
        },
        {
            name: "ProductCategory",
            title: "Product category",
            type: "select",
            width: 100,
            align: "center",
            valueField: "term_id",
            textField: "name",
            selectedIndex: -1,
            autosearch: true,
            validate: "required",
            items: jsonObject.productCategories,
            itemTemplate: function (value, item) {
                var res = jsonObject.productCategories.filter(cat => cat.term_id == item.CategoryId);
                if (res.length > 0) {
                    return res[0].name;
                }
                else
                    return '';
            }
        },
        {
            name: "vendor",
            title: "Select vendor",
            type: "select",
            align: "center",
            width: 200,
            validate: "required",
            valueField: "id",
            textField: "display_name",
            selectedIndex: -1,
            autosearch: true,
            items: jsonObject.vendors,
            itemTemplate: function (value, item) {
                var res = jsonObject.vendors.filter(vendor => vendor.id == item.vendorId);
                if (res.length > 0) {
                    return res[0].display_name;
                }
                else
                    return '';
            }
        },
        {
            name: "Isactive",
            Title: "Is active",
            type: "checkbox",
            title: "Is active",
            sorting: false,
            validate: "required"
        },
        {
            type: "control"
        }
        ]
    });
}
