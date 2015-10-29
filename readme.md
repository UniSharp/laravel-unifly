## Laravel Data Carrier

### Introduction

It contain artisan make:entity command , it will make unisharp work on the fly

### Install Data Carrier

composer.json:

    "require" : {
        "unisharp/laravel-unifly" : "dev-master"
    }, 
    "repositories": {
        "type": "git",
        "url": "git@bitbucket.org:unisharp/laravel-unifly.git"
    }

save it and then 

    composer update unisharp/laravel-unifly   

### Set ServiceProvider and Set Facade

#### in config/app.php:

* ServiceProfider

        Unisharp\Unifly\UniflyServiceProvider::class,
        
        
        
### Usage

* main command

        php artisan make:entity XXX
        
    it will generate XXX entity and other views, repository to work with this entity
    
* with translatable

        php artisan make:entity XXX --translatable