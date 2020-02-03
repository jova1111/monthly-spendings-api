<?php

namespace App\Repositories\Mongo\Utils;

use App\Models\Category;
use App\Models\PlannedMonthlySpending;
use App\Models\Transaction;
use App\Models\User;
use App\Repositories\Mongo\Models\Category as RepoCategory;
use App\Repositories\Mongo\Models\PlannedMonthlySpending as RepoPlannedMonthlySpending;
use App\Repositories\Mongo\Models\Transaction as RepoTransaction;
use App\Repositories\Mongo\Models\User as RepoUser;

class MongoMapper
{
    public static function mapRepoTransactionToTransaction(?RepoTransaction $repoTransaction): ?Transaction
    {
        if (is_null($repoTransaction)) {
            return null;
        }
        $transaction = new Transaction;
        $transaction->setId($repoTransaction->id);
        $transaction->setAmount($repoTransaction->amount);
        $transaction->setDescription($repoTransaction->description);
        $transaction->setCreationDate($repoTransaction->created_at->toDateTimeString());
        $transaction->setCategory(MongoMapper::mapRepoCategoryToCategory($repoTransaction->category));
        $transaction->setOwner(MongoMapper::mapRepoUserToUser($repoTransaction->owner));
        return $transaction;
    }

    public static function mapRepoCategoryToCategory(?RepoCategory $repoCategory): ?Category
    {
        if (is_null($repoCategory)) {
            return null;
        }
        $category = new Category;
        $category->setName($repoCategory->name);
        $category->setId($repoCategory->id);
        $category->setCreationDate($repoCategory->created_at->toDateTimeString());
        $category->setOwner(MongoMapper::mapRepoUserToUser($repoCategory->owner));
        return $category;
    }

    public static function mapRepoUserToUser(?RepoUser $repoUser): ?User
    {
        if (is_null($repoUser)) {
            return null;
        }
        $user = new User;
        $user->setId($repoUser->id);
        $user->setEmail($repoUser->email);
        $user->setPassword($repoUser->password);
        return $user;
    }

    public static function mapRepoPlannedMonthlySpendingToPlannedMonthlySpending(?RepoPlannedMonthlySpending $repoPlannedMonthlySpending): ?PlannedMonthlySpending
    {
        if (is_null($repoPlannedMonthlySpending)) {
            return null;
        }
        $plannedMonthlySpending = new PlannedMonthlySpending;
        $plannedMonthlySpending->setId($repoPlannedMonthlySpending->id);
        $plannedMonthlySpending->setValue($repoPlannedMonthlySpending->value);
        $plannedMonthlySpending->setCreationDate($repoPlannedMonthlySpending->created_at->toDateTimeString());
        $plannedMonthlySpending->setOwner(MongoMapper::mapRepoUserToUser($repoPlannedMonthlySpending->owner));
        return $plannedMonthlySpending;
    }
}
