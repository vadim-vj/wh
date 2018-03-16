<?php

/**
 * Install hook
 * 
 * @author Vadim Sannikov <vsj.vadim@gmail.com> 
 */

// Automatically refer to subfolder
add_action('wp_install', function (\WP_User $user) {
    update_option('home', preg_replace('/^(.+)\/wp\/?$/Si', '$1', get_option('home')));
});
