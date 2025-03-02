<?php

declare(strict_types=1);

namespace App\Policy;

use App\Model\Table\EstudantemonografiasTable;
use Authorization\IdentityInterface;

/**
 * Estudantemonografias TablePolicy
 */
class EstudantemonografiasTablePolicy {

    /**
     * Check if $user can index Estudantes
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Table\Estudantes $estudantes
     * @return bool
     */
    public function canIndex(IdentityInterface $user, EstudantemonografiasTable $estudantemonografias) {
        return isset($user->categoria) && $user->categoria == '1';
    }

    public function canIndex1(IdentityInterface $user, EstudantemonografiasTable $estudantemonografias) {
        return isset($user->categoria) && $user->categoria == '1';
    }

    public function canIndex2(IdentityInterface $user, EstudantemonografiasTable $estudantemonografias) {
        return isset($user->categoria) && $user->categoria == '1';
    }

}
