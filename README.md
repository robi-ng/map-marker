# Map Marker

Map Marker is a Laravel-based webapp which maps and displays the location of an incoming request in real-time. It's using Google Maps for the map library and has dropdown option to display coordinates in the last X hours (pre-defined). It requires the user to allow location permission on the browser.

# Steps to run

### 1. Clone the repository
```
git clone https://github.com/robi-ng/map-marker.git
```
### 2. Ensure that you have PHP and MySQL installed locally
Tested on `PHP 7.1.23` and `MySQL 5.7.25`.
### 3. Copy .env.example into .env file 
```
cd map-marker 
cp .env.example .env
```
### 4. Generate app key
```
php artisan key:generate
```
### 5. Fill in your local database details in .env file
```
DB_CONNECTION=mysql
DB_HOST=
DB_PORT=
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
DB_SOCKET=
```
### 6. Migrate database to create the defined table
```
php artisan migrate
```
### 7. Fill in Google Map API key in .env file
```
GOOGLE_MAP_API_KEY=
```
### 9. Run Laravel app
```
php artisan serve
```
### 10. Load the app on browser
Open http://localhost:8000 on browser and the app should load.