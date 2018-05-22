<?php

/**
 * This is the abstract base class for all views. It implements the standard
 * HTML tags and inserts the body from the derived class in the makeBody method.
 */

namespace Simplon\Promo\Exercise\View;

require_once $_SERVER['DOCUMENT_ROOT'] . '/exercise/autoloader.php';

abstract class View
{
    private static $headFile = __DIR__.'/head.html';
    private static $footerFile = __DIR__.'/footer.html';

    /**
     * The render method uses the getBody override from the child class and
     * inserts the output between the page header and footer.
     *
     * @param $status Success ('OK') or failure ('NOK') status.
     * @param $message A status message to display when $status is not null.
     */
    final public static function render(string $status = null, string $message = null) : void
    {
        echo self::getHead($status, $message);
        echo static::getBody();
        echo self::getFooter();
    }

    /**
     * Create the page header and include a message when needed.
     *
     * The head template contains a '{{messageText}}' placeholder where the
     * message will be inserted.
     *
     * @param $status Success ('OK') or failure ('NOK') status.
     * @param $message A status message to display when $status is not null.
     *
     * @return A string containing HTML tags.
     */
    final private static function getHead(string $status = null, string $message = null) : string
    {
        if (file_exists(self::$headFile)) {
            $head = file_get_contents(self::$headFile);
            if ($status == 'OK' || $status == 'NOK') {
                $head = preg_replace('/ hidden="[^"]*"/', '', $head);
                $head = preg_replace('/{{messagetext}}/', $message, $head);
                if ($status == 'NOK') {
                    $head = preg_replace('/alert-success/', 'alert-danger', $head);
                }
            }
        } else {
            $head = '<p>Header file not found</p>';
        }
        return $head;
    }

    /**
     * Get the page footer tags.
     *
     * @return A string containtng HTML tags.
     */
    final private static function getFooter() : string
    {
        if (file_exists(self::$footerFile)) {
            $footer = file_get_contents(self::$footerFile);
        } else {
            $footer = '<p>Footer file not found</p>';
        }
        return $footer;
    }

    /**
     * Override this method in your view to create the main page contants.
     */
    abstract protected static function getBody() : string;
}


// vim:set expandtab tabstop=4 shiftwidth=4 softtabstop=4:
