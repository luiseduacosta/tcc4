<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Estagiarios Model
 *
 * @property \App\Model\Table\EstudantesTable&\Cake\ORM\Association\BelongsTo $Estudantes 
 * @property \App\Model\Table\DocentesTable&\Cake\ORM\Association\BelongsTo $Docentes
 * @property \App\Model\Table\AreaestagiosTable&\Cake\ORM\Association\BelongsTo $Areaestagios
 * @property \App\Model\Table\SupervisoresTable&\Cake\ORM\Association\BelongsTo $Supervisores
 * @property \App\Model\Table\InstituicaoestagiosTable&\Cake\ORM\Association\BelongsTo $Instituicaoesestagio
 * @property \App\Model\Table\AvaliacoesTable&\Cake\ORM\Association\HasOne $Avaliacao
 * @property \App\Model\Table\FolhadeatividadesTable&\Cake\ORM\Association\HasOne $Folhadeatividade 
 * @property \App\Model\Table\TccestudantesTable&\Cake\ORM\Association\BelongsTo $Tccestudantes
 * 
 * @method \App\Model\Entity\Estagiario get($primaryKey, $options = [])
 * @method \App\Model\Entity\Estagiario newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Estagiario[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Estagiario|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Estagiario saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Estagiario patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Estagiario[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Estagiario findOrCreate($search, callable $callback = null, $options = [])
 */
class EstagiariosTable extends Table
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

                $this->setTable('estagiarios');
                $this->setDisplayField('id');
                $this->setPrimaryKey('id');

                $this->belongsTo('Estudantes', [
                        'className' => 'Estudantes',
                        'foreignKey' => 'alunonovo_id',
                        'joinType' => 'LEFT',
                ]);

                $this->belongsTo('Docentes', [
                        'foreignKey' => 'docente_id',
                ]);

                $this->belongsTo('Areaestagios', [
                        'foreignKey' => 'area_id',
                ]);
                $this->belongsTo('Supervisores', [
                        'foreignKey' => 'supervisor_id',
                ]);

                $this->belongsTo('Instituicaoestagios', [
                        'foreignKey' => 'instituicao_id',
                ]);
                $this->hasOne('Avaliacoes', [
                        'foreignKey' => 'estagiario_id',
                ]);
                $this->hasOne('Folhadeatividades', [
                        'foreignKey' => 'estagiario_id',
                ]);
                $this->belongsTo('Tccestudantes', [
                        'className' => 'Tccestudantes',
                        'foreignKey' => FALSE,
                        'conditions' => 'Estagiarios.registro = Tccestudantes.registro',
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
                        ->integer('registro')
                        ->notEmptyString('registro');

                $validator
                        ->multipleOptions('turno', ['D' => 'Diurno', 'N' => 'Noturno', 'I' => 'Indefinido'], 'Selecione um turno')
                        ->scalar('turno')
                        ->maxLength('turno', 1)
                        ->notEmptyString('turno');

                $validator
                        ->inList('nivel', ['1', '2', '3', '4'], 'Selecione um dos níveis')
                        ->scalar('nivel')
                        ->maxLength('nivel', 1)
                        ->notEmptyString('nivel');

                $validator
                        ->multipleOptions('tc', ['0' => '0', '1' => '1'])
                        ->notEmptyString('tc');

                $validator
                        ->date('tc_solicitacao')
                        ->allowEmptyDate('tc_solicitacao');

                $validator
                        ->notEmptyString('instituicao_id');

                $validator
                        ->notEmptyString('supervisor_id');

                $validator
                        ->scalar('periodo')
                        ->maxLength('periodo', 6)
                        ->notEmptyString('periodo');

                $validator
                        ->naturalNumber('id_area')
                        ->allowEmptyString('id_area');

                $validator
                        ->decimal('nota')
                        ->range('nota', ['0', '10'], 'Digite a nota')
                        ->allowEmptyString('nota');

                $validator
                        ->allowEmptyString('ch');

                $validator
                        ->scalar('observacoes')
                        ->maxLength('observacoes', 255)
                        ->allowEmptyString('observacoes');

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
                $rules->add($rules->existsIn(['docente_id'], 'Docentes'));

                return $rules;
        }

}
