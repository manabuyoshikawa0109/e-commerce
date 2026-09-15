<?php
namespace App\Controller;

use Cake\Event\Event;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{

    /**
     * 認証なしでアクセスできるアクションを指定する。
     *
     * login は AuthComponent が loginAction として自動的に許可するため、
     * ここに書く必要はない（書いても害はない）。
     *
     * @param \Cake\Event\Event $event The beforeFilter event.
     * @return void
     */
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);

        // signup = 会員登録。未ログインの人しか使わないので公開する
        $this->Auth->allow(['signup', 'logout']);
    }

    /**
     * ログイン
     * レスポンスがNULLを返すと、src/Template/{このコントローラー名}/{このアクション名}.ctpを返す
     * このloginアクションだと、src/Template/Users/login.ctpを返す
     *
     * @return \Cake\Http\Response|null 成功時はリダイレクト、失敗時は null
     */
    public function login()
    {
        // フォームの入力欄とエラー表示に使う入れ物
        $user = $this->Users->newEntity();

        if ($this->request->is('post')) {
            $data = $this->request->getData();

            /*
             * 再入力の手間を減らすためメールアドレスだけ画面に戻す。
             * password は User::_setPassword() でハッシュ化されてしまうので入れない。
             *
             * setErrors() より必ず先に代入すること。Entity への代入は
             * EntityTrait::setDirty() 経由でその項目のエラーを消してしまうため、
             * 後に書くと email のエラーだけ表示されなくなる。
             */
            $user->email = $data['email'] ?? '';

            /*
             * AuthComponent はテーブルのバリデーションを通らない（リクエストの値で
             * 直接 SELECT するだけ）ため、未入力チェックは自分で呼ぶ必要がある。
             * 以下2つの理由により、ログインで形式・強度チェックは行わない
             * 1. パスワードポリシー変更前に登録したユーザーがログインできなくなる為
             * 2. エラー内容からポリシーを外部に推測されてしまう為
             * ※ UsersTable::validationLogin() だけ呼ばれ、UsersTable::validationDefaultは呼ばれない
             */
            $errors = $this->Users->getValidator('login')->validate($data);

            if ($errors) {
                $user->setErrors($errors);
            } else {
                // identify() が認証に成功するとユーザー情報の配列、失敗すると false を返す
                $identity = $this->Auth->identify();
                if ($identity) {
                    $this->Auth->setUser($identity);

                    // 未ログインで弾かれた直前のURLがあればそこへ、無ければ loginRedirect へ
                    return $this->redirect($this->Auth->redirectUrl());
                }

                // メールとパスワードのどちらが違うかは伝えない（アカウント存在の探索を防ぐため）
                $this->Flash->error('メールアドレスまたはパスワードが正しくありません。');
            }
        }

        $this->set(compact('user'));
    }

    /**
     * ログアウト
     *
     * @return \Cake\Http\Response|null
     */
    public function logout()
    {
        $this->Flash->success('ログアウトしました。');

        // logout() はセッションを破棄し、logoutRedirect のURLを返す
        return $this->redirect($this->Auth->logout());
    }

    /**
     * 会員登録
     *
     * @return \Cake\Http\Response|null 成功時はリダイレクト、それ以外は null
     */
    public function signup()
    {
        // UsersTableが空のUserインスタンスを生成
        $user = $this->Users->newEntity();

        if ($this->request->is('post')) {
            // UsersTable::validationDefault()が走り、通った項目だけ空のUserに代入(DBを参照しないバリデーション)
            // パスワードがここでセットされるのでそのタイミングでUser::_setPassword()が発火してハッシュ化
            // 'signup' → UsersTable::validationSignup() が使われる
            $user = $this->Users->patchEntity($user, $this->request->getData(), [
                'validate' => 'signup',
            ]);

            // UsersTable::buildRules()が走る(DBを参照するバリデーション)
            if ($this->Users->save($user)) {
                $this->Auth->setUser($user);

                // loginRedirect へ
                return $this->redirect($this->Auth->redirectUrl());
            }

            $this->Flash->error('登録できませんでした。入力内容をご確認ください。');
        }

        // 直近に画面で入力した値をセットしたUser、もしくは空のUserをsignup.ctpに渡し、値を保持する
        $this->set(compact('user'));
    }
}
