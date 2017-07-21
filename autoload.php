<?php
/**
 * Autoload Handler
 *
 * @package     OllyWarren\WP-Wakatime
 * @author      Olly Warren
 * @copyright   2017 Olly Warren
 * @license     GPL-2.0+
 */

$classes = [
	'class-boot',
	'class-wakatime',
	'class-languagewidget',
];

/** Each Class is then auto loaded from the Path. */
foreach ( $classes as $class ) {
	require_once AUTOLOAD_PATH . "includes/$class.php";
}
