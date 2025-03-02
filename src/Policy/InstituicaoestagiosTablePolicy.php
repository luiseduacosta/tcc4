<?php

declare(strict_types=1);

namespace App\Policy;

use App\Model\Table\InstituicaoestagiosTable;
use Authorization\IdentityInterface;

/**
 * Instituicaoestagios policy
 */
class InstituicaoestagiosTablePolicy {

    /**
     * Check if $user can index Instituicaoestagios
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\Instituicaoestagio $instituicaoestagio
     * @return bool
     */
    public function canIndex(IdentityInterface $user, InstituicaoestagiosTable $instituicaoestagios) {
        return isset($user->categoria) && $user->categoria == '1';
    }

}
