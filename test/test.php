<?php
/**
 * Test class
 * Warning: these tests are destructive, don't use this class with a production
 * database!
 */

require_once '/home/hans/public_html/simplon/exercise/autoloader.php';

use PHPUnit\Framework\Testcase;
use Simplon\Promo\Exercise\User;
use Simplon\Promo\Exercise\DB;

/**
 * This class implements tests for class User.
 * The tests cover data validation and storage.
 */
class UserTest extends TestCase
{
    /*
     * The following variables are used as inputs for the test methods.
     */
    private static $test_user = [
        'first-name' => 'John',
        'last-name' => 'Doe',
        'birth-year' => 1995
    ];

    private static $test_invalid_first_name = [
        'first-name' => 'John<a href="https://evil.com">Get your present here</a>',
        'last-name' => 'Doe',
        'birth-year' => 1995
    ];

    private static $test_invalid_last_name = [
        'first-name' => 'John',
        'last-name' => 'Doe<a href="https://evil.com">Get your present here</a>',
        'birth-year' => 1995
    ];

    private static $test_user_too_old = [
        'first-name' => 'Mike',
        'last-name' => 'Bird',
        'birth-year' => 1899
    ];

    private static $test_user_too_young = [
        'first-name' => 'Mike',
        'last-name' => 'Bird',
        'birth-year' => 2001
    ];

    private static $test_missing_first_name = [
        'last-name' => 'Torvalds',
        'birth-year' => 1969
    ];

    /**
     * The constructor clears the database to avoid problems with unique keys.
     */
    public function __construct()
    {
        parent::__construct();
        // Let's start with a clean slate
        $this->helperClearDB();
    }

    /*
     * Test methods
     */

    /**
     * This function tests the storage of a new user: can the data be
     * retrieved after storage and are they the same as the original data.
     */
    public function testStorage()
    {
        $user = new User(self::$test_user);
        $user->store();

        $this->assertSame(1, $this->helperGetUserEntries($user->toArray()));
    }

    /**
     * Check if invalid characters in firstmane are caught.
     */
    public function testInvalidFirstName()
    {
        $this->expectException(Exception::class);
        $user = new User(self::$test_invalid_first_name);
    }

    /**
     * Check if invalid characters in lastmane are caught.
     */
    public function testInvalidLastName()
    {
        $this->expectException(Exception::class);
        $user = new User(self::$test_invalid_last_name);
    }

    /**
     * Check for birthyear too low
     */
    public function testUserTooOld()
    {
        $this->expectException(Exception::class);
        $user = new User(self::$test_user_too_old);
    }

    /**
     * Check for birthyear too high
     */
    public function testUserTooYoung()
    {
        $this->expectException(Exception::class);
        $user = new User(self::$test_user_too_young);
    }

    /**
     * Check if exception is thrown on user with existing name and firstname
     * @depends testStorage
     */
    public function testCheckUniqueNames()
    {
        $this->expectException(Exception::class);
        $user = new User(self::$test_user);
        $user->store();
    }

    public function testMissingFirstName()
    {
        $this->expectException(Exception::class);
        $user = new User(self::$test_missing_first_name);
        $user->store();
    }

    /**
     * Helper functions
     */

    /**
     * Delete all records from Users table
     */
    private function helperClearDB()
    {
        $db = DB::getDB();
        $stmt = $db->prepare('DELETE FROM Users');
        $stmt->execute();
    }

    /**
     * Test function: get total number of entries in users table
     *
     * @return Number of users found.
     */
    public function helperGetTotalEntries() : int
    {
        $db = DB::getDB();
        $stmt = $db->prepare(
            'SELECT COUNT(*) AS entries FROM Users'
        );
        if ($stmt->execute() && ($result = $stmt->fetch())) {
            $entries = intval($result['entries']);
        } else {
            $entries = 0;
        }

        return $entries;
    }

    /**
     * Test function: get number of entries for user
     *
     * @param $user Array containing user info
     *
     * @return Number of entries found.
     */
    public function helperGetUserEntries($user) : int
    {
        $db = DB::getDB();
        $stmt = $db->prepare('SELECT COUNT(*) AS entries FROM Users WHERE first_name = :firstName AND last_name = :lastName AND birth_year = :birthYear');
        if (
            $stmt->execute($user)
            && ($result = $stmt->fetch())
        ) {
            $entries = intval($result['entries']);
        } else {
            $entries = 0;
        }
        return $entries;
    }
}


// vim:set expandtab tabstop=4 shiftwidth=4 softtabstop=4:
