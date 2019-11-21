<?php

namespace App\Adapters;

use App\Repositories\Mongo\Models\User as RepoUser;
use Tymon\JWTAuth\Contracts\Providers\Auth;
use Illuminate\Support\Facades\Hash;

class MongoAuthAdapter implements Auth
{
    private $authenticatedUser;

    /**
     * Check a user's credentials.
     *
     * @param  array  $credentials
     *
     * @return bool
     */
    public function byCredentials(array $credentials)
    {
        $user = $this->authenticatedUser = RepoUser::where(['email' => $credentials['email']])->first();
        if (is_null($user)) {
            return false;
        }
        return Hash::check($credentials['password'], $user->password);
    }

    /**
     * Authenticate a user via the id.
     *
     * @param  mixed  $id
     *
     * @return bool
     */
    public function byId($id)
    {
        return $this->authenticatedUser = RepoUser::find($id);
    }

    /**
     * Get the currently authenticated user.
     *
     * @return mixed
     */
    public function user()
    {
        return $this->authenticatedUser;
    }
}
