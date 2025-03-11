<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Areamonografias Model
 *
 * @property \App\Model\Table\MonografiasTable&\Cake\ORM\Association\HasMany $Monografias
 * @property \App\Model\Table\ProfessoresTable&\Cake\ORM\Association\BelongsToMany $Professores
 *
 * @method \App\Model\Entity\Areamonografia newEmptyEntity()
 * @method \App\Model\Entity\Areamonografia newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Areamonografia[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Areamonografia get($primaryKey, $options = [])
 * @method \App\Model\Entity\Areamonografia findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Areamonografia patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Areamonografia[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Areamonografia|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Areamonografia saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Areamonografia[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Areamonografia[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Areamonografia[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Areamonografia[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class AreamonografiasTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('areamonografias');
        $this->setDisplayField('area');
        $this->setPrimaryKey('id');

        $this->hasMany('Monografias', [
            'foreignKey' => 'areamonografia_id',
        ]);
        $this->belongsToMany('Professores', [
            'targetForeignKey' => 'professor_id',
            'foreignKey' => 'areamonografia_id',
            'joinTable' => 'areamonografias_Professores',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('area')
            ->maxLength('area', 50)
            ->notEmptyString('area');

        return $validator;
    }

}
