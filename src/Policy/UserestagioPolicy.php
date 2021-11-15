<?php

declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Userestagio;
use Authorization\IdentityInterface;

/**
 * Userestagio policy
 */
class UserestagioPolicy {

    /**
     * Check if $user can add Userestagio
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Userestagio $userestagio
     * @return bool
     */
    public function canAdd(IdentityInterface $user, Userestagio $userestagio) {
        return isset($user->categoria) && $user->categoria == '1';
    }

    /**
     * Check if $user can edit Userestagio
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Userestagio $userestagio
     * @return bool
     */
    public function canEdit(IdentityInterface $user, Userestagio $userestagio) {
        return isset($user->categoria) && $user->categoria == '1';
    }

    /**
     * Check if $user can delete Userestagio
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Userestagio $userestagio
     * @return bool
     */
    public function canDelete(IdentityInterface $user, Userestagio $userestagio) {
        return isset($user->categoria) && $user->categoria == '1';
    }

    /**
     * Check if $user can view Userestagio
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Userestagio $userestagio
     * @return bool
     */
    public function canView(IdentityInterface $user, Userestagio $userestagio) {
        return isset($user->categoria) && $user->categoria == '1';
    }

}
