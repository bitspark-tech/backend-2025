Student Management System with Feedback - PHP + MySQL

1. Project Overview

This project is a simple student management system developed using PHP, MySQL, and HTML (no frameworks). 
It includes role-based access control (admin/student), authentication, feedback handling, course and student management, and enrollment functionality.

2. User Roles & Access Control

- Admins: Can manage students, courses, view/handle feedbacks, and manage enrollments.
- Students: Can enroll in courses, submit feedback, view responses, and complete their profile.
- Role-based access is enforced using session checks and redirects.

3. Database Design Overview

Key Tables & Relationships:
- users (userID, firstName, lastName, email, password, role)
- students (stID, userID → users.userID [ON DELETE CASCADE], matriculeNo, dob, pob, phone, address)
- courses (courseID, name, description)
- enrollments (enrollID, stID → students.stID [ON DELETE CASCADE], courseID → courses.courseID [ON DELETE CASCADE])
- feedbacks (fid, stID → students.stID, courseID → courses.courseID, message, rating, feedbackDate)
- responses (rid, fid → feedbacks.fid [ON DELETE CASCADE], message, restDate)

4. Authentication Logic

Login and registration handle sessions and redirect based on role. Guard files ensure only appropriate roles access each section:
- includes/auth_admin.php
- includes/auth_student.php

5. Key Features Implemented

- Student registration and login
- Profile completion (dob, pob, phone, address)
- Course management (Admin)
- Student management (Admin)
- Feedback submission (Student) & Response (Admin)
- Role-based dashboards
- ON DELETE CASCADE relationships for clean deletions

6. Project File Structure

/auth
    login.php
    register.php
    logout.php

/admin
    dashboard.php
    manage_courses.php
    manage_students.php
    enrollments.php
    view_feedbacks.php
    respond_feedback.php

/student
    dashboard.php
    complete_profile.php
    enroll.php
    submit_feedback.php
    view_feedbacks.php

/includes
    db.php
    session.php
    auth_admin.php
    auth_student.php
