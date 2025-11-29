<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\NotificationModel;

class Notification extends BaseController
{
    protected $notificationModel;

    public function __construct()
    {
        $this->notificationModel = new NotificationModel();
    }

    /**
     * Get unread notification count (AJAX)
     */
    public function getUnreadCount()
    {
        if (!session()->get('isLoggedIn')) {
            return $this->response->setJSON(['count' => 0]);
        }

        $userId = session()->get('user_id') ?: session()->get('userID');
        $count = $this->notificationModel->getUnreadCount($userId);

        return $this->response->setJSON(['count' => $count]);
    }

    /**
     * Get unread notifications list (AJAX)
     */
    public function getUnreadNotifications()
    {
        if (!session()->get('isLoggedIn')) {
            return $this->response->setJSON(['notifications' => []]);
        }

        $userId = session()->get('user_id') ?: session()->get('userID');
        $notifications = $this->notificationModel->getUnreadNotifications($userId);

        return $this->response->setJSON(['notifications' => $notifications]);
    }

    /**
     * Mark notification as read (AJAX)
     */
    public function markAsRead($notificationId)
    {
        if (!session()->get('isLoggedIn')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized']);
        }

        $success = $this->notificationModel->markAsRead($notificationId);

        return $this->response->setJSON([
            'success' => $success,
            'message' => $success ? 'Notification marked as read' : 'Failed to update',
            'csrf_token' => csrf_hash()
        ]);
    }

    /**
     * Mark all notifications as read (AJAX)
     */
    public function markAllAsRead()
    {
        if (!session()->get('isLoggedIn')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized']);
        }

        $userId = session()->get('user_id') ?: session()->get('userID');
        $success = $this->notificationModel->markAllAsRead($userId);

        return $this->response->setJSON([
            'success' => $success,
            'message' => $success ? 'All notifications marked as read' : 'Failed to update',
            'csrf_token' => csrf_hash()
        ]);
    }
}
