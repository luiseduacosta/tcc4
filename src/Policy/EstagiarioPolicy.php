<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Estagiario;
use Authorization\IdentityInterface;

/**
 * Estagiario policy
 */
class EstagiarioPolicy
{
        /**
         * Check if $user can create Estagiario
         *
         * @param Authorization\IdentityInterface $user The user.
         * @param App\Model\Entity\Estagiario $estagiario
         * @return bool
         */
        public function canAdd(IdentityInterface $user, Estagiario $estagiario)
        {
                return isset($user->categoria) && $user->categoria == '1';
        }

        /**
         * Check if $user can update Estagiario
         *
         * @param Authorization\IdentityInterface $user The user.
         * @param App\Model\Entity\Estagiario $estagiario
         * @return bool
         */
        public function canEdit(IdentityInterface $user, Estagiario $estagiario)
        {
                return isset($user->categoria) && $user->categoria == '1';
        }

        /**
         * Check if $user can delete Estagiario
         *
         * @param Authorization\IdentityInterface $user The user.
         * @param App\Model\Entity\Estagiario $estagiario
         * @return bool
         */
        public function canDelete(IdentityInterface $user, Estagiario $estagiario)
        {
                return isset($user->categoria) && $user->categoria == '1';
        }

        /**
         * Check if $user can view Estagiario
         *
         * @param Authorization\IdentityInterface $user The user.
         * @param App\Model\Entity\Estagiario $estagiario
         * @return bool
         */
        public function canView(IdentityInterface $user, Estagiario $estagiario)
        {
                return false;
        }


}
