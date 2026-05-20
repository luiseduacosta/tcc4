<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Table\ConfiguracoesTable;
use Authorization\IdentityInterface;

/**
 * Configuracao policy
 */
class ConfiguracaoTablePolicy {   
    
    /**
     * Check if $user can index configuracao
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Table\ConfiguracoesTable $configuracoes
     * @return bool
     */
    public function canIndex(IdentityInterface $user, ConfiguracoesTable $configuracoes) {
        
        if (isset($user->categoria) && $user->categoria == '1') {
            return true;
        }
        return true;
    }
    
}
