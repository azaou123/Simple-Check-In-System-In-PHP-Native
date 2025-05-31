# 🎟 Event Attendance Check-In System  

A web-based platform for tracking event attendance, managing participants, and generating certificates automatically.  

---

## ✨ Features  
- ✅ **User Authentication** (Login/Logout)  
- 📊 **Admin Dashboard** for attendance tracking  
- 🏷 **Certificate Generation** for verified attendees  
- 📱 **Mobile-Friendly** interface  
- 📂 **Modular PHP Structure** for easy maintenance  

---

## 📂 Folder Structure  
EVENT_ATTENDANCE/
├── assets/ # Static files (fonts, icons)
├── css/ # Stylesheets (Bootstrap/Custom)
├── images/ # Event/logo images
├── js/ # JavaScript scripts
├── includes/ # Core PHP components
│ ├── auth.php # User authentication
│ ├── config.php # Database configuration
│ ├── functions.php # Helper functions
│ └── navbar.php # Shared navigation
├── php-certificate-generator/ # PDF certificate logic
├── src/ # Additional source code
├── vendor/ # Composer packages
│
├── admin.php # Admin control panel
├── dashboard.php # User attendance dashboard
├── generate.php # Certificate generator
├── index.php # Public landing/check-in page
├── login.php # Login portal
├── verify.php # Attendance verification
├── db_setup.sql # Database schema
└── composer.json # PHP dependencies


---

## 🚀 Quick Setup  

### Requirements  
- PHP ≥ 7.4  
- MySQL ≥ 5.7  
- Apache/Nginx  
- Composer  

### Installation  
```bash
# 1. Clone repository
git clone https://github.com/your-repo/event-attendance.git

# 2. Install dependencies
composer install

# 3. Create database & import schema
mysql -u root -p -e "CREATE DATABASE event_db"
mysql -u root -p event_db < db_setup.sql

# 4. Configure database (edit includes/config.php)
$DB_HOST = 'localhost';
$DB_USER = 'root';
$DB_PASS = 'your_password';
$DB_NAME = 'event_db';
🖥 Usage
For Attendees:

Access index.php to check-in

Use verify.php to confirm attendance

For Admins:

Log in via login.php

Manage attendees in admin.php

Generate certificates via generate.php

Certificate Customization:
Edit templates in php-certificate-generator/

🛠 Troubleshooting
Error Logs: Check error.log for runtime issues

Permissions: Ensure vendor/ and certificate output dirs are writable

Blank Pages: Verify PHP error reporting is enabled

📜 License
MIT License | © 2024 [Your Name]

🌟 Preview
(Optional: Add screenshots here)
![Admin Dashboard](/images/screenshot1.png)

🔧 Need customization? Edit these key files:

includes/config.php → Database settings

css/styles.css → UI styling

php-certificate-generator/ → Certificate templates


### How to Use This README:
1. Copy this entire text
2. Create a new file named `README.md` in your project root
3. Paste the content
4. Update sections marked with `[your-repo-url]` or `[Your Name]` with your actual details
5. Add screenshots by placing images in `/images` and updating the preview section

Would you like me to add specific instructions for any feature (e.g., certificate generation flow)?