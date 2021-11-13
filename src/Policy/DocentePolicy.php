<?php

declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Docente;
use Authorization\IdentityInterface;

/**
 * Docente policy
 */
class DocentePolicy {

    /**
     * Check if $user can create Docente
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\Docente $docente
     * @return bool
     */
    public function canAdd(IdentityInterface $user, Docente $docente) {

        return isset($user->categoria) && $user->categoria == '1';
    }

    /**
     * Check if $user can update Docente
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\Docente $docente
     * @return bool
     */
    public function canEdit(IdentityInterface $user, Docente $docente) {

        return isset($user->categoria) && $user->categoria == '1';
    }

    /**
     * Check if $user can delete Docente
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\Docente $docente
     * @return bool
     */
    public function canDelete(IdentityInterface $user, Docente $docente) {

        return isset($user->categoria) && $user->categoria == '1';
    }

    /**
     * Check if $user can view Docente
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\Docente $docente
     * @return bool
     */
    public function canView(IdentityInterface $user, Docente $docente) {

        return isset($user->categoria) && $user->categoria == '1';
    }

}
