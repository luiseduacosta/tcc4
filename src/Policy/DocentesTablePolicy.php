<?php

declare(strict_types=1);

namespace App\Policy;

use App\Model\Table\DocentesTable;
use Authorization\IdentityInterface;
use Authorization\Policy\Result;
/**
 * Docentes policy
 */
class DocentesTablePolicy {

    /**
     * Check if $user can index
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Docente $docente
     * @return bool
     */
    public function canIndex(IdentityInterface $user, DocentesTable $docentes) {

         if (isset($user->categoria) && $user->categoria == '1') {
             return true;
         }
         return false;
    }

}
