<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Resposta;
use Authorization\IdentityInterface;

/**
 * Respostas policy
 */
class RespostasPolicy
{
    /**
     * Check if $user can add respostas
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Resposta $resposta
     * @return bool
     */
    public function canAdd(IdentityInterface $user, Resposta $resposta)
    {
        return isset($user) && $user->categoria == '1';
    }

    /**
     * Check if $user can edit respostas
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Resposta $resposta
     * @return bool
     */
    public function canEdit(IdentityInterface $user, Resposta $resposta)
    {
        return isset($user) && $user->categoria == '1';
    }

    /**
     * Check if $user can delete respostas
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Resposta $resposta
     * @return bool
     */
    public function canDelete(IdentityInterface $user, Resposta $resposta)
    {
        return isset($user) && $user->categoria == '1';
    }

    /**
     * Check if $user can view respostas
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Resposta $resposta
     * @return bool
     */
    public function canView(IdentityInterface $user, Resposta $resposta)
    {
        return isset($user) && $user->categoria == '1';
    }
}
