<?php

namespace App\Repositories\Mongo;

use App\Exceptions\ResourceNotFoundException;
use App\Models\User;
use App\Repositories\Contracts\UserRepository;
use App\Repositories\Mongo\Models\User as RepoUser;
use App\Repositories\Mongo\Utils\MongoMapper;
use Illuminate\Support\Facades\Hash;

class MongoUserRepository implements UserRepository
{
    public function create(User $user): User
    {
        $newUser = new RepoUser;
        $newUser->password = Hash::make($user->getPassword());
        $newUser->email = $user->getEmail();
        $newUser->save();
        $user->setId($newUser->id);
        return $user;
    }

    public function get(string $id): ?User
    {
        $repoUser = RepoUser::find($id);
        return is_null($repoUser) ? null : MongoMapper::mapRepoUserToUser($repoUser);
    }

    public function getActiveYears(string $id)
    {
        $years = array();
        $user = RepoUser::find($id);
        $cursor = $user->transactions()->raw(function ($collection) use ($id) {
            return $collection->aggregate([
                ['$match' => ['owner_id' => ['$eq' => $id]]],
                ['$project' => ['year' => ['$year' => '$created_at'], '_id' => 0]],
                ['$group' => ['_id' => '$year']]
            ]);
        });
        foreach ($cursor as $document) {
            array_push($years, $document['_id']);
        }
        return $years;
    }

    public function getAll()
    {
        $users = array();
        $repoUsers = RepoUser::all();
        foreach ($repoUsers as $repoUser) {
            array_push($users, MongoMapper::mapRepoUserToUser($repoUser));
        }
        return $users;
    }

    public function update(User $user)
    {
    }

    public function delete($id)
    {
    }
}
