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
        autoload: false,
        confirmDeleting: true,
        deleteConfirm: "Are you sure?",
        data: jsonObject,
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
                //  loadGrid();
            });
            console.log(postData);
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
                valueField: "Id",
                textField: "Name",
                selectedIndex: -1,
                autosearch: true,
                validate: "required",
                items: [{
                        Name: "Tires",
                        Id: 1
                    },
                    {
                        Name: "Seat covers",
                        Id: 2
                    }
                ]

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
                ]
            },
            {
                name: "Is active",
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