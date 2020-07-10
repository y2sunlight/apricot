<?php
namespace App\Controllers;

use App\Exceptions\ApplicationException;
use App\Foundation\Controller;
use App\Models\User;
use Core\Input;

/**
 * ユーザコントローラ
 */
class UserController extends Controller
{
    /**
     * User
     * @var \App\Models\User
     */
    private $user;

    /**
     * ユーザコントローラの生成
     */
    public function __construct(User $user)
    {
        // モデル
        $this->user = $user;

        // インターセプター登録
        $this->intercept('insert', 'UserInterceptor@insert');
        $this->intercept('update', 'UserInterceptor@update');

        // トランザクションアクション登録
        $this->transactional('insert','update','delete');
    }

    /**
     * ユーザ一覧
     * @return \Core\Foundation\Response
     */
    public function index()
    {
        // 全件検索
        $users = $this->user->findAll();
        return render("user.index", ["users"=>$users]);
    }

    /**
     * ユーザ新規登録
     * @return \Core\Foundation\Response
     */
    public function create()
    {
        // 新規作成
        $user = $this->user->create();
        return render("user.create", ["user"=>$user]);
    }

    /**
     * ユーザレコード挿入
     * @return \Core\Foundation\Response
     */
    public function insert()
    {
        $inputs = Input::all();

        try
        {
            // ユーザレコード挿入
            $user = $this->user->insert($inputs);
        }
        catch(\Exception $e)
        {
            throw new ApplicationException(__('messages.error.db.insert'),$e->getMessage(),0,$e);
        }

        // ユーザ一編集画面にリダイレクト
        return redirect(route("user/{$user->id}/edit"))->with('msg',__('messages.success.db.insert'));
    }

    /**
     * ユーザ編集
     * @return \Core\Foundation\Response
     */
    public function edit(int $id)
    {
        // 主キー検索
        $user = $this->user->findOne($id);
        if ($user!==false)
        {
            return render("user.edit", ["user"=>$user]);
        }
        else
        {
            return redirect(route("users"))->withOldErrors();
        }
    }

    /**
     * ユーザレコード更新
     * @param int $id
     * @return \Core\Foundation\Response
     */
    public function update(int $id)
    {
        $inputs = Input::all();

        try
        {
            // レコード更新
            $this->user->update($id, $inputs);
        }
        catch(ApplicationException $e)
        {
            throw $e;
        }
        catch(\Exception $e)
        {
            throw new ApplicationException(__('messages.error.db.update'),$e->getMessage(),0,$e);
        }

        // ユーザ一編集画面にリダイレクト
        return redirect(route("user/{$id}/edit"))->with('msg',__('messages.success.db.update'));
    }

    /**
     * ユーザレコード削除
     * @param int $id
     * @return \Core\Foundation\Response
     */
    public function delete(int $id)
    {
        try
        {
            // レコード削除
            $this->user->delete($id);
        }
        catch(ApplicationException $e)
        {
            throw $e;
        }
        catch(\Exception $e)
        {
            throw new ApplicationException(__('messages.error.db.delete'),$e->getMessage(),0,$e);
        }

        // ユーザ一覧画面にリダイレクト
        return redirect(route("users"))->with('msg',__('messages.success.db.delete'));
    }
}
