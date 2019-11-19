<?php

namespace App\Repositories\Mongo;

use App\Models\User;
use App\Repositories\UserRepository;
use App\Repositories\Mongo\Models\User as RepoUser;
use Illuminate\Support\Facades\Hash;

class MongoUserRepository implements UserRepository
{
    public function create(User $user): User
    {
        $newUser = new RepoUser;
        $newUser->username = $user->getUsername();
        $newUser->password = Hash::make($user->getPassword());
        $newUser->email = $user->getEmail();
        $newUser->save();
        $user->id($newUser->id);
        return $user;
    }

    public function get(string $id): ?User
    {
        $repoUser = RepoUser::find($id);
        return is_null($repoUser) ? null : $this->mapRepoUserToUser($repoUser);
    }

    public function getByEmailAndPassword(string $email, string $password): ?User
    {
        $repoUser = RepoUser::where(['email' => $email])->first();
        if (is_null($repoUser) || !Hash::check($password, $repoUser->password)) {
            return null;
        }
        return $this->mapRepoUserToUser($repoUser);
    }

    public function getAll()
    { }

    public function update(User $user)
    { }

    public function delete($id)
    { }

    private function mapRepoUserToUser(RepoUser $repoUser)
    {
        $user = new User();
        $user->id = $repoUser->id;
        $user->setUsername($repoUser->username);
        $user->setEmail($repoUser->email);
        $user->setPassword($repoUser->password);
        return $user;
    }
}
