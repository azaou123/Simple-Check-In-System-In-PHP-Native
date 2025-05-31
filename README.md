# Event Attendance Management System

A comprehensive web-based event attendance tracking system with certificate generation capabilities. This system allows organizers to manage events, track attendee check-ins, and automatically generate certificates for participants.

## 🚀 Features

- **Event Management**: Create and manage multiple events
- **Attendee Registration**: Register participants for events
- **Real-time Check-in**: Track attendee arrivals and departures
- **Certificate Generation**: Automatically generate PDF certificates for attendees
- **Dashboard Analytics**: View attendance statistics and reports
- **User Authentication**: Secure login system for administrators
- **Responsive Design**: Mobile-friendly interface

## 📋 Requirements

- **PHP**: 7.4 or higher
- **MySQL**: 5.7 or higher
- **Apache/Nginx**: Web server
- **Composer**: For dependency management
- **Extensions**:
  - PDO MySQL
  - GD Library (for certificate generation)
  - OpenSSL
  - Mbstring

## 🛠️ Installation

### 1. Clone the Repository
```bash
git clone <repository-url>
cd event-attendance
```

### 2. Install Dependencies
```bash
composer install
```

### 3. Database Setup
```bash
# Import the database schema
mysql -u your_username -p your_database < db_setup.sql
```

### 4. Configuration
1. Copy the configuration template:
   ```bash
   cp includes/config.php.example includes/config.php
   ```

2. Edit `includes/config.php` with your database credentials:
   ```php
   <?php
   define('DB_HOST', 'localhost');
   define('DB_USER', 'your_username');
   define('DB_PASS', 'your_password');
   define('DB_NAME', 'your_database');
   ?>
   ```

### 5. Web Server Configuration
Ensure your web server points to the project root directory and has proper permissions for file uploads and certificate generation.

## 📁 Project Structure

```
EVENT_ATTENDANCE/
├── assets/
│   ├── css/           # Stylesheets
│   ├── images/        # Images and logos
│   └── js/            # JavaScript files
├── includes/
│   ├── auth.php       # Authentication functions
│   ├── config.php     # Database configuration
│   ├── functions.php  # Core functions
│   └── navbar.php     # Navigation component
├── php-certificate-generator/
│   ├── src/           # Certificate generation source
│   └── vendor/        # Certificate dependencies
├── admin.php          # Admin dashboard
├── dashboard.php      # Main dashboard
├── db_setup.sql       # Database schema
├── index.php          # Main entry point
├── login.php          # Login page
├── logout.php         # Logout handler
└── verify.php         # Certificate verification
```

## 🎯 Usage

### Admin Functions
1. **Login**: Access the admin panel via `login.php`
2. **Create Events**: Set up new events with details and capacity
3. **Manage Attendees**: View and manage registered participants
4. **Generate Reports**: Export attendance data and statistics

### Check-in Process
1. **Registration**: Attendees register for events
2. **Check-in**: Mark attendance using the check-in interface
3. **Certificate Generation**: Automatic certificate creation upon completion
4. **Verification**: Verify certificates using unique codes

### Certificate Features
- Customizable certificate templates
- Automatic participant name insertion
- Unique verification codes
- PDF download capability
- Anti-fraud security measures

## 🔧 Configuration Options

### Database Settings
Edit `includes/config.php`:
- Database connection parameters
- Session configuration
- Security settings

### Certificate Settings
Configure certificate generation in `php-certificate-generator/src/`:
- Template customization
- Font selections
- Logo placement
- Verification system

## 📊 API Endpoints

The system provides several endpoints for data interaction:

- `GET /api/events` - List all events
- `POST /api/checkin` - Record attendee check-in
- `GET /api/attendance/{event_id}` - Get event attendance
- `POST /api/certificate/generate` - Generate certificate
- `GET /api/certificate/verify/{code}` - Verify certificate

## 🛡️ Security Features

- SQL Injection protection via prepared statements
- XSS prevention through input sanitization
- CSRF token validation
- Secure session management
- Certificate verification system
- Access control and authentication

## 🎨 Customization

### Styling
- Modify CSS files in `assets/css/`
- Customize the responsive layout
- Brand colors and logos

### Certificate Templates
- Edit templates in `php-certificate-generator/`
- Customize fonts, layouts, and graphics
- Add organization branding

## 📝 Database Schema

Key tables:
- `events` - Event information
- `attendees` - Participant data
- `attendance` - Check-in records
- `certificates` - Generated certificates
- `users` - Admin accounts

## 🔍 Troubleshooting

### Common Issues

**Database Connection Error**
- Verify database credentials in `config.php`
- Ensure MySQL service is running
- Check database permissions

**Certificate Generation Fails**
- Verify GD library is installed
- Check file permissions for certificate directory
- Ensure sufficient disk space

**Login Issues**
- Clear browser cache and cookies
- Verify user credentials in database
- Check session configuration

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/new-feature`)
3. Commit changes (`git commit -am 'Add new feature'`)
4. Push to branch (`git push origin feature/new-feature`)
5. Create a Pull Request

## 📄 License

This project is licensed under the MIT License - see the LICENSE file for details.

## 📞 Support

For support and questions:
- Create an issue in the repository
- Check the documentation
- Contact the development team

## 🔄 Updates

### Version History
- **v1.0.0** - Initial release with basic attendance tracking
- **v1.1.0** - Added certificate generation
- **v1.2.0** - Enhanced dashboard and reporting features

---

**Note**: Make sure to configure your environment properly and test all features before deploying to production.