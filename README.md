# Ticketing System Laravel/Vue App

> Laravel 5.5 API that uses the API resources with a Vue.js frontend

## Quick Start

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

# Watch Files
npm run watch
```

## Endpoints

### List all events with links and meta
``` bash
GET api/events
```
### Get single event
``` bash
GET api/event/{id}
```

### Delete event
``` bash
DELETE api/event/{id}
```

### Add event
``` bash
POST api/event
title/body
```

### Update event
``` bash
PUT api/event
event_id/title/body
```


```

## App Info

### Author

Shijith Mohanan
https://www.linkedin.com/in/shijithkm/

### Version

1.0.0

### License

This project is licensed under the MIT License

