# ITE311-NABALE Role-Based Access Control Testing Instructions

## Overview
This CodeIgniter 4 application implements a role-based access control system with three user roles: Admin, Teacher, and Student.

## Test Accounts
Use these pre-created accounts to test different role functionalities:

### Admin Account
- **Email:** admin@ite311.com
- **Password:** Admin123!
- **Access:** Full system administration, user management, course oversight

### Teacher Account
- **Email:** teacher@ite311.com
- **Password:** Teacher123!
- **Access:** Course management, student oversight, lesson creation

### Student Account
- **Email:** student@ite311.com
- **Password:** Student123!
- **Access:** Course enrollment, assignment submission, grade viewing

## Testing Checklist

### 1. Authentication Testing
- [ ] Register a new student account
- [ ] Login with each test account
- [ ] Verify logout functionality
- [ ] Test password strength requirements
- [ ] Test rate limiting (5 failed attempts)

### 2. Role-Based Dashboard Testing
- [ ] **Admin Dashboard:** Should show user statistics, course management, recent users
- [ ] **Teacher Dashboard:** Should show course statistics, student count, course list
- [ ] **Student Dashboard:** Should show enrolled courses, completed lessons, progress

### 3. Navigation Testing
- [ ] **Admin Navigation:** Manage Users, Manage Courses, Reports
- [ ] **Teacher Navigation:** My Courses, My Students, Lessons
- [ ] **Student Navigation:** My Courses, Assignments, Grades

### 4. Security Testing
- [ ] Try accessing dashboard without login (should redirect to login)
- [ ] Test session timeout (2 hours)
- [ ] Verify CSRF protection
- [ ] Test SQL injection prevention
- [ ] Verify password hashing (Argon2ID)

### 5. User Interface Testing
- [ ] Responsive design on different screen sizes
- [ ] Role badges display correctly
- [ ] Flash messages appear and dismiss
- [ ] Navigation highlights active page

## Expected Screenshots

### Screenshot 1: Users Table
Check your database to verify users with different roles exist.

### Screenshot 2: Admin Dashboard
- System statistics (Total Users, Courses, Enrollments)
- Recent users table
- Admin-specific navigation menu
- Crown icon indicating admin role

### Screenshot 3: Teacher Dashboard
- Course and student statistics
- List of teacher's courses
- Teacher-specific navigation menu
- Chalkboard icon indicating teacher role

### Screenshot 4: Student Dashboard
- Enrolled courses and completed lessons count
- List of enrolled courses
- Student-specific navigation menu
- Graduate cap icon indicating student role

### Screenshot 5: Navigation Comparison
- Compare navigation menus between admin and student accounts
- Role badge in user dropdown menu

### Screenshot 6: GitHub Repository
- Show latest commits including "ROLE BASE Implementation"
- Demonstrate version control progress

## Security Features Implemented

1. **Password Security:**
   - Minimum 8 characters
   - Must contain uppercase, lowercase, number, and special character
   - Argon2ID hashing with strong parameters

2. **Session Security:**
   - Session regeneration on login
   - 2-hour session timeout
   - Secure logout with session destruction

3. **Input Validation:**
   - CSRF protection
   - SQL injection prevention
   - XSS protection with input sanitization
   - Rate limiting on login attempts

4. **Access Control:**
   - Role-based navigation
   - Session-based authentication
   - Redirect protection for unauthorized access

## Troubleshooting

If you encounter issues:

1. **Database Connection:** Ensure your database is running and configured in `app/Config/Database.php`
2. **Migrations:** Run `php spark migrate` if tables are missing
3. **Sample Data:** Run `php spark db:seed UserSeeder` to create test users
4. **Permissions:** Check file permissions if you get access errors
5. **Server:** Use `php spark serve` to start the development server

## Next Steps

After testing, you can:
1. Commit changes with descriptive messages
2. Push to GitHub repository
3. Add more role-specific features
4. Implement additional security measures
5. Create more detailed user management features
