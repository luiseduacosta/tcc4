<?php

declare(strict_types=1);

namespace App\Policy;

use App\Model\Table\UserestagiosTable;
use Authorization\IdentityInterface;

/**
 * Userestagios policy
 */
class UserestagiosTablePolicy {

    /**
     * Check if $user can index Areamonografias
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\Monografia $monografia
     * @return bool
     */
    public function canIndex(IdentityInterface $user, UserestagiosTable $userestagios) {
        return isset($user->categoria) && $user->categoria == '1';
    }

}
