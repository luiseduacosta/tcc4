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
 * @property \App\Model\Table\DocentesTable&\Cake\ORM\Association\BelongsTo $Docentes
 * @property \App\Model\Table\DocentesTable&\Cake\ORM\Association\BelongsTo $Docentes1
 * @property \App\Model\Table\DocentesTable&\Cake\ORM\Association\BelongsTo $Docentes2
 * @property \App\Model\Table\TccestudantesTable&\Cake\ORM\Association\HasMany $Tccestudantes
 * @property \App\Model\Table\AreamonografiasTable&\Cake\ORM\Association\BelongsTo $Areasmonografias
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

                $this->setTable('monografias');
                $this->setDisplayField('titulo');
                $this->setPrimaryKey('id');

                // Monografia tem um campo docente_id
                $this->belongsTo('Docentes', [
                        'className' => 'Docentes',
                        'foreignKey' => 'docente_id',
                ]);

                // Banca 1 é o docente_id //
                // Banca 2 é um docente
                $this->belongsTo('Docentes1', [
                        'className' => 'Docentes',
                        'foreignKey' => 'banca2',
                ]);

                // Banca 3 é um docente
                $this->belongsTo('Docentes2', [
                        'className' => 'Docentes',
                        'foreignKey' => 'banca3',
                ]);

                // Tccestudantes tem um campo monografia_id
                $this->hasMany('Tccestudantes', [
                        'foreignKey' => 'monografia_id',
                        'joinType' => 'LEFT'
                ]);

                $this->belongsTo('Areamonografias', [
                        'foreignKey' => 'areamonografia_id',
                        'joinType' => 'LEFT'
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
                /*
                  $validator
                  ->scalar('data')
                  ->maxLength('data', 10)
                  ->allowEmptyString('data');
                 */
                $validator
                        ->scalar('periodo')
                        ->maxLength('periodo', 6)
                        ->allowEmptyString('periodo');

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
                /*
                  $validator
                  ->dateTime('timestamp')
                  ->allowEmptyDateTime('timestamp');
                 */
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
                $rules->add($rules->existsIn(['docente_id'], 'Docentes'));
                $rules->add($rules->existsIn(['areamonografia_id'], 'Areamonografias'));

                return $rules;
        }

}
