<?php

declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Instituicaoestagio;
use Authorization\IdentityInterface;

/**
 * Instituicaoestagio policy
 */
class InstituicaoestagioPolicy {

    /**
     * Check if $user can add Instituicaoestagio
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Instituicaoestagio $instituicaoestagio
     * @return bool
     */
    public function canAdd(IdentityInterface $user, Instituicaoestagio $instituicaoestagio) {
        return isset($user->categoria) && $user->categoria == '1';
    }

    /**
     * Check if $user can edit Instituicaoestagio
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Instituicaoestagio $instituicaoestagio
     * @return bool
     */
    public function canEdit(IdentityInterface $user, Instituicaoestagio $instituicaoestagio) {
        return isset($user->categoria) && $user->categoria == '1';
    }

    /**
     * Check if $user can delete Instituicaoestagio
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Instituicaoestagio $instituicaoestagio
     * @return bool
     */
    public function canDelete(IdentityInterface $user, Instituicaoestagio $instituicaoestagio) {
        return isset($user->categoria) && $user->categoria == '1';
    }

    /**
     * Check if $user can view Instituicaoestagio
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Instituicaoestagio $instituicaoestagio
     * @return bool
     */
    public function canView(IdentityInterface $user, Instituicaoestagio $instituicaoestagio) {
        return isset($user->categoria) && $user->categoria == '1';
    }

}
