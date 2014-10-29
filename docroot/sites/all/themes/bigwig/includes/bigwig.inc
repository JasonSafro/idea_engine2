<?php

/**
 * Container class for theme configuration settings.
 */

class bigwig_theme_container {
	var $theme;

	function __construct($theme, $delta = NULL) {
		$this->theme = $theme;
		$this->delta = $delta;
	}

	function init() {
		$this->settings();
	}

	function settings() {
		return $this->settings;
	}
}

/**
 * Builds the full theme trail (deepest base theme first, subtheme last)
 * for a theme.
 *
 * @param $theme
 *   The key (machin-readable name) of a theme.
 *
 * @return
 *   An array of all themes in the trail, keyed by theme key.
 */

function bigwig_theme_trail($theme) {
	$static = &drupal_static(__FUNCTION__);

	if (!isset($static)) {
		$themes = list_themes();

		if (isset($themes[$theme]->info['base theme'])) {
			foreach (system_find_base_themes($themes, $theme) as $base => $name) {
				if ($name && isset($themes[$base])) {
					$static[$theme][$base] = $themes[$base]->info['name'];
				}
			}
		}

		// Add our current subtheme ($key) to that array.
		if (isset($themes[$theme])) {
			$static[$theme][$theme] = $themes[$theme]->info['name'];
		}
	}

	if (isset($static[$theme])) {
		return $static[$theme];
	}
}


/**
 * Returns the theme container object for the current theme.
 *
 * @return
 *   An object representing the current theme.
 */

function bigwig_get_theme() {
	$container = &drupal_static(__FUNCTION__);

	$key = $theme = $GLOBALS['theme_key'];
	$delta = NULL;

	if (!isset($container[$key])) {
		foreach (array_keys(bigwig_theme_trail($theme)) as $item) {
			if (class_exists($item . '_theme_container')) {
				$class = $item . '_theme_container';
			}
		}

		if (isset($class)) {
			$container[$key] = new $class($theme, $delta);
		}
	}

	return $container[$key];
}