<?php

declare(strict_types=1);

namespace App\Policy;

use App\Model\Table\UsersTable;
use Authorization\IdentityInterface;

/**
 * Users policy
 */
class UsersTablePolicy {

    /**
     * Check if $user can index Users
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\Monografia $monografia
     * @return bool
     */
    public function canIndex(IdentityInterface $user, UsersTable $users) {

        return isset($user->categoria) && $user->categoria == '1';
    }

}
