<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Docentes Model
 *
 * @property \App\Model\Table\EstagiariosTable&\Cake\ORM\Association\HasMany $Estagiarios
 * @property \App\Model\Table\MuralestagiosTable&\Cake\ORM\Association\HasMany $Muralestagios
 * @property \App\Model\Table\UserestagiosTable&\Cake\ORM\Association\HasMany $Userestagios
 *
 * @method \App\Model\Entity\Docente newEmptyEntity()
 * @method \App\Model\Entity\Docente newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Docente[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Docente get($primaryKey, $options = [])
 * @method \App\Model\Entity\Docente findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Docente patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Docente[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Docente|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Docente saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Docente[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Docente[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Docente[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Docente[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class DocentesTable extends Table {

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void {
        parent::initialize($config);

        $this->setTable('docentes');
        $this->setAlias('docentes');
        $this->setDisplayField('nome');
        $this->setPrimaryKey('id');

        $this->hasMany('Estagiarios', [
            'foreignKey' => 'id_professor',
        ]);
        $this->hasMany('Muralestagios', [
            'foreignKey' => 'id_professor',
        ]);
        /*
          $this->hasMany('Userestagios', [
          'foreignKey' => 'docente_id',
          ]);
         */
    }

    public function beforeFind($event, $query, $options, $primary) {

        $query->order(['nome' => 'ASC']);
        return $query;
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator {
        $validator
                ->integer('id')
                ->allowEmptyString('id', null, 'create');

        $validator
                ->scalar('nome')
                ->maxLength('nome', 50)
                ->notEmptyString('nome');

        $validator
                ->scalar('cpf')
                ->maxLength('cpf', 12)
                ->allowEmptyString('cpf');

        $validator
                ->integer('siape')
                ->allowEmptyString('siape');

        $validator
                ->date('datanascimento')
                ->allowEmptyDate('datanascimento');

        $validator
                ->scalar('localnascimento')
                ->maxLength('localnascimento', 30)
                ->allowEmptyString('localnascimento');

        $validator
                ->scalar('sexo')
                ->allowEmptyString('sexo');

        $validator
                ->scalar('ddd_telefone')
                ->maxLength('ddd_telefone', 2)
                ->notEmptyString('ddd_telefone');

        $validator
                ->scalar('telefone')
                ->maxLength('telefone', 12)
                ->allowEmptyString('telefone');

        $validator
                ->scalar('ddd_celular')
                ->maxLength('ddd_celular', 2)
                ->notEmptyString('ddd_celular');

        $validator
                ->scalar('celular')
                ->maxLength('celular', 12)
                ->allowEmptyString('celular');

        $validator
                ->email('email')
                ->allowEmptyString('email');

        $validator
                ->scalar('homepage')
                ->maxLength('homepage', 120)
                ->allowEmptyString('homepage');

        $validator
                ->scalar('redesocial')
                ->maxLength('redesocial', 50)
                ->allowEmptyString('redesocial');

        $validator
                ->scalar('curriculolattes')
                ->maxLength('curriculolattes', 50)
                ->allowEmptyString('curriculolattes');

        $validator
                ->date('atualizacaolattes')
                ->allowEmptyDate('atualizacaolattes');

        $validator
                ->scalar('curriculosigma')
                ->maxLength('curriculosigma', 7)
                ->allowEmptyString('curriculosigma');

        $validator
                ->scalar('pesquisadordgp')
                ->maxLength('pesquisadordgp', 20)
                ->allowEmptyString('pesquisadordgp');

        $validator
                ->scalar('formacaoprofissional')
                ->maxLength('formacaoprofissional', 30)
                ->allowEmptyString('formacaoprofissional');

        $validator
                ->scalar('universidadedegraduacao')
                ->maxLength('universidadedegraduacao', 50)
                ->allowEmptyString('universidadedegraduacao');

        $validator
                ->integer('anoformacao')
                ->allowEmptyString('anoformacao');

        $validator
                ->scalar('mestradoarea')
                ->maxLength('mestradoarea', 40)
                ->allowEmptyString('mestradoarea');

        $validator
                ->scalar('mestradouniversidade')
                ->maxLength('mestradouniversidade', 50)
                ->allowEmptyString('mestradouniversidade');

        $validator
                ->integer('mestradoanoconclusao')
                ->allowEmptyString('mestradoanoconclusao');

        $validator
                ->scalar('doutoradoarea')
                ->maxLength('doutoradoarea', 40)
                ->allowEmptyString('doutoradoarea');

        $validator
                ->scalar('doutoradouniversidade')
                ->maxLength('doutoradouniversidade', 50)
                ->allowEmptyString('doutoradouniversidade');

        $validator
                ->integer('doutoradoanoconclusao')
                ->allowEmptyString('doutoradoanoconclusao');

        $validator
                ->date('dataingresso')
                ->allowEmptyDate('dataingresso');

        $validator
                ->scalar('formaingresso')
                ->maxLength('formaingresso', 100)
                ->allowEmptyString('formaingresso');

        $validator
                ->scalar('tipocargo')
                ->maxLength('tipocargo', 10)
                ->allowEmptyString('tipocargo');

        $validator
                ->scalar('categoria')
                ->maxLength('categoria', 10)
                ->allowEmptyString('categoria');

        $validator
                ->scalar('regimetrabalho')
                ->maxLength('regimetrabalho', 5)
                ->allowEmptyString('regimetrabalho');

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
                ->scalar('observacoes')
                ->allowEmptyString('observacoes');

        return $validator;
    }

}
