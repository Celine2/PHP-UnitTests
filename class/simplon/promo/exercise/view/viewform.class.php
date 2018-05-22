<?php

/**
 * Display new user entry form
 */

namespace Simplon\Promo\Exercise\View;

require_once $_SERVER['DOCUMENT_ROOT'] . '/exercise/autoloader.php';

class ViewForm extends View
{
    private static $formFile = __DIR__ . '/form.html';

    /**
     * Create the form page main contents.
     *
     * @return A string containtng HTML tags.
     */
    protected static function getBody() : string
    {
        if (file_exists(self::$formFile)) {
            $form = file_get_contents(self::$formFile);
        } else {
            $form = '<p>Form file not found</p>';
        }
        return $form;
    }
}

// vim:set expandtab tabstop=4 shiftwidth=4 softtabstop=4:
