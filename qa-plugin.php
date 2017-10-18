<?php

/*
    Plugin Name: Articles Plugin
    Plugin URI:
    Plugin Description: Plug-in for summary page creation.
    Plugin Version: 1.0
    Plugin Date: 2017-10-18
    Plugin Author: 38qa.net
    Plugin Author URI: http://38qa.net/
    Plugin License: GPLv2
    Plugin Minimum Question2Answer Version: 1.7
    Plugin Update Check URI:
*/

if (!defined('QA_VERSION')) { // don't allow this page to be requested directly from browser
    header('Location: ../../');
    exit;
}

//Define global constants
@define( 'ARTICLES_DIR', dirname( __FILE__ ) );
@define( 'ARTICLES_FOLDER', basename( dirname( __FILE__ ) ) );

// Page
qa_register_plugin_module('page', 'qa-article-page.php', 'qa_article_page', 'Article Page');