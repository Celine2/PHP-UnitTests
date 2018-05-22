<?php

/**
 * A simple class to route requests.
 * GET doesn't expect any parameters and shows a create form.
 * POST expects data for new user creation.
 */

namespace Simplon\Promo\Exercise;

require_once $_SERVER['DOCUMENT_ROOT'] . 'exercise/autoloader.php';

class PageHandler
{
    /**
     * This is the main switch for our page where we decide what to display.
     */
    public static function showPage() : void
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            self::insertUser();
        } else {
            self::showForm();
        }
    }

    /**
     * A simple form to get the necessary data for creating a new user.
     * The result is sent back to this script with a POST request.
     */
    private static function showForm() : void
    {
        View\ViewForm::render();
    }

    /**
     * Save a new user to the database. Raw $_POST contents are sent to the
     * database handler which must sanitize input before storage.
     * Success or failure is reported back to the view.
     */
    private static function insertUser() : void
    {
        try {
            $user = new User($_POST);
            $user->store();
            View\ViewForm::render('OK', 'User saved');
        } catch (\Throwable $e) {
            View\ViewForm::render('NOK', $e->getMessage());
        }
    }
}

// vim:set expandtab tabstop=4 shiftwidth=4 softtabstop=4:
