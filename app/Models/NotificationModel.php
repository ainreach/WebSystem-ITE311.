<?php

namespace App\Models;

use CodeIgniter\Model;

class NotificationModel extends Model
{
    protected $table = 'notifications';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'type', 'message', 'is_read', 'created_at'];
    protected $useTimestamps = false;

    /**
     * Get unread notifications for a user
     */
    public function getUnreadNotifications($userId)
    {
        return $this->where('user_id', $userId)
                    ->where('is_read', 0)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }

    /**
     * Get unread notification count
     */
    public function getUnreadCount($userId)
    {
        return $this->where('user_id', $userId)
                    ->where('is_read', 0)
                    ->countAllResults();
    }

    /**
     * Mark notification as read
     */
    public function markAsRead($notificationId)
    {
        return $this->update($notificationId, ['is_read' => 1]);
    }

    /**
     * Mark all notifications as read for a user
     */
    public function markAllAsRead($userId)
    {
        return $this->where('user_id', $userId)
                    ->set('is_read', 1)
                    ->update();
    }

    /**
     * Create a new notification
     */
    public function createNotification($userId, $type, $message)
    {
        return $this->insert([
            'user_id' => $userId,
            'type' => $type,
            'message' => $message,
            'is_read' => 0,
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }

    /**
     * Get all notifications for a user (read and unread)
     */
    public function getUserNotifications($userId, $limit = 10)
    {
        return $this->where('user_id', $userId)
                    ->orderBy('created_at', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }
}
