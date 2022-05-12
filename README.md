# Ticketing System Laravel/Vue App

> Laravel 5.5 API that uses the API resources with a Vue.js frontend

# Pre Requesit 

> PHP 7.3.27 
> Node v14.6.0
> mysql  Ver 15.1
> Composer version 2.3.5
## Quick Start

# Setup Database
Create database with name as "ticketing_system"
Create db user and password with all previlages 
Update DB_USERNAME and DB_PASSWORD in .env 

``` bash
# Install Dependencies
composer install

# Run Migrations
php artisan migrate

# Import Events
php artisan db:seed

#The migrate:fresh command will drop all database tables regardless of their prefix. This command should be used with caution when developing on a database that is shared with other applications.
php artisan migrate:fresh --seed

# Serve 
php artisan serve

# Add virtual host if using Apache

# If you get an error about an encryption key
php artisan key:generate

# Install JS Dependencies
npm install

# Start Application
npm run dev

# Watch Files
npm run watch
```

## Endpoints

### List all events
``` bash
GET api/events/all
```

### Delete event
``` bash
DELETE api/event/{id}
```

### Add event
``` bash
POST api/event
title/description/event_start_date/event_end_date/ticket_details/lineup_details
```

### Register event
``` bash
POST api/register
name/email/mobile/ticket
```

### Sales Report
``` bash
GET event/sales
```
## App Info
Ticketing system dashboard for an online event management company
### Author

Shijith Mohanan
https://www.linkedin.com/in/shijithkm/

### Version

1.0.0

### License

This project is licensed under the MIT License

