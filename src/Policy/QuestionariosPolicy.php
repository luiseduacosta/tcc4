<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Questionario;
use Authorization\IdentityInterface;

/**
 * Questionarios policy
 */
class QuestionariosPolicy
{
    /**
     * Check if $user can add questionarios
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Questionario $questionario
     * @return bool
     */
    public function canAdd(IdentityInterface $user, Questionario $questionario)
    {
        return isset($user) && $user->categoria == '1';
    }

    /**
     * Check if $user can edit questionarios
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Questionario $questionario
     * @return bool
     */
    public function canEdit(IdentityInterface $user, Questionario $questionario)
    {
        return isset($user) && $user->categoria == '1';
    }

    /**
     * Check if $user can delete questionarios
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Questionario $questionario
     * @return bool
     */
    public function canDelete(IdentityInterface $user, Questionario $questionario)
    {
        return isset($user) && $user->categoria == '1';
    }

    /**
     * Check if $user can view questionarios
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Questionario $questionario
     * @return bool
     */
    public function canView(IdentityInterface $user, Questionario $questionario)
    {
        return isset($user) && $user->categoria == '1';
    }
}
