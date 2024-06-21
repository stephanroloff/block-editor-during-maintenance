<?php
/**
 * Plugin Name:       Block editor during maintenance
 * Description:       Non-admin users will be logged out, redirected to the frontend, and a maintenance message will be displayed on the frontend. It will not be posible for non-admin users to logged in again.
 * Requires at least: 5.8
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            The WordPress Contributors
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       meraki
 *
 * @package           create-block
 */

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */

namespace BlockEditorDuringMaintenancePlugin;
require __DIR__ . '/vendor/autoload.php';

$BlockEditorDuringMaintenance = new BlockEditorDuringMaintenance();


