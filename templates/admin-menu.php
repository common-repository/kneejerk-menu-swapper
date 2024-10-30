<style type="text/css">
    .postbox.maxxer {
        max-width: 992px;
    }
    .text-green {
        color: green;
    }
    .text-red {
        color: red;
    }
</style>

<div id="wpbody" role="main">
    <div id="wpbody-content" aria-label="Main content" tabindex="0">
        <div class="wrap">
            <h1 class="wp-heading-inline"><img src="<?php echo \plugins_url( 'images/logo.svg', __DIR__ . '/../../' ) ?>" height="32" width="32" style="fill: rgb(35, 40, 45);margin-right:-8px;margin-bottom:-8px">neejerk Development Menu Swapper</h1>
            <hr>
            <h2 class="nav-tab-wrapper wp-clearfix">
                <a href="#kjd-config" id="kjd-config-nav" class="nav-tab nav-tab-active" data-tab="kjd-config-tab">Config</a>
                <a href="#kjd-about" id="kjd-about-nav" class="nav-tab" data-tab="kjd-about-tab">About</a>
            </h2>
            <div id="kjd-config-tab" class="kjd-display-content">
                <?php $this->view('config.php', $data); ?>
            </div>
            <div id="kjd-about-tab" class="kjd-display-content hidden">
                <?php $this->view('about.php', $data); ?>
            </div>
        </div>
    </div><!-- wpbody-content -->
</div>
<script type="text/javascript">
(function($) {
    // Save new Trial plan info
    var kjdNavigationTabs = $('.nav-tab');
    var kjdMenuSwapperForm = $('#kjd-menu-swapper-form');
    var kjdMenuSwapperSubmitBtn = $('#kjd-menu-swapper-submit-btn');
    var kjdMenuSwapperResults = $('#kjd-menu-swapper-results');

    // Tab navigation handling
    if ( location.hash ) {
        // The location hash is the base, then the nav tab is -nav, and the tab is -tab.
        // This way the browser doesn't move the window when you click a new tab.
        var navTab = $(location.hash+'-nav');
        kjdNavTabSwap(navTab);
    }

    // Manage the swap
    kjdNavigationTabs.click(function(e){
        e.preventDefault();
        kjdNavTabSwap($(this));
    });

    function kjdNavTabSwap(navTab) {
        // Update the tabs to show the current/active one
        kjdNavigationTabs.removeClass('nav-tab-active');
        navTab.addClass('nav-tab-active');

        // Manage which tab is actually visible
        var tabName = '#'+navTab.data('tab');
        $('.kjd-display-content').addClass('hidden');
        $(tabName).removeClass('hidden');

        // gives the base of the ID, not an actual html element id to prevent jarring window movements.
        location.hash = navTab.attr('href');
    }

    kjdMenuSwapperForm.submit(function(e) {
        e.preventDefault();
        var originalMsg = kjdMenuSwapperSubmitBtn.html();
        kjdMenuSwapperSubmitBtn.html('Saving...');
        kjdMenuSwapperResults.html('&nbsp;').addClass('hidden').removeClass('text-red text-green');
        $.ajax({
            type: kjdMenuSwapperForm.attr('method'),
            url: ajaxurl + '?action=kjd_configure_menu_swapper',
            data: kjdMenuSwapperForm.serialize(),
            dataType: 'json',
            success: function(data) {
                kjdMenuSwapperResults.html('Successfully saved new configuration!').addClass('text-green');
            },
            error: function(xhr) {
                kjdMenuSwapperResults.html(`New configuration did not save: ${xhr.statusText}`).addClass('text-red');
            },
            complete: function() {
                kjdMenuSwapperSubmitBtn.html(originalMsg);
                kjdMenuSwapperResults.removeClass('hidden');
            }
        });
    });
})( jQuery );
</script>
