<div class='search-form-container'>
    <form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url( '/' )); ?>">
        <label class="screen-reader-text">Search for:</label>
        <div>
            <input id="submit-proxy-checkbox" tabindex="-1" type="checkbox" name="expand-search-bar" value="">
            <label class="submit-proxy" for="submit-proxy-checkbox"></label>
            <input type="search" class="search-field" placeholder="Search for..." value="" name="s" title="Search for:" />
            <i class="fa fa-search"></i>
            <input type="submit" tabindex="-1" class="search-submit" value='' />
        </div>
    </form>
</div>