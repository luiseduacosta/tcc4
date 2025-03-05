<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Table\AreaestagiosTable;
use Authorization\IdentityInterface;

/**
 * Areaestagios policy
 */
class AreaestagiosTablePolicy {
    
    /**
     * Check if $user can index Areaestagios
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\AreaestagiosTable\Areaestagios $areaestagios
     * @return bool
     */
    public function canIndex(IdentityInterface $user, AreaestagiosTable $areaestagios) {
        return isset($user->categoria) && $user->categoria == '1';
    }
    
}
