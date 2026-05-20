<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Questao;
use Authorization\IdentityInterface;

/**
 * Questoes policy
 */
class QuestoesPolicy
{
    /**
     * Check if $user can add questoes
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Questao $questao
     * @return bool
     */
    public function canAdd(IdentityInterface $user, Questao $questao)
    {
        return isset($user) && $user->categoria == '1';
    }

    /**
     * Check if $user can edit questoes
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Questao $questao
     * @return bool
     */
    public function canEdit(IdentityInterface $user, Questao $questao)
    {
        return isset($user) && $user->categoria == '1';
    }

    /**
     * Check if $user can delete questoes
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Questao $questao
     * @return bool
     */
    public function canDelete(IdentityInterface $user, Questao $questao)
    {
        return isset($user) && $user->categoria == '1';
    }

    /**
     * Check if $user can view questoes
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Questao $questao
     * @return bool
     */
    public function canView(IdentityInterface $user, Questao $questao)
    {
        return isset($user) && $user->categoria == '1';
    }
}
