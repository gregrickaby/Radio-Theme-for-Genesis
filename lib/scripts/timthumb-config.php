<?php
/**
 * File: timthumb-config.php
 * Description: This file is loaded by timthumb. It saves having to re-edit variables
 * everytime a new version is released.
 *
 * @author Greg Rickaby
 * @since Radio 1.0
 * @required timthumb
 *
 * More Info: http://www.binarymoon.co.uk/projects/timthumb/
 */
if(! defined( 'FILE_CACHE_DIRECTORY' ) ) define ( 'FILE_CACHE_DIRECTORY', '../../custom/cache' ); // Sets the cache directory
if(! defined( 'DEFAULT_Q' ) ) define ( 'DEFAULT_Q', 85 ); // Default image quality (up to 100). The higher, the better.
if(! defined( 'DEFAULT_ZC' ) ) define ( 'DEFAULT_ZC', 1 ); // Default zoom/crop setting.
if(! defined( 'DEFAULT_F' ) ) define ( 'DEFAULT_F', '' ); // Default image filters.
if(! defined( 'DEFAULT_S' ) ) define ( 'DEFAULT_S', 0 ); // Default sharpen value.
if(! defined( 'DEFAULT_CC' ) ) define ( 'DEFAULT_CC', '000000' ); // Default canvas color.