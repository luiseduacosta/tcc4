<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Questione;
use Authorization\IdentityInterface;

/**
 * Questiones policy
 */
class QuestionesPolicy
{
    /**
     * Check if $user can add questiones
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Questione $questione
     * @return bool
     */
    public function canAdd(IdentityInterface $user, Questione $questione)
    {
        return isset($user) && $user->categoria == '1';
    }

    /**
     * Check if $user can edit questiones
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Questione $questione
     * @return bool
     */
    public function canEdit(IdentityInterface $user, Questione $questione)
    {
        return isset($user) && $user->categoria == '1';
    }

    /**
     * Check if $user can delete questiones
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Questione $questione
     * @return bool
     */
    public function canDelete(IdentityInterface $user, Questione $questione)
    {
        return isset($user) && $user->categoria == '1';
    }

    /**
     * Check if $user can view questiones
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Questione $questione
     * @return bool
     */
    public function canView(IdentityInterface $user, Questione $questione)
    {
        return isset($user) && $user->categoria == '1';
    }
}
