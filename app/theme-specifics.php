<?php
/*
 * this file is theme-specifics.php
 *
 * Plugin Name: Custom Sage Theme Setup Plugin
 * Description: Provides essential functionality like post types needed across themes
 * Version: 1.0
 * Text Domain: theme-specifics
*/

namespace App;

global $textDomain;
$textDomain = 'theme-specifics';

// Admin
require __DIR__ . '/Admin/services.php';
require __DIR__ . '/Admin/careers.php';
require __DIR__ . '/Admin/team-members.php';
