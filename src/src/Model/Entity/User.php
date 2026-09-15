<?php
namespace App\Model\Entity;

use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\Entity;

/**
 * User Entity
 *
 * @property int $id
 * @property string $email
 * @property string $password
 * @property string $name
 * @property string $tel
 * @property string $zip
 * @property string $address
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 */
class User extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * ホワイトリスト(許可リスト)
     * `id` と `role` は false のままにしておくこと。true にすると、フォームに
     * `role=admin` を混ぜて送るだけで管理者になれてしまう（mass assignment 脆弱性）。
     * 権限の変更は $user->set('role', 'admin') のように明示的に行う。
     *
     * @var array
     */
    protected $_accessible = [
        'email' => true,
        'password' => true,
        'name' => true,
        'tel' => true,
        'zip' => true,
        'address' => true,
    ];

    /**
     * Fields that are excluded from JSON / array versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password',
    ];

    /**
     * パスワードをセットする際に必ずハッシュ化する。
     *
     * `_set` + フィールド名（PascalCase）という命名により、$user->password = '...' や
     * patchEntity() 経由の代入が全てここを通るため、生パスワードが保存されることがない。
     *
     * @param string $password 平文パスワード
     * @return string|null ハッシュ化されたパスワード
     */
    protected function _setPassword($password)
    {
        if (strlen($password) === 0) {
            return null;
        }

        return (new DefaultPasswordHasher())->hash($password);
    }
}
