<?php
function adminVedoPage()
{?>


    <div class="videoList-admin-Wrapper">
    <h3>Video list</h3>
        <div id="videoList"></div>
        <div id='loading' >
          <img src="<?php echo plugins_url('../assets/images/ajax-loader.gif', __FILE__) ?>">
        </div>
    </div>



<?php
}