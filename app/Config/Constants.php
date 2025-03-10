<?php

/*
 | --------------------------------------------------------------------
 | App Namespace
 | --------------------------------------------------------------------
 |
 | This defines the default Namespace that is used throughout
 | CodeIgniter to refer to the Application directory. Change
 | this constant to change the namespace that all application
 | classes should use.
 |
 | NOTE: changing this will require manually modifying the
 | existing namespaces of App\* namespaced-classes.
 */
defined('APP_NAMESPACE') || define('APP_NAMESPACE', 'App');

/*
 | --------------------------------------------------------------------------
 | Composer Path
 | --------------------------------------------------------------------------
 |
 | The path that Composer's autoload file is expected to live. By default,
 | the vendor folder is in the Root directory, but you can customize that here.
 */
defined('COMPOSER_PATH') || define('COMPOSER_PATH', ROOTPATH . 'vendor/autoload.php');

/*
 |--------------------------------------------------------------------------
 | Timing Constants
 |--------------------------------------------------------------------------
 |
 | Provide simple ways to work with the myriad of PHP functions that
 | require information to be in seconds.
 */
defined('SECOND') || define('SECOND', 1);
defined('MINUTE') || define('MINUTE', 60);
defined('HOUR')   || define('HOUR', 3600);
defined('DAY')    || define('DAY', 86400);
defined('WEEK')   || define('WEEK', 604800);
defined('MONTH')  || define('MONTH', 2_592_000);
defined('YEAR')   || define('YEAR', 31_536_000);
defined('DECADE') || define('DECADE', 315_360_000);

/*
 | --------------------------------------------------------------------------
 | Exit Status Codes
 | --------------------------------------------------------------------------
 |
 | Used to indicate the conditions under which the script is exit()ing.
 | While there is no universal standard for error codes, there are some
 | broad conventions.  Three such conventions are mentioned below, for
 | those who wish to make use of them.  The CodeIgniter defaults were
 | chosen for the least overlap with these conventions, while still
 | leaving room for others to be defined in future versions and user
 | applications.
 |
 | The three main conventions used for determining exit status codes
 | are as follows:
 |
 |    Standard C/C++ Library (stdlibc):
 |       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
 |       (This link also contains other GNU-specific conventions)
 |    BSD sysexits.h:
 |       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
 |    Bash scripting:
 |       http://tldp.org/LDP/abs/html/exitcodes.html
 |
 */
defined('EXIT_SUCCESS')        || define('EXIT_SUCCESS', 0);        // no errors
defined('EXIT_ERROR')          || define('EXIT_ERROR', 1);          // generic error
defined('EXIT_CONFIG')         || define('EXIT_CONFIG', 3);         // configuration error
defined('EXIT_UNKNOWN_FILE')   || define('EXIT_UNKNOWN_FILE', 4);   // file not found
defined('EXIT_UNKNOWN_CLASS')  || define('EXIT_UNKNOWN_CLASS', 5);  // unknown class
defined('EXIT_UNKNOWN_METHOD') || define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     || define('EXIT_USER_INPUT', 7);     // invalid user input
defined('EXIT_DATABASE')       || define('EXIT_DATABASE', 8);       // database error
defined('EXIT__AUTO_MIN')      || define('EXIT__AUTO_MIN', 9);      // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      || define('EXIT__AUTO_MAX', 125);    // highest automatically-assigned error code

/**
 * @deprecated Use \CodeIgniter\Events\Events::PRIORITY_LOW instead.
 */
define('EVENT_PRIORITY_LOW', 200);

/**
 * @deprecated Use \CodeIgniter\Events\Events::PRIORITY_NORMAL instead.
 */
define('EVENT_PRIORITY_NORMAL', 100);

/**
 * @deprecated Use \CodeIgniter\Events\Events::PRIORITY_HIGH instead.
 */
define('EVENT_PRIORITY_HIGH', 10);

/*
 * Custom
 */
defined('LARGE_DB_MAX_ID_LIMIT')       OR define('LARGE_DB_MAX_ID_LIMIT', 50000);
defined('NAV_CAT_LEVEL2_LIMIT')       OR define('NAV_CAT_LEVEL2_LIMIT', 10);
defined('NAV_CAT_LEVEL3_LIMIT')       OR define('NAV_CAT_LEVEL3_LIMIT', 6);
defined('NAV_LARGER_CAT_LEVEL3_LIMIT')       OR define('NAV_LARGER_CAT_LEVEL3_LIMIT', 30);
defined('CAT_QUERY_SEPARATOR')       OR define('CAT_QUERY_SEPARATOR', '|||');
defined('CAT_QUERY_SEPARATOR_SUB')   OR define('CAT_QUERY_SEPARATOR_SUB', ':::');
defined('IMG_BASE64_1x1')      		 OR define('IMG_BASE64_1x1', 'data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==');
defined('IMG_BG_PRODUCT_SMALL')      OR define('IMG_BG_PRODUCT_SMALL', 'assets/img/img_bg_product_small.png');
defined('IMG_BG_BLOG_SMALL')      	 OR define('IMG_BG_BLOG_SMALL', 'assets/img/img_bg_blog_small.jpg');
defined('IMG_BG_PRODUCT_SLIDER')     OR define('IMG_BG_PRODUCT_SLIDER', 'assets/img/slider_bg.png');
defined('CHAT_UPDATE_TIME')          OR define('CHAT_UPDATE_TIME', 3);
defined('AFFILIATE_COOKIE_NAME')     OR define('AFFILIATE_COOKIE_NAME', 'aff_id');
defined('AFFILIATE_COOKIE_TIME')     OR define('AFFILIATE_COOKIE_TIME', 30); // 30 DAYS
defined('CUSTOM_FILTERS_COLLAPSE_LIMIT')          OR define('CUSTOM_FILTERS_COLLAPSE_LIMIT', 4);
defined('PRODUCT_TAG_LIMIT')          OR define('PRODUCT_TAG_LIMIT', 15); //max number of tags per product
defined('PRODUCT_TAG_CHAR_LIMIT')          OR define('PRODUCT_TAG_CHAR_LIMIT', 100); //max number of characters per tag
defined('REVIEWS_LOAD_LIMIT')          OR define('REVIEWS_LOAD_LIMIT', 10);
defined('COMMENTS_LOAD_LIMIT')          OR define('COMMENTS_LOAD_LIMIT', 10);
defined('COMMENT_CHARACTER_LIMIT')          OR define('COMMENT_CHARACTER_LIMIT', 5000);
defined('REVIEW_CHARACTER_LIMIT')          OR define('REVIEW_CHARACTER_LIMIT', 10000);
defined('NUM_INDEX_CATEGORY_PRODUCTS')          OR define('NUM_INDEX_CATEGORY_PRODUCTS', 15); //Number of products to display for each category on the homepage
