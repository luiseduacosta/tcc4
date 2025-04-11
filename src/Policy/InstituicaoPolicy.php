<?php

declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Instituicao;
use Authorization\IdentityInterface;

/**
 * Instituicao policy
 */
class InstituicaoPolicy {

    /**
     * Check if $user can create Aluno
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Instituicao $instituicao
     * @return bool
     */
    public function canAdd(?IdentityInterface $user, Instituicao $instituicao) {
        return isset($user) && $user->categoria == '1';
    }

    /**
     * Check if $user can update Aluno
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Instituicao $instituicao
     * @return bool
     */
    public function canEdit(?IdentityInterface $user, Instituicao $instituicao) {
        return isset($user) && $user->categoria == '1';
    }

    /**
     * Check if $user can delete Aluno
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Instituicao $instituicao
     * @return bool
     */
    public function canDelete(?IdentityInterface $user, Instituicao $instituicao) {
        return isset($user) && $user->categoria == '1';
    }

    /**
     * Check if $user can view Aluno
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Instituicao $instituicao
     * @return bool
     */
    public function canView(?IdentityInterface $user, Instituicao $instituicao) {
        return true;
    }

}
