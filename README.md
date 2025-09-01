

## Initiate the application

 git clone https://github.com/drishtitrivedi/laravel-tickets.git
 
 cd .\laravel-tickets\
 
 composer install
 
 php artisan serve
 
 php artisan migrate
 
 php artisan db:seed --class=TicketSeeder

 ## API Routes

 http://localhost:8000/api/tickets [GET]

 http://localhost:8000/api/tickets/:id [GET, POST, PUT, PATCH, DELETE]
 

