<?php
declare(strict_types=1);

namespace App\Model\Table;

use ArrayObject;
use Cake\Event\EventInterface;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use function is_string;

/**
 * Professores Model
 *
 * @property \App\Model\Table\MonografiasTable&\Cake\ORM\Association\HasMany $Monografias
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\HasMany $Users
 */
class ProfessoresTable extends Table
{
    public const STATUS_ATIVO = 'ativo';
    public const STATUS_APOSENTADO = 'aposentado';
    public const STATUS_INATIVO = 'inativo';

    private const STATUS_NORMALIZATION_MAP = [
        'active' => self::STATUS_ATIVO,
        'activo' => self::STATUS_ATIVO,
        'retired' => self::STATUS_APOSENTADO,
        'inactive' => self::STATUS_INATIVO,
        'inactivo' => self::STATUS_INATIVO,
    ];

    /**
     * Initialize method
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('professores');
        $this->setDisplayField('nome');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'created' => 'new',
                    'modified' => 'always',
                ],
            ],
        ]);

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
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('nome')
            ->maxLength('nome', 200)
            ->requirePresence('nome', 'create')
            ->notEmptyString('nome');

        $validator
            ->scalar('cpf')
            ->maxLength('cpf', 15)
            ->allowEmptyString('cpf');

        $validator
            ->scalar('siape')
            ->maxLength('siape', 8)
            ->regex('siape', '/^[0-9]{7,8}$/', 'O Siape deve conter apenas números e ter entre 7 e 8 dígitos.')
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
            ->scalar('codigo_telefone')
            ->maxLength('codigo_telefone', 2)
            ->allowEmptyString('codigo_telefone');

        $validator
            ->scalar('telefone')
            ->maxLength('telefone', 15)
            ->allowEmptyString('telefone');

        $validator
            ->scalar('codigo_celular')
            ->maxLength('codigo_celular', 2)
            ->allowEmptyString('codigo_celular');

        $validator
            ->scalar('celular')
            ->maxLength('celular', 15)
            ->allowEmptyString('celular');

        $validator
            ->scalar('departamento')
            ->maxLength('departamento', 30)
            ->allowEmptyString('departamento');

        $validator
            ->scalar('email')
            ->email('email', false)
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
            ->scalar('tipocargo')
            ->maxLength('tipocargo', 20)
            ->allowEmptyString('tipocargo');

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

        $validator
            ->scalar('status')
            ->maxLength('status', 10)
            ->inList('status', [
                self::STATUS_ATIVO,
                self::STATUS_APOSENTADO,
                self::STATUS_INATIVO,
            ], 'Status deve ser um de: ativo, aposentado, inativo.')
            ->allowEmptyString('status');

        $validator
            ->integer('user_id')
            ->allowEmptyString('user_id');

        $validator
            ->integer('estagiarios_count')
            ->allowEmptyString('estagiarios_count');

        return $validator;
    }

    /**
     * Application rules: block deletion of a professor that still has monografias.
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->addDelete(
            fn($entity, $operation) => !$this->Monografias->exists([
                'OR' => [
                    'professor_id' => $entity->id,
                    'num_co_orienta' => $entity->id,
                    'banca1' => $entity->id,
                    'banca2' => $entity->id,
                    'banca3' => $entity->id,
                ],
            ]),
            'hasMonografias',
            ['errorField' => 'id', 'message' => 'O professor possui monografias vinculadas e não pode ser excluído.'],
        );

        return $rules;
    }

    /**
     * Normalizes status aliases ("active" -> "ativo"...) before validation.
     * An empty status is dropped so the current value (or default "ativo") is kept.
     */
    public function beforeMarshal(EventInterface $_event, ArrayObject $data, ArrayObject $_options): void
    {
        unset($_event, $_options);

        $status = $data['status'] ?? null;
        if ($status === '') {
            unset($data['status']);

            return;
        }
        if (!is_string($status)) {
            return;
        }

        $data['status'] = self::STATUS_NORMALIZATION_MAP[$status] ?? $status;
    }
}
