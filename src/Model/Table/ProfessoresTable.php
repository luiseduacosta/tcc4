<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Professor Model
 *
 * @property \App\Model\Table\MonografiasTable&\Cake\ORM\Association\HasMany $Monografias
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\HasMany $Users
 * 
 * @method \App\Model\Entity\Professor get($primaryKey, $options = [])
 * @method \App\Model\Entity\Professor newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Professor[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Professor|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Professor saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Professor patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Professor[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Professor findOrCreate($search, callable $callback = null, $options = [])
 */
class ProfessoresTable extends Table
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

                $this->setTable('professores');
                $this->setAlias('Professores');
                $this->setDisplayField('nome');
                $this->setPrimaryKey('id');

                /** monografias.professor_id aponta para o(a) orientador(a) */
                $this->hasMany('Monografias', [
                        'className' => 'Monografias',
                        'foreignKey' => 'professor_id',
                ]);

                $this->hasMany('Users', [
                        'foreignKey' => 'professor_id',
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
                        ->scalar('nome')
                        ->maxLength('nome', 50)
                        ->notEmptyString('nome');

                $validator
                        ->scalar('cpf')
                        ->maxLength('cpf', 15)
                        ->allowEmptyString('cpf');

                $validator
                        ->integer('siape')
                        ->allowEmptyString('siape');

                $validator
                        ->scalar('cress')
                        ->maxLength('cress', 10)
                        ->allowEmptyString('cress');

                $validator
                        ->scalar('regiao')
                        ->maxLength('regiao', 2)
                        ->allowEmptyString('regiao');

                $validator
                        ->integer('codigo_telefone')
                        ->allowEmptyString('codigo_telefone');

                $validator
                        ->scalar('telefone')
                        ->maxLength('telefone', 15)
                        ->allowEmptyString('telefone');

                $validator
                        ->integer('codigo_celular')
                        ->allowEmptyString('codigo_celular');

                $validator
                        ->scalar('celular')
                        ->maxLength('celular', 15)
                        ->allowEmptyString('celular');

                $validator
                        ->email('email')
                        ->maxLength('email', 255)
                        ->allowEmptyString('email');

                $validator
                        ->scalar('curriculolattes')
                        ->maxLength('curriculolattes', 50)
                        ->allowEmptyString('curriculolattes');

                $validator
                        ->date('atualizacaolattes')
                        ->allowEmptyDate('atualizacaolattes');

                $validator
                        ->date('dataingresso')
                        ->allowEmptyDate('dataingresso');

                $validator
                        ->scalar('departamento')
                        ->maxLength('departamento', 30)
                        ->allowEmptyString('departamento');

                $validator
                        ->date('dataegresso')
                        ->allowEmptyDate('dataegresso');

                $validator
                        ->scalar('motivoegresso')
                        ->maxLength('motivoegresso', 100)
                        ->allowEmptyString('motivoegresso');

                $validator
                        ->scalar('status')
                        ->maxLength('status', 10)
                        ->notEmptyString('status');

                $validator
                        ->scalar('observacoes')
                        ->allowEmptyString('observacoes');

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
                // $rules->add($rules->isUnique(['email']));

                return $rules;
        }
}
