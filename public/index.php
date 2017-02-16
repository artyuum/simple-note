<?php

/**
 * Enables autoloading of classes without includes.
 *
 * This allows you to just spawn new instances of the classes as needed with out include statements
 * everywhere. This is great for larger projects where you're orchestrating a lot of different
 * objects.
 */
require_once __DIR__ . '/../app/autoload.php';

/**
 * This is where you're routes go.
 *
 * How this works is that all of your web requests are sent to this index file, and then based on what
 * the URI is, it then issues the correct commands to PHP to display the view you're wanting.
 */
require_once __DIR__ . '/../app/routes.php';