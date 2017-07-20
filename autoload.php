<?php

/*******************************
 * Autoload Configuration      *
 * =========================   *
 * Add any classes that need   *
 * auto loading to this Array  *
 *******************************/
$classes = [
	'class-boot',
	'class-wakatime',
	'class-languagewidget',
];

/** Each Class is then auto loaded from the Path. */
foreach ( $classes as $class ) {
	require_once AUTOLOAD_PATH . "includes/$class.php";
}
