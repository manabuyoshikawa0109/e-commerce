<?php
namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @method \App\Model\Entity\User get($primaryKey, $options = [])
 * @method \App\Model\Entity\User newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\User|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class UsersTable extends Table
{

    /**
     * Initialize method.
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('users');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        // created / modified を自動で埋める
        $this->addBehavior('Timestamp');
    }

    /**
     * 全用途で共通する「形式・長さ」のルール。
     *
     * 必須かどうかは用途ごとに変わるため、ここでは requirePresence を指定しない。
     * 各 validationXxx() から呼び出してベースとして使う。
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->email('email', false, 'メールアドレスの形式が正しくありません。')
            ->maxLength('email', 255);

        $validator
            ->scalar('password')
            // bcrypt は 72 バイトを超える分を無視するため、上限をそこに揃える
            ->lengthBetween('password', [8, 72], 'パスワードは8文字以上72文字以内で入力してください。')
            // \A と \z を使う。^ と $ は末尾の改行を許してしまうため
            ->regex(
                'password',
                '/\A(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9]).+\z/',
                'パスワードはアルファベット大文字・小文字・数字をそれぞれ1文字以上含めてください。'
            );

        $validator
            ->scalar('name')
            ->maxLength('name', 100);

        /*
         * 固定電話（0 + 9桁）と携帯・IP電話（0 + 10桁）の両方を許可する。
         * 桁数も正規表現で担保されるため maxLength は重ねない
         * （重ねると1つの入力に対してエラーが2件表示されてしまう）。
         */
        $validator
            ->scalar('tel')
            ->regex(
                'tel',
                '/\A0\d{9,10}\z/',
                '電話番号はハイフンなしの半角数字10〜11桁で入力してください。'
            )
            ->allowEmptyString('tel');

        // 郵便番号と住所は「両方入力」か「両方未入力」のどちらかであること
        $validator
            ->scalar('zip')
            ->regex(
                'zip',
                '/\A\d{7}\z/',
                '郵便番号はハイフンなしの半角数字7桁で入力してください。'
            )
            ->allowEmptyString('zip', '住所を入力する場合は郵便番号も入力してください。', function ($context) {
                return empty($context['data']['address']);
            });

        $validator
            ->scalar('address')
            ->maxLength('address', 255)
            ->allowEmptyString('address', '郵便番号を入力する場合は住所も入力してください。', function ($context) {
                return empty($context['data']['zip']);
            });

        return $validator;
    }

    /**
     * 会員登録用のバリデーション。
     *
     * 共通ルールに加えて、登録時に必須となる項目を指定する。
     * UsersController::signup() から ['validate' => 'signup'] で呼ばれる。
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationSignup(Validator $validator)
    {
        $validator = $this->validationDefault($validator);

        $validator
            ->requirePresence('name')
            ->notEmptyString('name', '氏名を入力してください。');

        $validator
            ->requirePresence('email')
            ->notEmptyString('email', 'メールアドレスを入力してください。');

        $validator
            ->requirePresence('password')
            ->notEmptyString('password', 'パスワードを入力してください。');

        return $validator;
    }

    /**
     * ログイン用のバリデーション。
     *
     * validationDefault は呼ばない。形式・強度チェックをログインに適用すると
     *   - ポリシー変更前に登録したユーザーがログインできなくなる
     *   - エラー内容からパスワードポリシーを外部に推測される
     * という問題が起きるため、「入力されているか」だけを見る。
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationLogin(Validator $validator)
    {
        $validator
            ->requirePresence('email')
            ->notEmptyString('email', 'メールアドレスを入力してください。');

        $validator
            ->requirePresence('password')
            ->notEmptyString('password', 'パスワードを入力してください。');

        return $validator;
    }

    /**
     * Returns a rules checker object for domain rules.
     *
     * validationDefault はリクエスト単体の検証、buildRules は DB を参照する検証。
     * メールアドレスの重複は他レコードを見る必要があるためこちらで行う。
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add(
            $rules->isUnique(['email'], 'このメールアドレスは既に登録されています。')
        );

        return $rules;
    }
}
