<?php

namespace BlockEditorDuringMaintenancePlugin;

if (!class_exists('BlockEditorDuringMaintenancePlugin\OptionPageForFrontend')) {
    class OptionPageForFrontend {

        function __construct() {
            // Asegúrate de que ACF Pro esté instalado antes de intentar agregar una página de opciones
            if (function_exists('acf_add_options_page')) {
                add_action('admin_menu', array($this, 'add_acf_options_page'));
                add_action('acf/init', array($this, 'add_acf_fields'));
            } else {
                // add_action('admin_notices', array($this, 'acf_pro_not_installed_notice'));
            }
        }

        // Función para agregar la página de opciones
        function add_acf_options_page() {
            acf_add_options_page(array(
                'page_title'    => 'Maintenance Settings',
                'menu_title'    => 'Maintenance Settings',
                'menu_slug'     => 'maintenance-settings',
                'capability'    => 'edit_posts',
                'redirect'      => false
            ));
        }

        // Función para agregar los campos a la página de opciones
        function add_acf_fields() {
            acf_add_local_field_group(array(
                'key' => 'group_maintenance_settings',
                'title' => 'Maintenance Settings',
                'fields' => array(
                    array(
                        'key' => 'field_maintenance_title',
                        'label' => 'Maintenance Title',
                        'name' => 'maintenance_title',
                        'type' => 'text',
                        'instructions' => 'Enter the title for the maintenance mode.',
                    ),
                    array(
                        'key' => 'field_maintenance_description',
                        'label' => 'Maintenance Description',
                        'name' => 'maintenance_description',
                        'type' => 'textarea',
                        'instructions' => 'Enter the description for the maintenance mode.',
                    ),
                    array(
                        'key' => 'field_disable_message_frontend',
                        'label' => 'Disable Message in Frontend',
                        'name' => 'disable_message_frontend',
                        'type' => 'true_false',
                        'instructions' => 'Check to disable the maintenance message on the frontend.',
                        'ui' => 1,
                    ),
                ),
                'location' => array(
                    array(
                        array(
                            'param' => 'options_page',
                            'operator' => '==',
                            'value' => 'maintenance-settings',
                        ),
                    ),
                ),
            ));
        }

        // Función para mostrar una notificación si ACF Pro no está instalado
        function acf_pro_not_installed_notice() {
            echo '<div class="error"><p>ACF Pro is not installed or activated. Please install and activate ACF Pro to use this feature.</p></div>';
        }
    }
}
