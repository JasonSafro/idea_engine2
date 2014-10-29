<?php

/**
 * @file
 * Default theme implementation to display the basic html structure of a single
 * Drupal page.
 */
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language; ?>" version="XHTML+RDFa 1.0" dir="<?php print $language->dir; ?>"<?php print $rdf_namespaces; ?>>

<head profile="<?php print $grddl_profile; ?>">
  <link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,600,700,300' rel='stylesheet' type='text/css'>
  <?php if(theme_get_setting('iphoneRegularIcon') != NULL): ?>
  <link rel="apple-touch-icon" href="<?php print file_create_url(file_load(theme_get_setting('iphoneRegularIcon'))->uri); ?>">
  <?php endif; ?>
  <?php if(theme_get_setting('ipadRegularIcon') != NULL): ?>
  <link rel="apple-touch-icon" sizes="72x72" href="<?php print file_create_url(file_load(theme_get_setting('ipadRegularIcon'))->uri); ?>">
  <?php endif; ?>
  <?php if(theme_get_setting('appleRetinaIcon') != NULL): ?>
  <link rel="apple-touch-icon" sizes="114x114" href="<?php print file_create_url(file_load(theme_get_setting('appleRetinaIcon'))->uri); ?>">
  <?php endif; ?>
  <?php print $head; ?>
  <title><?php print $head_title; ?></title>
  <?php if(theme_get_setting('responsive') == 1): ?>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php endif; ?>
	<!--[if lt IE 9]>
		<script type="text/javascript">/*@cc_on'abbr article aside audio canvas details figcaption figure footer header hgroup mark meter nav output progress section summary subline time video'.replace(/\w+/g,function(n){document.createElement(n)})@*/</script>
	<![endif]-->
    <!--[if IE]>
    	<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
    	<style type="text/css" media="all">.fullscreen.front .row-fluid.pe-block{margin-bottom:0;}</style>
    <![endif]-->
	<script type="text/javascript">if(Function('/*@cc_on return document.documentMode===10@*/')()){document.documentElement.className+=' ie10';}</script>
	<script type="text/javascript">(function(H){H.className=H.className.replace(/\bno-js\b/,'js')})(document.documentElement)</script>
  <?php print $styles; ?>
  <?php print $skin; ?>
  <?php print $jquery; ?>
  <?php print $scripts; ?>
</head>

<body class="<?php print $classes; ?>" <?php print $attributes;?>>
  <div id="skip-link">
    <a href="#main-content" class="element-invisible element-focusable"><?php print t('Skip to main content'); ?></a>
  </div>
  <?php print $page_top; ?>
  <?php print $page; ?>
  <?php print $page_bottom; ?>
</body>
</html>