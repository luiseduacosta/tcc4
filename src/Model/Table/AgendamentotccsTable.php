<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Agendamentotccs Model
 *
 * @property \App\Model\Table\EstudantesTable&\Cake\ORM\Association\BelongsTo $Estudantes
 * @property \App\Model\Table\DocentesTable&\Cake\ORM\Association\BelongsTo $Docentes
 * @property \App\Model\Table\ProfessoresTable&\Cake\ORM\Association\BelongsTo $Professorbanca1
 * @property \App\Model\Table\ProfessoresTable&\Cake\ORM\Association\BelongsTo $Professorbanca2
 *    
 * @method \App\Model\Entity\Agendamentotcc newEmptyEntity()
 * @method \App\Model\Entity\Agendamentotcc newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Agendamentotcc[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Agendamentotcc get($primaryKey, $options = [])
 * @method \App\Model\Entity\Agendamentotcc findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Agendamentotcc patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Agendamentotcc[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Agendamentotcc|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Agendamentotcc saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Agendamentotcc[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Agendamentotcc[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Agendamentotcc[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Agendamentotcc[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class AgendamentotccsTable extends Table
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

                $this->setTable('agendamentotccs');
                $this->setAlias('Agendamentotccs');
                $this->setDisplayField('id');
                $this->setPrimaryKey('id');

                $this->belongsTo('Estudantes', [
                        'foreignKey' => 'estudante_id',
                        'joinType' => 'LEFT',
                ]);
                $this->belongsTo('Docentes', [
                        'className' => 'Docentes',
                        'foreignKey' => 'docente_id',
                        'joinType' => 'LEFT',
                ]);

                $this->belongsTo('Professorbanca1', [
                        'className' => 'Docentes',
                        'propertyName' => 'professorbanca1',
                        'foreignKey' => 'banca1',
                        'joinType' => 'LEFT',
                ]);

                $this->belongsTo('Professorbanca2', [
                        'className' => 'Docentes',
                        'propertyName' => 'professorbanca2',
                        'foreignKey' => 'banca2',
                        'joinType' => 'LEFT',
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
                        ->integer('id')
                        ->allowEmptyString('id', null, 'create');

                $validator
                        ->integer('banca1')
                        ->requirePresence('banca1', 'create')
                        ->notEmptyString('banca1');

                $validator
                        ->integer('banca2')
                        ->requirePresence('banca2', 'create')
                        ->notEmptyString('banca2');

                $validator
                        ->date('data')
                        ->requirePresence('data', 'create')
                        ->notEmptyDate('data');

                $validator
                        ->time('horario')
                        ->requirePresence('horario', 'create')
                        ->notEmptyTime('horario');

                $validator
                        ->scalar('sala')
                        ->maxLength('sala', 15)
                        ->requirePresence('sala', 'create')
                        ->notEmptyString('sala');

                $validator
                        ->scalar('convidado')
                        ->maxLength('convidado', 30)
                        ->allowEmptyString('convidado');

                $validator
                        ->scalar('titulo')
                        ->maxLength('titulo', 180)
                        ->requirePresence('titulo', 'create')
                        ->notEmptyString('titulo');

                $validator
                        ->scalar('avaliacao')
                        ->maxLength('avaliacao', 10)
                        ->allowEmptyString('avaliacao');

                return $validator;
        }

        /**
         * Returns a rules checker object that will be used for validating
         * application integrity.
         *
         * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
         * @return \Cake\ORM\RulesChecker
         */
        public function buildRules(RulesChecker $rules): RulesChecker
        {
                $rules->add($rules->existsIn(['aluno_id'], 'Alunos'));
                $rules->add($rules->existsIn(['professor_id'], 'Docentes'));

                return $rules;
        }

}
