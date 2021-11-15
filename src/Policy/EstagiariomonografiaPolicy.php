<?php

declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Estagiariomonografia;
use Authorization\IdentityInterface;

/**
 * Estagiario policy
 */
class EstagiariomonografiaPolicy {

    /**
     * Check if $user can create Estagiario
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\Estagiario $estagiario
     * @return bool
     */
    public function canAdd(IdentityInterface $user, Estagiariomonografia $estagiariomonografia) {
        return isset($user->categoria) && $user->categoria == '1';
    }

    /**
     * Check if $user can update Estagiario
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\Estagiario $estagiario
     * @return bool
     */
    public function canEdit(IdentityInterface $user, Estagiariomonografia $estagiariomonografia) {
        return isset($user->categoria) && $user->categoria == '1';
    }

    /**
     * Check if $user can delete Estagiario
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\Estagiario $estagiario
     * @return bool
     */
    public function canDelete(IdentityInterface $user, Estagiario $estagiario) {
        return isset($user->categoria) && $user->categoria == '1';
    }

    /**
     * Check if $user can view Estagiario
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\Estagiario $estagiario
     * @return bool
     */
    public function canView(IdentityInterface $user, Estagiario $estagiario) {
        return isset($user->categoria) && $user->categoria == '1';
    }

}
