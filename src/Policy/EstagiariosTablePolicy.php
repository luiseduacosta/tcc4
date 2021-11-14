<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Table\EstagiariosTable;
use Authorization\IdentityInterface;

/**
 * Estagiarios policy
 */
class EstagiariosTablePolicy {
    
    /**
     * Check if $user can index Estagiarios
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\EstagiariosTable\Estagiarios $estagiarios
     * @return bool
     */
    public function canIndex(IdentityInterface $user, EstagiariosTable $estagiarios) {

        return true;
    }

}
