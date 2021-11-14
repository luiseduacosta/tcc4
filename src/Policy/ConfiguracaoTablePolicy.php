<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Table\ConfiguracaoTable;
use Authorization\IdentityInterface;

/**
 * Configuracao policy
 */
class ConfiguracaoTablePolicy {   
    
    /**
     * Check if $user can index configuracao
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\ConfiguracaoTable\Configuracao $configuracao
     * @return bool
     */
    public function canIndex(IdentityInterface $user, ConfiguracaoTable $configuracao) {

        return isset($user->categoria) && $user->categoria == '1';
    }

    
}
