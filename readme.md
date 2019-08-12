# Laravel DTO Generator

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]


[link-packagist]: https://packagist.org/packages/timehunter/laravel-dto-generator
[ico-version]: https://img.shields.io/packagist/v/timehunter/laravel-dto-generator.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/timehunter/laravel-dto-generator.svg?style=flat-square
[link-downloads]: https://packagist.org/packages/timehunter/laravel-dto-generator

## A DTO generator that helps you create a bunch of models instead of repeating copy/paste.

### Star me if you find its useful. ^.^

*Please update your version to be "~v2.0" and re-publish your config file*

Install the package in development dependencies:

Via Composer

``` bash
composer require --dev timehunter/laravel-dto-generator "~2.1"
```

## Installation

1. Create your local config file
````bash
php artisan vendor:publish --provider="TimeHunter\LaravelDTOGenerator\LaravelDTOGeneratorServiceProvider"
````
2. Add your array schema in config
3. Run artisan command:
````bash
php artisan make:dto
```` 
4. Check your files under your specified file location 


## Example


### Input

#### PHP Array Schema

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

- If it is an object please define it as a `object`, see the above.
- If your components are array of objects, please define it as a pure array.
- You have to assign a value for each property, for example, an empty string `''` for `first_name`.

#### or JSON

- I have disabled JSON method, you need to convert JSON to PHP array by yourself. (You can use online convert tool if necessary)
- Then please follow Array Schema instruction.



### Output - Classes:

#### Example Output Usage

````php
    $result = Followers::create()->setId(1)
            ->addFollowerUsers(
                FollowerUsers::create()
                    ->setFirstName('ss')
                    ->setLastName('dd')
            )
            ->addFollowerUsers(
                FollowerUsers::create()
                    ->setFirstName('ss')
                    ->setLastName('dd')
            );
        var_dump($result->toArray());
````

#### User Class
````php
<?php

namespace App;

class User
{
	/** @var bool $isActive */
	private $isActive;

	/** @var string $firstName */
	private $firstName;

	/** @var string $lastName */
	private $lastName;


	/**
	 * @return User
	 */
	public static function create()
	{
		return new self;
	}


	/**
	 * @return bool
	 */
	public function getIsActive(): bool
	{
		return $this->isActive;
	}


	/**
	 * @param bool $isActive
	 * @return $this
	 */
	public function setIsActive(bool $isActive): self
	{
		$this->isActive = $isActive;
		return $this;
	}


	/**
	 * @return string
	 */
	public function getFirstName(): string
	{
		return $this->firstName;
	}


	/**
	 * @param string $firstName
	 * @return $this
	 */
	public function setFirstName(string $firstName): self
	{
		$this->firstName = $firstName;
		return $this;
	}


	/**
	 * @return string
	 */
	public function getLastName(): string
	{
		return $this->lastName;
	}


	/**
	 * @param string $lastName
	 * @return $this
	 */
	public function setLastName(string $lastName): self
	{
		$this->lastName = $lastName;
		return $this;
	}


	/**
	 * @return array
	 */
	public function toArray(): array
	{
		return [
		   'is_active' => $this->isActive,
		   'first_name' => $this->firstName,
		   'last_name' => $this->lastName,
		];
	}
}


````

#### Comment Class
````php
namespace App;

class Comment
{
	/** @var User $user */
	private $user;

	/** @var string $content */
	private $content;


	/**
	 * @return Comment
	 */
	public static function create()
	{
		return new self;
	}


	/**
	 * @param user $user
	 * @return $this
	 */
	public function addUser(User $user): self
	{
		$this->user = $user;
		return $this;
	}


	/**
	 * @return User
	 */
	public function getUser(): User
	{
		return $this->user;
	}


	/**
	 * @param User $user
	 * @return $this
	 */
	public function setUser(User $user): self
	{
		$this->user = $user;
		return $this;
	}


	/**
	 * @return string
	 */
	public function getContent(): string
	{
		return $this->content;
	}


	/**
	 * @param string $content
	 * @return $this
	 */
	public function setContent(string $content): self
	{
		$this->content = $content;
		return $this;
	}


	/**
	 * @return array
	 */
	public function toArray(): array
	{
		return [
		   'user' => $this->user->toArray(),
		   'content' => $this->content,
		];
	}
}


````
#### Author Class
````php
namespace App;

class Author
{
	/** @var int $id */
	private $id;

	/** @var  $note */
	private $note;

	/** @var float $rating */
	private $rating;

	/** @var string $firstName */
	private $firstName;

	/** @var string $lastName */
	private $lastName;


	/**
	 * @return Author
	 */
	public static function create()
	{
		return new self;
	}


	/**
	 * @return int
	 */
	public function getId(): int
	{
		return $this->id;
	}


	/**
	 * @param int $id
	 * @return $this
	 */
	public function setId(int $id): self
	{
		$this->id = $id;
		return $this;
	}


	/**
	 * @return mixed
	 */
	public function getNote()
	{
		return $this->note;
	}


	/**
	 * @param  $note
	 * @return $this
	 */
	public function setNote($note): self
	{
		$this->note = $note;
		return $this;
	}


	/**
	 * @return float
	 */
	public function getRating(): float
	{
		return $this->rating;
	}


	/**
	 * @param float $rating
	 * @return $this
	 */
	public function setRating(float $rating): self
	{
		$this->rating = $rating;
		return $this;
	}


	/**
	 * @return string
	 */
	public function getFirstName(): string
	{
		return $this->firstName;
	}


	/**
	 * @param string $firstName
	 * @return $this
	 */
	public function setFirstName(string $firstName): self
	{
		$this->firstName = $firstName;
		return $this;
	}


	/**
	 * @return string
	 */
	public function getLastName(): string
	{
		return $this->lastName;
	}


	/**
	 * @param string $lastName
	 * @return $this
	 */
	public function setLastName(string $lastName): self
	{
		$this->lastName = $lastName;
		return $this;
	}


	/**
	 * @return array
	 */
	public function toArray(): array
	{
		return [
		   'id' => $this->id,
		   'note' => $this->note,
		   'rating' => $this->rating,
		   'first_name' => $this->firstName,
		   'last_name' => $this->lastName,
		];
	}
}

````

#### Followers Class
````php
namespace App;

class Followers
{
	/** @var int $id */
	private $id;

	/** @var FollowerUsers[] $followerUsers */
	private $followerUsers = [];


	/**
	 * @return Followers
	 */
	public static function create()
	{
		return new self;
	}


	/**
	 * @return int
	 */
	public function getId(): int
	{
		return $this->id;
	}


	/**
	 * @param int $id
	 * @return $this
	 */
	public function setId(int $id): self
	{
		$this->id = $id;
		return $this;
	}


	/**
	 * @param followerUsers $followerUsers
	 * @return $this
	 */
	public function addFollowerUsers(FollowerUsers $followerUsers): self
	{
		$this->followerUsers[] = $followerUsers;
		return $this;
	}


	/**
	 * @return FollowerUsers[]
	 */
	public function getFollowerUsers()
	{
		return $this->followerUsers;
	}


	/**
	 * @param FollowerUsers[] $followerUsers
	 * @return $this
	 */
	public function setFollowerUsers($followerUsers): self
	{
		$this->followerUsers = $followerUsers;
		return $this;
	}


	/**
	 * @return array
	 */
	public function toArray(): array
	{
		return [
		   'id' => $this->id,
		   'follower_users' => array_map(function (FollowerUsers $data){
		          return $data->toArray();
		      }, $this->followerUsers),
		];
	}
}

````


#### FollowerUser Class
````php
namespace App;

class FollowerUsers
{
	/** @var string $firstName */
	private $firstName;

	/** @var string $lastName */
	private $lastName;


	/**
	 * @return FollowerUsers
	 */
	public static function create()
	{
		return new self;
	}


	/**
	 * @return string
	 */
	public function getFirstName(): string
	{
		return $this->firstName;
	}


	/**
	 * @param string $firstName
	 * @return $this
	 */
	public function setFirstName(string $firstName): self
	{
		$this->firstName = $firstName;
		return $this;
	}


	/**
	 * @return string
	 */
	public function getLastName(): string
	{
		return $this->lastName;
	}


	/**
	 * @param string $lastName
	 * @return $this
	 */
	public function setLastName(string $lastName): self
	{
		$this->lastName = $lastName;
		return $this;
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


## License

MIT. Please see the [license file](license.md) for more information.
