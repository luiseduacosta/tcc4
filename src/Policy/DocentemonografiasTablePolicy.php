<?php

declare(strict_types=1);

namespace App\Policy;

use App\Model\Table\DocentemonografiasTable;
use Authorization\IdentityInterface;
use Authorization\Policy\Result;
/**
 * Docentemonografias policy
 */
class DocentemonografiasTablePolicy {

    /**
     * Check if $user can index
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Docente $docente
     * @return bool
     */
    public function canIndex(IdentityInterface $user, DocentemonografiasTable $docentemonografias) {

         if (isset($user->categoria) && $user->categoria == '1') {
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
    public function canIndex0(IdentityInterface $user, DocentemonografiasTable $docentemonografias) {

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
    public function canIndex1(IdentityInterface $user, DocentemonografiasTable $docentemonografias) {

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
    public function canIndex2(IdentityInterface $user, DocentemonografiasTable $docentemonografias) {

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
    public function canIndex3(IdentityInterface $user, DocentemonografiasTable $docentemonografias) {

        if ($user->categoria == '1') {
            return true;
        }
        return false;
    }

}
