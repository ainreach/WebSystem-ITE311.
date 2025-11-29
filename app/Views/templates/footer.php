    </div> <!-- Close container if opened in content -->
    
    <footer class="bg-light mt-5 py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <p class="mb-0">&copy; <?= date('Y') ?> ITE311-NABALE. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-end">
                    <p class="mb-0">Built with CodeIgniter 4</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Real-Time Notifications Script -->
    <?php if (session()->get('isLoggedIn')): ?>
    <script>
    $(document).ready(function() {
        // Get fresh CSRF token
        function getCsrfToken() {
            return $('meta[name="csrf-token"]').attr('content');
        }

        // Function to fetch notification count
        function fetchNotificationCount() {
            $.ajax({
                url: '<?= site_url('notifications/count') ?>',
                type: 'GET',
                dataType: 'json',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                success: function(response) {
                    if (response.count > 0) {
                        $('#notification-badge').text(response.count).show();
                    } else {
                        $('#notification-badge').hide();
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Failed to fetch notification count:', error);
                }
            });
        }

        // Function to fetch unread notifications
        function fetchNotifications() {
            $.ajax({
                url: '<?= site_url('notifications/unread') ?>',
                type: 'GET',
                dataType: 'json',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                success: function(response) {
                    if (response.notifications && response.notifications.length > 0) {
                        let html = '';
                        response.notifications.forEach(function(notification) {
                            let icon = notification.type === 'enrollment' ? 'fa-user-plus' : 'fa-file-alt';
                            let bgClass = notification.is_read == 0 ? 'bg-light' : '';
                            
                            html += '<li>';
                            html += '<a class="dropdown-item ' + bgClass + '" href="#" data-notification-id="' + notification.id + '">';
                            html += '<div class="d-flex align-items-start">';
                            html += '<i class="fas ' + icon + ' me-2 mt-1"></i>';
                            html += '<div class="flex-grow-1">';
                            html += '<p class="mb-1 small">' + notification.message + '</p>';
                            html += '<small class="text-muted">' + notification.created_at + '</small>';
                            html += '</div>';
                            html += '</div>';
                            html += '</a>';
                            html += '</li>';
                        });
                        $('#notification-list').html(html);
                    } else {
                        $('#notification-list').html('<li><span class="dropdown-item-text text-muted text-center">No new notifications</span></li>');
                    }
                },
                error: function() {
                    console.error('Failed to fetch notifications');
                }
            });
        }

        // Mark notification as read when clicked
        $(document).on('click', '#notification-list .dropdown-item', function(e) {
            e.preventDefault();
            let notificationId = $(this).data('notification-id');
            
            $.ajax({
                url: '<?= site_url('notifications/read/') ?>' + notificationId,
                type: 'POST',
                data: {
                    '<?= csrf_token() ?>': getCsrfToken()
                },
                dataType: 'json',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                success: function(response) {
                    if (response.success) {
                        // Update CSRF token if provided
                        if (response.csrf_token) {
                            $('meta[name="csrf-token"]').attr('content', response.csrf_token);
                        }
                        fetchNotificationCount();
                        fetchNotifications();
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Failed to mark notification as read:', error);
                }
            });
        });

        // Mark all notifications as read
        $('#mark-all-read').on('click', function(e) {
            e.preventDefault();
            
            $.ajax({
                url: '<?= site_url('notifications/read-all') ?>',
                type: 'POST',
                data: {
                    '<?= csrf_token() ?>': getCsrfToken()
                },
                dataType: 'json',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                success: function(response) {
                    if (response.success) {
                        // Update CSRF token if provided
                        if (response.csrf_token) {
                            $('meta[name="csrf-token"]').attr('content', response.csrf_token);
                        }
                        fetchNotificationCount();
                        fetchNotifications();
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Failed to mark all notifications as read:', error);
                }
            });
        });

        // Fetch notifications on page load
        fetchNotificationCount();
        fetchNotifications();

        // Poll for new notifications every 30 seconds
        setInterval(function() {
            fetchNotificationCount();
        }, 30000);

        // Fetch notifications when dropdown is opened
        $('#notificationDropdown').on('click', function() {
            fetchNotifications();
        });
    });
    </script>
    <?php endif; ?>
</body>
</html>
