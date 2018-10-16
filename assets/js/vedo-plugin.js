jQuery(document).ready(function () {
    jQuery("#videoList").jsGrid({
        width: "100%",
        pageSize: 20,
        filtering: false,
        editing: true,
        sorting: true,
        paging: true,
        inserting: true,
        data: db.clients,

        fields: [{
                name: "VideoUrl",
                title: "Video URL",
                type: "text",
                width: 100,
                validate: "required",
                itemTemplate: function (value) {
                    return '<a target="_blank" href="' + value + '">' + value + '</a>';
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
                        Name: "Cat 1",
                        Id: 1
                    },
                    {
                        Name: "Cat 2",
                        Id: 2
                    },
                    {
                        Name: "Cat 3",
                        Id: 3
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
                        Name: "car 1",
                        Id: 1
                    },
                    {
                        Name: "car 2",
                        Id: 2
                    },
                    {
                        Name: "car 3",
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

});