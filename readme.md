# Laravel JSON to Class Generator

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]


[link-packagist]: https://packagist.org/packages/timehunter/laravel-json-to-class-generator
[ico-version]: https://img.shields.io/packagist/v/timehunter/laravel-json-to-class-generator.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/timehunter/laravel-json-to-class-generator.svg?style=flat-square
[link-downloads]: https://packagist.org/packages/timehunter/laravel-json-to-class-generator

Star me if you like it. ^.^ You can use this tool with 3rd party IDE to create nice classes.

Install the package in development dependencies:

Via Composer

``` bash
composer require --dev timehunter/laravel-json-to-class-generator "~1.0"
```

## Installation

1. Create your local config file
````bash
php artisan vendor:publish --provider="TimeHunter\LaravelJsonToClassGenerator\LaravelJsonToClassGeneratorServiceProvider"
````
2. Add your JSON or array object in config
3. Run artisan command:
````bash
php artisan make:jsontoclass
```` 
4. Check your files under your specified file location 


## Example


### Input

#### PHP Array

````php
     'message' => [
            'author' => [
                'first_name' => '',
                'last_name'  => '',
            ],
            'text'   => '',
            'date'   => '2019-01-01'
        ]
````

#### or JSON

````json
{
  "message":{
      "author": {
          "first_name": "",
          "last_name": ""
      },
      "text": "",
      "date": "2019-01-01",
  }
}
````


### Output - Classes:

#### Message Class
````php
<?php

namespace App\Test;

class Message
{
	public $author;

	public $text;

	public $date;


	public function toArray(): array
	{
		return [
		   'author' => collect($this->author)->map(function (Author $data){
		        return $data->toArray();
		    })->toArray(),
		   'text' => $this->text,
		   'date' => $this->date,
		];
	}
}

````

#### Author Class
````php
<?php

namespace App\Test;

class Author
{
	public $firstName;

	public $lastName;


	public function toArray(): array
	{
		return [
		   'first_name' => $this->firstName,
		   'last_name' => $this->lastName,
		];
	}
}

````

## PHPStorm

If you are using PHPStorm and you want to put `return $this` in each set function.

Open PhpStorm's Preferences and "File and Code Templates" menu, under the "Code" tab there's an option called "PHP Setter Method". Modify it to look like this:

````php
/**
 * @param ${TYPE_HINT} $${PARAM_NAME}
 * @return ${CLASS_NAME}
 */
public ${STATIC} function set${NAME}($${PARAM_NAME})
{
#if (${STATIC} == "static")
    self::$${FIELD_NAME} = $${PARAM_NAME};
#else
    $this->${FIELD_NAME} = $${PARAM_NAME};
#end
    return $this;
}
````

## License

MIT. Please see the [license file](license.md) for more information.
