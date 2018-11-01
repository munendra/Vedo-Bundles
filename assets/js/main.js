var _users;
jQuery(document).ready(function () {

    data = {
        action: 'vedoBundles_getall'
    };
    jQuery.get("../wp-admin/admin-ajax.php", data, function (response) {
        var res = JSON.parse(response);
        _users = res.vendors;
        renderVideos(res.videoList, res.vendors);
    });

    jQuery('#btnFilterVideo').click(function () {
        _data = {
            action: 'vedoBundles_filter',
            categoryId: jQuery('#categoryId').val(),
            vandorId: jQuery('#vandorId').val()
        };
        jQuery.get("../wp-admin/admin-ajax.php", _data, function (response) {
            renderVideos(JSON.parse(response), _users);
        });
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

function renderVideos(videos, users) {
    var html = "<div class='video-row'>";
    for (i in videos) {
        var user = users.filter(u => u.id == videos[i].vendorId);
        
        html += ' <div class="videos-container">';
        html += '<div class="videos"><iframe frameborder="0" allow="autoplay; encrypted-media" allowfullscreen width="100%" src="' + videos[i].Url + '"></iframe></div>';
        html += '<div class="vendor-info"><div class="vendor-name">' + user[0]['display_name'] + '</div>';
        html += '<p class="vendor-profile"><a href="#' + user[0]['id'] + '">View Profile</a></p></div>';
		html += "</div>";
    }
    html += "</div>";
    jQuery('#videos-list').html(html);
}



