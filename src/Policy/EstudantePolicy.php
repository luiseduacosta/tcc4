<?php

declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Estudante;
use Authorization\IdentityInterface;

/**
 * Estagiarios policy
 */
class EstudantePolicy {

    /**
     * Check if $user can index Estagiarios
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\EstagiariosTable\Estagiarios $estagiarios
     * @return bool
     */
    public function canAdd(IdentityInterface $user, Estudante $estudante) {
        return isset($user->categoria) && $user->categoria == '1';
    }
    
    /**
     * Check if $user can update Docente
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\Docente $docente
     * @return bool
     */
    public function canEdit(IdentityInterface $user, Estudante $estudante) {
        return isset($user->categoria) && $user->categoria == '1';
    }

    /**
     * Check if $user can delete Docente
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\Docente $docente
     * @return bool
     */
    public function canDelete(IdentityInterface $user, Estudante $estudante) {
        return isset($user->categoria) && $user->categoria == '1';
    }

    /**
     * Check if $user can view Docente
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\Docente $docente
     * @return bool
     */
    public function canView(IdentityInterface $user, Estudante $estudante) {
        return isset($user->categoria) && $user->categoria == '1';
    }

}
