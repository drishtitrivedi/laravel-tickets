# Ticketing System – Vue + Laravel

A full-stack ticketing system built with **Laravel** (backend) and **Vue 3** (frontend).  
This project demonstrates authentication, ticket management, and AI-powered classification.


## 🚀 Setup Instructions

 git clone https://github.com/drishtitrivedi/laravel-tickets.git
 
 cd .\laravel-tickets\
 
 composer install

 php artisan key:generate
 
 php artisan serve
 
 php artisan migrate
 
 php artisan db:seed --class=TicketSeeder

 ## API Routes

 http://localhost:8000/api/tickets [GET]

 http://localhost:8000/api/tickets/:id [GET, POST, PUT, PATCH, DELETE]

 http://localhost:8000/api/tickets/:id/classify [POST]
 

