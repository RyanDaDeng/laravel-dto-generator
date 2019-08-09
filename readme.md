# Laravel JSON/ARRAY to Class Generator

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
2. Add your array schema in config
3. Run artisan command:
````bash
php artisan make:jsontoclass
```` 
4. Check your files under your specified file location 


## Example


### Input

#### PHP Array

````php
     'post' => [
            'author'    => (object)[
                'first_name' => '',
                'last_name'  => '',
            ],
            'comment'   => (object)[
                'user'    => (object)[
                    'first_name' => '',
                    'last_name'  => ''
                ],
                'content' => ''
            ],
            'followers' => (array)[
                'id'            => '',
                'follower_user' => (object)[
                    'first_name' => '',
                    'last_name'  => ''
                ]
            ],
            'text'      => '',
            'date'      => '2019-01-01'
        ]
````

Note: each object should have key name defined. 

- If it is object please define it as a `object`, see above.
- If your components are array of object, please define it as a pure array.
- You have to assign a value for each property, for example, an empty string `''` for `first_name`.

#### or JSON

- I have disabled JSON method, you need to convert JSON to PHP array yourself. (You can use online convert tool if necessary)
- Then please follow Array Input instruction.



### Output - Classes:

#### Author Class
````php
<?php


class Author
{
	/** @var $firstName */
	public $firstName;

	/** @var $lastName */
	public $lastName;


	/**
	 * @return Author
	 */
	public static function create()
	{
		return new self;
	}


	/**
	 * @return array
	 */
	public function toArray(): array
	{
		return [
		   'first_name' => $this->firstName,
		   'last_name' => $this->lastName,
		];
	}
}


````

#### Followers Class
````php
<?php
class Followers
{
	/** @var $id */
	public $id;

	/** @var FollowerUser $followerUser */
	public $followerUser;


	/**
	 * @return Followers
	 */
	public static function create()
	{
		return new self;
	}


	/**
	 * @param FollowerUser $followerUser
	 * @return $this
	 */
	public function addFollowerUser($followerUser)
	{
		$this->followerUser[] = $followerUser;
		return $this;
	}


	/**
	 * @return array
	 */
	public function toArray(): array
	{
		return [
		   'id' => $this->id,
		   'follower_user' => collect($this->followerUser)->map(function (FollowerUser $data){
		        return $data->toArray();
		    })->toArray(),
		];
	}
}


````


#### FollowerUser Class
````php
class FollowerUser
{
	/** @var $firstName */
	public $firstName;

	/** @var $lastName */
	public $lastName;


	/**
	 * @return FollowerUser
	 */
	public static function create()
	{
		return new self;
	}


	/**
	 * @return array
	 */
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
