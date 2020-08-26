<?php
namespace App\Controllers;

use App\Exceptions\ApplicationException;
use App\Foundation\Controller;
use App\Models\User;
use Apricot\Input;

/**
 * User Controller
 */
class UserController extends Controller
{
    /**
     * @var \App\Models\User
     */
    private $user;

    /**
     * Creates a user controller.
     */
    public function __construct(User $user)
    {
        // User Model
        $this->user = $user;

        // Registers interceptors.
        $this->intercept('insert', 'UserInterceptor@insert');
        $this->intercept('update', 'UserInterceptor@update');

        // Registers transactional actions.
        $this->transactional('insert','update','delete');
    }

    /**
     * Users list page.
     *
     * @return \Apricot\Foundation\Response
     */
    public function index()
    {
        $users = $this->user->findAll();
        return render("user.index", ["users"=>$users]);
    }

    /**
     * User registration page.
     *
     * @return \Apricot\Foundation\Response
     */
    public function create()
    {
        $user = $this->user->create();
        return render("user.create", ["user"=>$user]);
    }

    /**
     * Inserts a user record.
     *
     * @return \Apricot\Foundation\Response
     */
    public function insert()
    {
        $inputs = Input::all();

        try
        {
            $user = $this->user->insert($inputs);
        }
        catch(ApplicationException $e)
        {
            throw $e;
        }
        catch(\Exception $e)
        {
            throw new ApplicationException(__('messages.error.db.insert'),$e->getMessage(),0,$e);
        }

        // Redirects to the user edit page.
        return redirect(route("user/{$user->id}/edit"))->with('msg',__('messages.success.db.insert'));
    }

    /**
     * User edit page.
     *
     * @return \Apricot\Foundation\Response
     */
    public function edit(int $id)
    {
        // Finds By the primary key
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
     * Updates a user record.
     *
     * @param int $id
     * @return \Apricot\Foundation\Response
     */
    public function update(int $id)
    {
        $inputs = Input::all();

        try
        {
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

        // Redirects to the user edit page.
        return redirect(route("user/{$id}/edit"))->with('msg',__('messages.success.db.update'));
    }

    /**
     * Deletes a user record.
     *
     * @param int $id
     * @return \Apricot\Foundation\Response
     */
    public function delete(int $id)
    {
        try
        {
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

        // Redirects to the users list page.
        return redirect(route("users"))->with('msg',__('messages.success.db.delete'));
    }
}
