<?php
/*
Plugin Name: Robown Coming Soon
Plugin URI: https://mortezalotfi.com
Description: A beautiful coming soon page with countdown timer and customization options
Version: 2.0
Author: Morteza Lotfi
Author URI: https://mortezalotfi.com
*/

if (!defined('ABSPATH')) {
    exit;
}

// Plugin Class
class RobownComingSoon {
    public function __construct() {
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_init', array($this, 'register_settings'));
        add_action('template_redirect', array($this, 'show_coming_soon_page'));
        add_action('wp_login', array($this, 'set_cookie_after_login'));
        add_action('wp_logout', array($this, 'unset_cookie_after_logout'));
        
        // Add settings link to plugins page
        add_filter('plugin_action_links_' . plugin_basename(__FILE__), array($this, 'add_settings_link'));
    }

    public function activate() {
        add_option('robown_cs_settings', array(
            'site_title' => get_bloginfo('name'),
            'heading' => 'Coming Soon',
            'description' => 'We\'re working hard to bring you something amazing. Stay tuned!',
            'launch_date' => date('Y-m-d', strtotime('+1 month')),
            'enable_coming_soon' => 1
        ));

        // Add activation message
        set_transient('robown_cs_activation_notice', true, 5);
    }

    // Add settings link to plugins page
    public function add_settings_link($links) {
        $settings_link = '<a href="' . admin_url('options-general.php?page=robown-coming-soon') . '">' . __('Settings', 'robown-coming-soon') . '</a>';
        array_unshift($links, $settings_link);
        return $links;
    }

    // Display activation message
    public static function activation_notice() {
        if (get_transient('robown_cs_activation_notice')) {
            ?>
            <div class="updated notice is-dismissible">
                <p>Thank you for installing Robown Coming Soon plugin! 
                   To configure the plugin, please visit the 
                   <a href="<?php echo admin_url('options-general.php?page=robown-coming-soon'); ?>">Settings Page</a>
                   (Settings > Coming Soon Page).</p>
            </div>
            <?php
            delete_transient('robown_cs_activation_notice');
        }
    }

    public function add_admin_menu() {
        add_options_page(
            'Coming Soon Settings',
            'Coming Soon Page',
            'manage_options',
            'robown-coming-soon',
            array($this, 'settings_page')
        );
    }

    public function register_settings() {
        register_setting('robown_cs_settings', 'robown_cs_settings');
    }

    public function settings_page() {
        include plugin_dir_path(__FILE__) . 'admin/settings.php';
    }

    public function show_coming_soon_page() {
        $options = get_option('robown_cs_settings');
        
        if (
            isset($_COOKIE['robown_cs_logged_in']) ||
            !$options['enable_coming_soon'] ||
            is_admin() ||
            wp_doing_ajax()
        ) {
            return;
        }

        include plugin_dir_path(__FILE__) . 'public/coming-soon.php';
        exit;
    }

    public function set_cookie_after_login() {
        setcookie('robown_cs_logged_in', '1', time() + (86400 * 30), '/');
    }

    public function unset_cookie_after_logout() {
        setcookie('robown_cs_logged_in', '', time() - 3600, '/');
    }
}

// Initialize plugin
$robown_coming_soon = new RobownComingSoon();
register_activation_hook(__FILE__, array($robown_coming_soon, 'activate'));

// Add activation notice
add_action('admin_notices', array('RobownComingSoon', 'activation_notice')); 