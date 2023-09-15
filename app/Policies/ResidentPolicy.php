<?php

/*
TO READ

https://laravel.com/docs/10.x/authorization#creating-policies
*/

namespace App\Policies;

use App\Models\Resident;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ResidentPolicy
{
    const ADMIN_EMAIL = 'prots.srs@gmail.com';
    private function isAdmin($email): bool
    {
        return $email == self::ADMIN_EMAIL;
    }

    public function __construct()
    {
    }

    // true - break from policy and access all
    // null - waterfall to be details
    // false - break from policy and deny all
    public function before(User $user, string $ability): bool|null
    {
        // echo "<br>resident policy before: {$ability}<br>";
        if ($this->isAdmin($user->email)) {
            return true;
        }
        return null;
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(): Response
    {
        return Response::denyAsNotFound();
    }
    /**
     * Determine whether the user can update the model.
     */
    public function update(User $resident): Response
    {
        return Response::denyAsNotFound();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Resident $resident): Response
    {
        return Response::denyAsNotFound();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(): Response
    {
        return Response::denyAsNotFound();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Resident $resident): Response
    {
        return Response::denyAsNotFound();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Resident $resident): Response
    {
        return Response::denyAsNotFound();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Resident $resident): Response
    {
        return Response::denyAsNotFound();
    }
}