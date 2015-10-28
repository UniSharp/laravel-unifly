## Laravel Data Carrier
[![Build Status](https://travis-ci.org/UniSharp/laravel-datacarrier.svg)](https://travis-ci.org/UniSharp/laravel-datacarrier)
[![Version](https://img.shields.io/packagist/v/unisharp/laravel-datacarrier.svg)](https://packagist.org/packages/unisharp/laravel-datacarrier)
[![License](https://img.shields.io/github/license/unisharp/laravel-datacarrier.svg)](https://packagist.org/packages/unisharp/laravel-datacarrier)
[![Total Downloads](https://img.shields.io/packagist/dt/unisharp/laravel-datacarrier.svg)](https://packagist.org/packages/unisharp/laravel-datacarrier)

### Introduction

Provide an object as Facade to put all global variables togetther, clean your code. Normally we use it to passing variables from Controller to View.

And you can extend your formating method to help you format global data

### Install Data Carrier

composer.json:

    "require" : {
        "unisharp/laravel-datacarrier" : "~1.0"
    }, 
    "repositories": {
        "type": "git",
        "url": "https://github.com/UniSharp/laravel-datacarrier.git
    }

save it and then 

    composer update    

### Set ServiceProvider and Set Facade

#### in config/app.php:

* ServiceProfider

        Unisharp\DataCarrier\DataCarrierServiceProvider::class,
        

* alias

        'DataCarrier' => Unisharp\DataCarrier\DataCarrierFacade::class,
        
        
### Usage

* get and set global data

    you can use Facade to set and get items

        \DataCarrier::set('key', 1); // ['a' => 1]
    
        \DataCarrier::get('key'); // 1
    
        // you can set a default value for get method
    
        \DataCarrier::get('key', 0); // if you cannot get it, it will return 0

        $var = d('key', 0); // Quick access by d() helper.
        
        \DataCarrier::all(); // it will get an array with all items
    
    you can also use dot to seperate array
    
        # [ 
        #    'a' => [
        #        'b' => 'value'
        #    ]
        # ]
        
        \DataCarrier::get('a.b'); // 'value'
    
* customize your format method (Add method into Data Carrier)

        \DataCarrier::extend('format', function ($data) {
            return number_format($data);
        })
    
    
* format your data

        # ['num' => '100000']
        \DataCarrier::format('num') // 100,000
        
### Helper can use helper to set, get your data 

* get, set function
    
        carrier_set('num', 1); // ['a' => 1]
        carrier_get('num'); // 1
    
* use carrier() to muniplate container

        carrier() // it's just return App::make('DataCarrier')
    

### Another way to work with DataCarier

* get, set can replace by it

         carrier('num')->get();
         carrier('num')->set(5);
     
* extend your formating method

        carrier()->extend('format', function ($data) {
            return number_format($data);
        })

* use your formatting method

        carrier('num')->format(); // it will return formating result
