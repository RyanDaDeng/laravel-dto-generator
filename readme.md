# Laravel JSON to Class Generator

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]


[link-packagist]: https://packagist.org/packages/timehunter/laraveljsontoclassgenerator
[ico-version]: https://img.shields.io/packagist/v/timehunter/laraveljsontoclassgenerator.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/timehunter/laraveljsontoclassgenerator.svg?style=flat-square
[link-downloads]: https://packagist.org/packages/timehunter/laraveljsontoclassgenerator
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


## Example

Input - PHP Array:

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

or JSON

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

Output - Classes:

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


## License

MIT. Please see the [license file](license.md) for more information.
