<?php

declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Estudantemonografia;
use Authorization\IdentityInterface;

/**
 * Aluno policy
 */
class EstudantemonografiaPolicy {

    /**
     * Check if $user can create Aluno
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\Estudante $estudante
     * @return bool
     */
    public function canAdd(IdentityInterface $user, Estudantemonografa $estudantemonografia) {
        return isset($user->categoria) && $user->categoria == '1';
    }

    /**
     * Check if $user can update Aluno
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\Estudante $estudante
     * @return bool
     */
    public function canEdit(IdentityInterface $user, Estudantemonografia $estudantemonografia) {
        return isset($user->categoria) && $user->categoria == '1';
    }

    /**
     * Check if $user can delete Aluno
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\Estudante $estudante
     * @return bool
     */
    public function canDelete(IdentityInterface $user, Estudantemonografia $estudantemonografia) {
        return isset($user->categoria) && $user->categoria == '1';
    }

    /**
     * Check if $user can view Aluno
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\Estudante $estudante
     * @return bool
     */
    public function canView(IdentityInterface $user, Estudantemonografia $estudantemonografia) {
        return isset($user->categoria) && $user->categoria == '1';
    }

}
