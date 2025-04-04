<?php

declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Aluno;
use App\Model\Entity\Monografia;
use Authorization\IdentityInterface;

/**
 * Aluno policy
 */
use Cake\ORM\TableRegistry;

class AlunoPolicy {

    /**
     * Check if $user can add Aluno
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Aluno $aluno
     * @return bool
     */
    public function canAdd(IdentityInterface $user, Aluno $aluno) {
        return isset($user->categoria) && $user->categoria == '1';
    }

    /**
     * Check if $user can edit Aluno
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Aluno $aluno
     * @return bool
     */
    public function canEdit(IdentityInterface $user, Aluno $aluno) {
        return isset($user->categoria) && $user->categoria == '1' || $this->isAuthor($user, $aluno);
    }

    /**
     * Check if $user can delete Aluno
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Aluno $aluno
     * @return bool
     */
    public function canDelete(IdentityInterface $user, Aluno $aluno) {
        return isset($user->categoria) && $user->categoria == '1';
    }

    /**
     * Check if $user can view Aluno
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Aluno $aluno
     * @return bool
     */
    public function canView(IdentityInterface $user, Aluno $aluno) {
        return isset($user->categoria) && $user->categoria == '1';
    }
    protected function isAuthor(IdentityInterface $user, Aluno $aluno)
    {
        $userEntity = $user->getOriginalData();
        return $aluno->id === $userEntity->getIdentifier()['estudante_id'];
    }

}
