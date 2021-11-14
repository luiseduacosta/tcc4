<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Table\ComplementosTable;
use Authorization\IdentityInterface;

/**
 * Complemento policy
 */
class ComplementosTablePolicy
{

    /**
     * Check if $user can index Complementos
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\ComplementosTable\Complementos $complementos
     * @return bool
     */
    public function canIndex(IdentityInterface $user, ComplementosTable $complementos) {

        return isset($user->categoria) && $user->categoria == '1';
    }
    
}
