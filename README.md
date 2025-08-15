Student Leave Management System

A role-based web application designed to streamline the leave application and approval process within an academic environment. The system provides separate login portals for Students, Staff, and Administrators, ensuring that each role has access to only the relevant features and data.

By automating the leave request workflow, the application reduces paperwork, improves communication, and provides transparent tracking of all leave records.

🚀 Features
Student

Secure login to personal dashboard.

Submit online leave applications with necessary details.

View application status and history.

Staff

Review leave requests submitted by students.

Approve or reject requests with remarks.

Track leave trends and maintain transparency.

Admin

Manage student and staff accounts.

Oversee all leave applications and system activity.

Maintain database and role permissions.

🛠️ Tech Stack

Frontend: HTML, CSS, JavaScript

Backend: PHP

Database: MySQL (SQL)

📂 Project Structure
Student-Leave-Management-System/
│-- index.php              # Landing page
│-- login.php              # User authentication
│-- student/               # Student-specific dashboard and features
│-- staff/                 # Staff-specific dashboard and features
│-- admin/                 # Admin-specific dashboard and controls
│-- assets/                # CSS, JS, and image files
│-- config/                # Database connection and configuration
│-- sql/                   # Database schema and seed data
│-- README.md

⚙️ Installation & Setup

Clone the repository

git clone https://github.com/Guna-7/Student-Leave-Management-System.git
cd Student-Leave-Management-System


Set up the database

Create a new MySQL database.

Import the provided .sql file located in the sql/ folder.

Configure database connection

Open config/config.php and update:

$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "student_leave_db";


Run the application

Place the project folder inside your XAMPP/LAMP htdocs directory.

Start Apache and MySQL from your local server environment.

Access the application via:

http://localhost/Student-Leave-Management-System

🔐 Default Login Credentials

(Update as per your actual setup)

Admin
Username: admin
Password: admin123

Staff
Username: staff1
Password: staff123

Student
Username: student1
Password: student123

📈 Benefits

Paperless Process: Eliminates manual leave forms.

Transparency: All leave records are stored and traceable.

Efficiency: Reduces processing time for approvals.

Role-based Access Control: Secure and tailored user experience.
