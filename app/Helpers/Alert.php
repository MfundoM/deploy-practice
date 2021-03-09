<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Session;

class Alert
{
    /** @var string UpdateSuccess */
    private const UpdateSuccess = 'updated successfully!';

    /** @var string UpdateFailed */
    private const UpdateFailed = 'update failed, please try again!';

    /** @var string StoreSuccess */
    private const StoreSuccess = 'stored successfully!';

    /** @var string StoreFailed */
    private const StoreFailed = 'storing failed, please try again!';

    /** @var string DestroySuccess */
    private const DestroySuccess = 'deleted successfully!';

    /** @var string DestroyFailed */
    private const DestroyFailed = 'delete failed, please try again!';

    /** @var string RemoveSuccess */
    private const RemoveSuccess = 'removed successfully!';

    /** @var string RemoveFailed */
    private const RemoveFailed = 'remove failed, please try again!';

    /** @var string TrashSuccess */
    private const TrashSuccess = 'trashed successfully!';

    /** @var string TrashFailed */
    private const TrashFailed = 'trash failed, please try again!';

    /** @var string RestoreSuccess */
    private const RestoreSuccess = 'restored successfully!';

    /** @var string RestoreFailed */
    private const RestoreFailed = 'restore failed, please try again!';


    /** @var string SendSuccess */
    private const SendSuccess = 'sent successfully!';

    /** @var string SendFailed */
    private const SendFailed = 'send failed, please try again!';

    /** @var string ApproveSuccess */
    private const ApproveSuccess = 'approved successfully!';

    /** @var string ApproveFailed */
    private const ApproveFailed = 'approve failed, please try again!';

    /** @var string DenySuccess */
    private const DenySuccess = 'denied successfully!';

    /** @var string DenyFailed */
    private const DenyFailed = 'denying failed, please try again!';

    /**
     * Show alert according to CRUD results.
     *
     * @param bool $success
     * @param string $action
     * @param string|null $context
     * @return array
     */
    public static function crud(bool $success, string $action, string $context = null) : array
    {
        $message = static::messageForAction($action, $success);

        $body = $context ? sprintf('%s %s', ucfirst($context), $message) : ucfirst($message);
        $status = $success ? 'success' : 'error';
        $header = $success ? 'Success' : 'Failed';

        return static::custom($body, $status, $header, 1900);
    }

    /**
     * Display success message.
     *
     * @param string $body
     * @param int $timer
     * @return array
     */
    public static function success(string $body, int $timer = 1900) : array
    {
        $alert = [
            'header' => 'Success',
            'body'   => $body,
            'status' => 'success',
            'timer'  => $timer,
        ];

        Session::flash('sweetalert', $alert);

        return $alert;
    }

    /**
     * Display error message.
     *
     * @param string $body
     * @param int $timer
     * @return array
     */
    public static function error(string $body, int $timer = 3100) : array
    {
        $alert = [
            'header' => 'Failed',
            'body'   => $body,
            'status' => 'error',
            'timer'  => $timer,
        ];

        Session::flash('sweetalert', $alert);

        return $alert;
    }

    /**
     * Display warning message.
     *
     * @param string $body
     * @param int $timer
     * @return array
     */
    public static function warning(string $body, int $timer = 2500) : array
    {
        $alert = [
            'header' => 'Warning',
            'body'   => $body,
            'status' => 'warning',
            'timer'  => $timer,
        ];

        Session::flash('sweetalert', $alert);

        return $alert;
    }

    /**
     * Display custom message.
     *
     * @param string $body
     * @param string $status
     * @param string $header
     * @param int $timer
     * @return array
     */
    public static function custom(string $body, string $status = 'warning', string $header = 'Alert!', int $timer = 3000) : array
    {
        $alert = compact('header', 'body', 'status', 'timer');

        Session::flash('sweetalert', $alert);

        return $alert;
    }

    /**
     * Return a message for given action.
     *
     * @param string $action
     * @param bool $success
     * @return string
     */
    private static function messageForAction(string $action, bool $success) : string
    {
        switch ($action) {
            // default
            case 'update' :
                $message = $success ? static::UpdateSuccess : static::UpdateFailed;
                break;
            case 'store' :
            case 'save' :
                $message = $success ? static::StoreSuccess : static::StoreFailed;
                break;
            case 'destroy' :
            case 'delete' :
                $message = $success ? static::DestroySuccess : static::DestroyFailed;
                break;
            case 'remove' :
                $message = $success ? static::RemoveSuccess : static::RemoveFailed;
                break;
            case 'trash' :
                $message = $success ? static::TrashSuccess : static::TrashFailed;
                break;
            case 'restore' :
                $message = $success ? static::RestoreSuccess : static::RestoreFailed;
                break;

            // custom
            case 'send' :
                $message = $success ? static::SendSuccess : static::SendFailed;
                break;
            case 'approve' :
                $message = $success ? static::ApproveSuccess : static::ApproveFailed;
                break;
            case 'deny' :
                $message = $success ? static::DenySuccess : static::DenyFailed;
                break;
            default:
                $message = $success ? 'successful!' : 'failed!';
                break;
        }

        return $message;
    }
}
