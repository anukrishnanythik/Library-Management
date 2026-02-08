Library-Management
 A modern, high-performance RESTful API built with Laravel 12 to manage library operations. This system handles book inventory, member reservations, automated fine calculations, and librarian administrative workflows.

Tech Stack

- Laravel 12
- MySQL
- Laravel Sanctum
  
# Features
- Authentication: Secure login using Laravel Sanctum with rate limiting.

- Role-Based Access: 
Librarians: Manage books and process returns.
Members: Browse and reserve books.

- Fine System: 
0-7 days overdue: ₹0
8-14 days overdue: ₹10/day
15+ days overdue: ₹20/day

- Concurrency Control: Database transactions and pessimistic locking to prevent race conditions during returns.

- Notifications: Email alerts for book returns.

# Installation & Setup
- Clone the repository
- composer install
- update env from env.example
- php artisan key:generate
- php artisan migrate --seed
- php artisan queue:work
- php artisan schedule:work

# Quick Test Credentials
Once seeded, you can use credentials in .env to test

Api postman collection
https://app.getpostman.com/join-team?invite_code=fd3be2db975173dd8a86d307474844b0c191e246eff4b1a00c4f41fbad81220f&target_code=d3622cfa24e5d4a494f40f9376f339cb
