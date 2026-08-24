<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Monografias Model
 *
 * @property \App\Model\Table\ProfessoresTable&\Cake\ORM\Association\BelongsTo $Professores
 * @property \App\Model\Table\TccestudantesTable&\Cake\ORM\Association\HasMany $Tccestudantes
 * @property \App\Model\Table\AreamonografiasTable&\Cake\ORM\Association\BelongsTo $Areamonografias
 *
 * @method \App\Model\Entity\Monografia newEmptyEntity()
 * @method \App\Model\Entity\Monografia newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Monografia[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Monografia get($primaryKey, $options = [])
 * @method \App\Model\Entity\Monografia findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Monografia patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Monografia[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Monografia|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Monografia saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Monografia[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Monografia[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Monografia[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Monografia[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class MonografiasTable extends Table
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

                // Areamonografias tem monografias. Quantas monografias tem uma area
                $this->addBehavior('CounterCache', [
                        'Areamonografias' => ['q_monografia'] // Caches monografia count on the 'Areamonografias' table
                ]);

                $this->setTable('monografias');
                $this->setAlias('Monografias');
                $this->setDisplayField('titulo');
                $this->setPrimaryKey('id');

                $this->belongsTo('Professores', [
                        'className' => 'Professores',
                        'propertyName' => 'professor',
                        'foreignKey' => 'professor_id',
                ]);

                $this->belongsTo('ProfessoresCoorienta', [
                        'className' => 'Professores',
                        'foreignKey' => 'num_co_orienta',
                        'propertyName' => 'professor_coorienta',
                        'joinType' => 'LEFT',
                ]);

                $this->belongsTo('ProfessoresBanca1', [
                        'className' => 'Professores',
                        'foreignKey' => 'banca1',
                        'propertyName' => 'professor_banca1',
                ]);

                $this->belongsTo('ProfessoresBanca2', [
                        'className' => 'Professores',
                        'foreignKey' => 'banca2',
                        'propertyName' => 'professor_banca2',
                ]);

                $this->belongsTo('ProfessoresBanca3', [
                        'className' => 'Professores',
                        'foreignKey' => 'banca3',
                        'propertyName' => 'professor_banca3',
                ]);

                $this->belongsTo('Areamonografias', [
                        'propertyName' => 'areamonografias',
                        'className' => 'Areamonografias',
                        'foreignKey' => 'areamonografia_id',
                        'joinType' => 'LEFT'
                ]);

                // Tccestudantes tem um campo monografia_id
                $this->hasMany('Tccestudantes', [
                        'propertyName' => 'tccestudantes',
                        'className' => 'Tccestudantes',
                        'foreignKey' => 'monografia_id',
                ]);
        }

        /**
         * Default validation rules.
         *
         * @param Validator $validator Validator instance.
         * @return Validator
         */
        public function validationDefault(Validator $validator): Validator
        {
                $validator
                        ->integer('id')
                        ->allowEmptyString('id', null, 'create');

                $validator
                        ->integer('catalogo')
                        ->allowEmptyString('catalogo');

                $validator
                        ->scalar('titulo')
                        ->maxLength('titulo', 180)
                        ->allowEmptyString('titulo');

                $validator
                        ->scalar('resumo')
                        ->maxLength('resumo', 7398)
                        ->allowEmptyString('resumo');

                $validator
                        ->scalar('periodo')
                        ->maxLength('periodo', 6)
                        ->allowEmptyString('periodo');

                $validator
                        ->integer('professor_id')
                        ->allowEmptyString('professor_id');

                $validator
                        ->integer('num_co_orienta')
                        ->allowEmptyString('num_co_orienta');

                $validator
                        ->integer('areamonografia_id')
                        ->allowEmptyString('areamonografia_id');

                $validator
                        ->scalar('data_defesa')
                        ->maxLength('data_defesa', 10)
                        ->allowEmptyString('data_defesa');

                $validator
                        ->integer('banca1')
                        ->allowEmptyString('banca1');

                $validator
                        ->integer('banca2')
                        ->allowEmptyString('banca2');

                $validator
                        ->integer('banca3')
                        ->allowEmptyString('banca3');

                $validator
                        ->scalar('convidado')
                        ->maxLength('convidado', 50)
                        ->allowEmptyString('convidado');

                $validator
                        ->scalar('url')
                        ->maxLength('url', 13)
                        ->allowEmptyString('url');

                return $validator;
        }

        /**
         * Returns a rules checker object that will be used for validating
         * application integrity.
         *
         * @param RulesChecker $rules The rules object to be modified.
         * @return RulesChecker
         */
        public function buildRules(RulesChecker $rules): RulesChecker
        {
                $rules->add($rules->existsIn(['professor_id'], 'Professores'));
                $rules->add($rules->existsIn(['areamonografia_id'], 'Areamonografias'));

                return $rules;
        }
}
