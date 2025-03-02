<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Table\AreainstituicoesTable;
use Authorization\IdentityInterface;

/**
 * Areainstituicoes policy
 */
class AreainstituicoesTablePolicy {
    
    /**
     * Check if $user can index Areainstituicoes
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\AreainstituicoesTable\Areainstituicoes $areainstituicoes
     * @return bool
     */
    public function canIndex(IdentityInterface $user, AreainstituicoesTable $areainstituicoes) {
        return isset($user->categoria) && $user->categoria == '1';
    }

}
