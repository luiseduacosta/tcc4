<?php

declare(strict_types=1);

namespace App\Policy;

use App\Model\Table\MonografiasTable;
use Authorization\IdentityInterface;

/**
 * Monografias policy
 */
class MonografiasTablePolicy {

    /**
     * Check if $user can index Monografia
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\Monografia $monografia
     * @return bool
     */
    public function canIndex(IdentityInterface $user, Monografia $monografia) {

        return true;
        
    }

}
