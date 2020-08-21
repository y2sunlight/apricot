<?php
namespace App\Services;

/**
 * Sample Service
 */
class SampleService
{
    /**
     * The number of users
     * @var int
     */
    private $count = 0;

    /**
     * Creates a sample service.
     */
    public function __construct(\App\Models\User $user)
    {
        $this->count = count($user->findAll());
    }

    /**
     * Get the number of users
     */
    public function getUserCount()
    {
        return $this->count;
    }
}
