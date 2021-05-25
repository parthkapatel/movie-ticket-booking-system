
Admin Panel (Completed)

1. Dashboard
2. Manage Cities
3. Manage Theaters
4. Manage Casts
5. Manage Movies

User Side (Pending)

1. View All Movies
2. Search By City name,Movie title,Theater Name
3. After Click on movie display all movie details with cast member and display show time is pending 
4. Click on cast member then display details of cast with all movie 

Pending Work

Display Show Time
Select Seat and
Book Tickets


After Clone this run this command to insert admin record

php artisan db:seed

username : admin@gmail.com
password : 12345

if api not work after clone then run this code in sequence 
1. php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
2. php artisan migrate
