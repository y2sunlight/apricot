<?php
namespace App\Foundation;

use App\Exceptions\ApplicationException;
use Apricot\Foundation\BaseController;
use Apricot\Foundation\ErrorBag;
use ORM;

/**
 * Controller class
 */
class Controller extends BaseController
{
    /**
     * @var array Transactional actions
     */
    protected $transactionalActions = [];

    /**
     * Registers transactional actions on the controller.
     *
     * @param  array|string $actionName
     */
    protected function transactional($actionName)
    {
        $actions = is_array($actionName) ? $actionName : func_get_args();
        $this->transactionalActions = array_merge($this->transactionalActions , $actions);
    }

    /**
     * {@inheritDoc}
     * @see \Apricot\Foundation\BaseController::callAction()
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
            \Apricot\Log::exception('error',$e);
            \Apricot\Debug::error($e);

            // Redirect
            $errorBag = new ErrorBag($e->getUserMessage());
            return redirect(back())->withInputs()->withErrors($errorBag);
        }
    }
}