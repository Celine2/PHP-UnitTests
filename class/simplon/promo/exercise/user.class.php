<?php

/**
 * Handle user data and storage.
 *
 * New objetcts are created from an associative array with the 'generate' static
 * method.
 */

namespace Simplon\Promo\Exercise;

class User
{
    private $firstName = null;
    private $lastName = null;
    private $comments = null;
    private $birthYear = 0;

    const MIN_YEAR = 1900;
    const MAX_YEAR = 2000;

    /**
     * Create a new user from an associative array and initialize members.
     * Inputs are validated and an exception is thrown on invalid data.
     */
    public function __construct(array &$fields)
    {
        if (
            !array_key_exists('birth-year', $fields) ||
            !array_key_exists('first-name', $fields) ||
            !array_key_exists('last-name', $fields)
        ) {
            throw new \Exception('Missing user field');
        }
        self::validateBirthYear($fields['birth-year']);
        self::validateName($fields['first-name']);
        self::validateName($fields['last-name']);

        $this->firstName = $fields['first-name'];
        $this->lastName = $fields['last-name'];
        $this->birthYear = $fields['birth-year'];
        if (array_key_exists('comments', $fields)) {
            $this->comments = $fields['comments'];
        }
    }

    /**
     * Try to store a new user in the database.
     * Inputs are sanitized bedore storage.
     * A PDOException is thrown on faliure.
     */
    public function store() : void
    {
        $db = DB::getDB();
        $stmt = $db->prepare(
            'INSERT INTO Users (first_name, last_name, comment, birth_year)
                VALUES (:first_name, :last_name, :comments, :birth_year)'
        );
        $stmt->execute([
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'comments' => $this->comments,
            'birth_year' => $this->birthYear,
        ]);
    }

    public function toArray() : array
    {
        return [
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'birthYear' => $this->birthYear
        ];
    }

    /**
     * Validate a firstname or lastname.
     * Throws an Exception when invalid characters are found.
     */
    private static function validateName(string $name) : void
    {
        if (!preg_match('~\A[a-zA-Z éèàùçÉÈÀÇ-]+\Z~', $name)) {
            throw new \Exception('Invalid character in name');
        }
    }

    /**
     * Check if a birthyear fits within the valid range.
     * Throws an exception when out of range.
     */
    private static function validateBirthYear(int $year) : void
    {
        if (
            !is_numeric($year) ||
            $year < self::MIN_YEAR ||
            $year > self::MAX_YEAR
        ) {
            throw new \Exception('Birthyear out of range');
        }
    }
}


// vim:set expandtab tabstop=4 shiftwidth=4 softtabstop=4:
