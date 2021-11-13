<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Table\EstudantesTable;
use Authorization\IdentityInterface;

/**
 * Estudantes policy
 */
class EstudantesTablePolicy {
    
    /**
     * Check if $user can index Areamonografias
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\Monografia $monografia
     * @return bool
     */
    public function canIndex(IdentityInterface $user, EstagiariosTable $estagiarios) {

        return true;
    }

}
