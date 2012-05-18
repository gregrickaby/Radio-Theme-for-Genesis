<?php
/**
 * File: timthumb-config.php
 * Description: This file is loaded by timthumb. It saves having to re-edit variables
 * everytime a new version is released.
 *
 * @package TimThumb
 * @author Greg Rickaby
 * @since Radio 1.0
 *
 * More Info: http://www.binarymoon.co.uk/projects/timthumb/
 */
if(! defined( 'FILE_CACHE_DIRECTORY' ) ) define ( 'FILE_CACHE_DIRECTORY', '../../custom/cache' ); // Sets the cache directory
if(! defined( 'FILE_CACHE_TIME_BETWEEN_CLEANS' )) define ( 'FILE_CACHE_TIME_BETWEEN_CLEANS', 43200 ); // How often the cache is cleaned 
if(! defined( 'FILE_CACHE_MAX_FILE_AGE' ) ) define ( 'FILE_CACHE_MAX_FILE_AGE', 43200 ); // How old does a file have to be to be deleted from the cache
if(! defined( 'DEFAULT_Q' ) ) define ( 'DEFAULT_Q', 70 ); // Default image quality (up to 100). The higher, the better.
if(! defined( 'DEFAULT_ZC' ) ) define ( 'DEFAULT_ZC', 1 ); // Default zoom/crop setting.
if(! defined( 'DEFAULT_F' ) ) define ( 'DEFAULT_F', '' ); // Default image filters.
if(! defined( 'DEFAULT_S' ) ) define ( 'DEFAULT_S', 0 ); // Default sharpen value.
if(! defined( 'DEFAULT_CC' ) ) define ( 'DEFAULT_CC', '000000' ); // Default canvas color.