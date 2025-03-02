<?php

declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Areaestagio;
use Authorization\IdentityInterface;

/**
 * Areaestagio policy
 */
class AreaestagioPolicy {

    /**
     * Check if $user can add Areaestagio
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Areaestagio $areaestagio
     * @return bool
     */
    public function canAdd(IdentityInterface $user, Areaestagio $areaestagio) {       
        return isset($user->categoria) && $user->categoria == '1';
    }

    /**
     * Check if $user can edit Areaestagio
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Areaestagio $areaestagio
     * @return bool
     */
    public function canEdit(IdentityInterface $user, Areaestagio $areaestagio) {
        return isset($user->categoria) && $user->categoria == '1';
    }

    /**
     * Check if $user can delete Areaestagio
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Areaestagio $areaestagio
     * @return bool
     */
    public function canDelete(IdentityInterface $user, Areaestagio $areaestagio) {
        return isset($user->categoria) && $user->categoria == '1';
    }

    /**
     * Check if $user can view Areaestagio
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Areaestagio $areaestagio
     * @return bool
     */
    public function canView(IdentityInterface $user, Areaestagio $areaestagio) {
        return true;
    }

}
