<?php
namespace App\Foundation;

use App\Exceptions\ApplicationException;
use Core\Foundation\BaseController;
use Core\Foundation\ErrorBag;
use ORM;

/**
 * コントローラ
 */
class Controller extends BaseController
{
    /**
     * Transactional Actions
     * @var array
     */
    protected $transactionalActions = [];

    /**
     * Register transactional action on the controller.
     * @param  array|string $actionName
     */
    protected function transactional($actionName)
    {
        $actions = is_array($actionName) ? $actionName : func_get_args();
        $this->transactionalActions = array_merge($this->transactionalActions , $actions);
    }

    /**
     * {@inheritDoc}
     * @see \Core\Foundation\BaseController::callAction()
     */
    protected function callAction($actionName, $params)
    {
        if (!in_array($actionName, $this->transactionalActions))
        {
            // Non transactional action
            return parent::callAction($actionName, $params);
        }

        // Transactional action
        if (!ORM::getDb()->beginTransaction())
        {
            // Redirect
            $errorBag = new ErrorBag(__('messages.error.db.access'));
            return redirect(back())->withInputs()->withErrors($errorBag);
        }

        try
        {
            $response = parent::callAction($actionName, $params);
            ORM::getDb()->commit();
            return $response;
        }
        catch(ApplicationException $e)
        {
            ORM::getDb()->rollBack();
            \Core\Log::exception('error',$e);
            \Core\Debug::error($e);

            // Redirect
            $errorBag = new ErrorBag($e->getUserMessage());
            return redirect(back())->withInputs()->withErrors($errorBag);
        }
    }
}