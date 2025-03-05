<?php

declare(strict_types=1);

namespace App\Policy;

use App\Model\Table\AlunosTable;
use Authorization\IdentityInterface;

/**
 * Alunos policy
 */
class AlunosTablePolicy {

    /**
     * Check if $user can index Alunos
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\AlunosTable\Alunos $alunos
     * @return bool
     */
    public function canIndex(IdentityInterface $user, AlunosTable $alunos) {
        return isset($user->categoria) && $user->categoria == '1';
    }

}
