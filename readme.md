# Laravel JSON to Class Generator


## Installation

Install the package in development dependencies:

Via Composer

``` bash
$ composer require-dev timehunter/laraveljsontoclassgenerator
```

## Usage

1. Create your local config file
````bash
php artisan vendor:publish --provider="TimeHunter\LaravelJsonToClassGenerator\LaravelJsonToClassGeneratorServiceProvider"
````
2. Add your JSON array in config
3. Run artisan command:
````bash
$ php artisan make:jsontoclass
```` 
4. Check your files under your specified file location 

## Change log

Please see the [changelog](changelog.md) for more information on what has changed recently.


## Contributing

Please see [contributing.md](contributing.md) for details and a todolist.

## Security

If you discover any security related issues, please email ryandadeng@gmail.com instead of using the issue tracker.



## License

MIT. Please see the [license file](license.md) for more information.
