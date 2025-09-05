# Ticketing System – Vue + Laravel + OpenAI

A full-stack ticketing system built with **Laravel** (backend) and **Vue 3** (frontend).  
This project demonstrates authentication, ticket management, and AI-powered classification.


## 🚀 Setup Instructions

 git clone https://github.com/drishtitrivedi/laravel-tickets.git
 
 cd .\laravel-tickets\

 cp .env.example .env
 
 composer install

 php artisan key:generate
 
 php artisan serve
 
 php artisan migrate
 
 php artisan db:seed --class=TicketSeeder

 ## API Routes

 http://localhost:8000/api/tickets [GET]

 http://localhost:8000/api/tickets/:id [GET, POST, PUT, PATCH, DELETE]

 http://localhost:8000/api/tickets/:id/classify [POST]

 ## Assumptions & Trade-offs”
 ### Assumptions

The application will be run in a Linux-like environment (tested with Ubuntu and Dockerized setup).

PHP 8.2+, Composer, Node.js (LTS), and MySQL/PostgreSQL are available.

Developers have access to an .env file with valid database credentials and API keys (e.g., OpenAI).

Database migrations and seeds can safely reset the schema in non-production environments.

Frontend build process uses Vite; Node.js version is compatible.

### Trade-offs

Simplicity over scalability: Initial setup is optimized for local development, not production-grade scaling. For production, additional steps (caching, load balancing, queue workers, monitoring) are required.

Tight coupling to Laravel: The backend is tightly coupled to Laravel features (migrations, queue, seeding) which speeds up development but reduces flexibility if switching frameworks.

Seeded data: Provides convenience for testing/demo but may not represent real-world data complexity.

OpenAI integration: Calls are synchronous in the current setup (blocking), which may slow down responses until a proper queue-based async handling is implemented.

### What I would do more
Scalability & Performance
- Move OpenAI calls and classification logic into background jobs/queues for non-blocking performance.
Security Enhancements
- Harden authentication and authorization
Testing
- Expand backend unit/feature tests for API endpoints and services.
 

