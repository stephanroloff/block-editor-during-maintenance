<?php

namespace BlockEditorDuringMaintenancePlugin;

if(! class_exists('BlockEditorDuringMaintenancePlugin\BlockEditorDuringMaintenance')){
    class BlockEditorDuringMaintenance {

        function __construct(){
            // add_action( 'get_header', array($this, 'wp_maintenance_mode') );
            add_action( 'admin_init', array($this, 'logout_non_admin_users'));
            add_action( 'admin_menu', array($this, 'disable_editor'), 999);
            // Hook to display the message before loading the page content
            // The message will only be displayed if the checkbox "Disable Message in Frontend" is TRUE.
            if (function_exists('get_field')) {
                $field_disable_message_frontend = get_field('disable_message_frontend', 'options');
                if(!$field_disable_message_frontend){
                    add_action('wp_loaded', array($this, 'maintenance_mode_message'));
                }
            }else{
                add_action('wp_loaded', array($this, 'maintenance_mode_message'));
            }

        }

        // Redirect non-admin users to the frontend
        function wp_maintenance_mode() {
            if ( !current_user_can( 'manage_options' ) && !is_user_logged_in() ) {
                wp_die('The site is under maintenance, please come back later.');
            }
        }

        // Log out all logged-in users who are not administrators
        function logout_non_admin_users() {
            if ( !current_user_can( 'manage_options' ) ) {
                wp_logout();
                wp_redirect( home_url() );
                exit;
            }
        }

        // Disable WordPress editor for everyone except administrators
        function disable_editor() {
            if ( !current_user_can( 'manage_options' ) ) {
                remove_menu_page( 'edit.php' );
                remove_menu_page( 'edit.php?post_type=page' );
                remove_submenu_page( 'themes.php', 'theme-editor.php' );
                remove_submenu_page( 'plugins.php', 'plugin-editor.php' );
            }
        }

        // Function to display a maintenance message on the frontend
        function maintenance_mode_message() {
            if (!current_user_can('manage_options') && !is_admin()) {

                if (function_exists('get_field')) {
                    $maintenance_title = get_field('maintenance_title', 'options');
                    $maintenance_description = get_field('maintenance_description', 'options');
                    
                    if($maintenance_title=='Undefined' || !$maintenance_title){
                        $maintenance_title = 'Wartungsarbeiten';
                    }
    
                    if(!$maintenance_description){
                        $maintenance_description = 'Wir führen Wartungsarbeiten auf unserer Website durch. Bitte versuchen Sie es später erneut.';   
                    }
                }else{
                    $maintenance_title = 'Wartungsarbeiten';
                    $maintenance_description = 'Wir führen Wartungsarbeiten auf unserer Website durch. Bitte versuchen Sie es später erneut.';
                }
                
                // HTML for the maintenance message
                $message = '<div style="text-align: center; padding: 50px;"><h1>' . $maintenance_title . '</h1><p>' . $maintenance_description . '</p></div>';

                // Display the message and stop loading the rest of the content
                $current_url = $_SERVER['REQUEST_URI'];

                // Example of URL check
                if (strpos($current_url, '/wp-admin') !== false || strpos($current_url, '/wp-login.php') !== false) {
                    // You are on a page within /wp-admin
                } else {
                    // You are not on /wp-admin
                    wp_die($message, 'Site Under Maintenance');
                }
            }
        }
    }
}
