jQuery(document).ready(function () {
    data = {
        action: 'vedoBundles_getall'
    };
    jQuery.get("admin-ajax.php", data, function (response) {
        initGrid(response);
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
                return res[0].name;
            }
        },
        {
            name: "vendor",
            title: "Select vendor",
            type: "select",
            align: "center",
            width: 200,
            validate: "required",
            valueField: "Id",
            textField: "Name",
            selectedIndex: -1,
            autosearch: true,
            items: [{
                Name: "vendor 1",
                Id: 1
            },
            {
                Name: "vendor 2",
                Id: 2
            },
            {
                Name: "vendor 3",
                Id: 3
            }
            ],
            itemTemplate: function (value, item) {
                return item.vendorId;
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
function selectWhere(data, propertyName) {
    for (var i = 0; i < data.length; i++) {
        if (data[i][propertyName] !== null) return data[i][propertyName];
    }
    return null;
}