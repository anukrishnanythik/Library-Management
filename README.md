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
https://restless-trinity-771432.postman.co/workspace/Personal-Workspace~03c33991-8b9a-442b-8637-857f96e04413/collection/27618526-c1e97c89-a26b-4a76-b440-436f0f9179aa?action=share&creator=27618526
