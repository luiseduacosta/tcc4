<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Table\DocentesTable;
use Authorization\IdentityInterface;

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

        if ($user->categoria == '1') {
            return true;
        }
        return false;
    }

    /**
     * Check if $user can index0 
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Docente $docente
     * @return bool
     */
    public function canIndex0(IdentityInterface $user, DocentesTable $docentes) {

        if ($user->categoria == '1') {
            return true;
        }
        return false;
    }

    /**
     * Check if $user can index1 
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Docente $docente
     * @return bool
     */
    public function canIndex1(IdentityInterface $user, DocentesTable $docentes) {

        if ($user->categoria == '1') {
            return true;
        }
        return false;
    }

    /**
     * Check if $user can index2 
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Docente $docente
     * @return bool
     */
    public function canIndex2(IdentityInterface $user, DocentesTable $docentes) {

        if ($user->categoria == '1') {
            return true;
        }
        return false;
    }

        /**
     * Check if $user can index3 
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Docente $docente
     * @return bool
     */
    public function canIndex3(IdentityInterface $user, DocentesTable $docentes) {

        if ($user->categoria == '1') {
            return true;
        }
        return false;
    }

}
