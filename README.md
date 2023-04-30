## Introduction
This project should return score based on the word that has been passed to the endpoint and return the score for that specific word by appending `rocks` and `sucks` as positive and negative count respectively by some source. For now we have the source Github but other source can be added.

## Setup

1. Set up your env
```
    cp .env.example .env
    // you will have to setup .env
    // docker based .env
        DB_HOST=db
        DB_PORT=3306
        DB_DATABASE=word_score
        DB_USERNAME=root
        DB_PASSWORD=some_password
```
2. You can use the `canoe` script to run docker containers and everything what you need for this project. Basic commands:
``` 
    ./canoe up       -- runs the build and creates containers
    ./canoe down     -- stops the containers
    ./canoe migrate  -- migrates the app container database
    ./canoe backup   -- backups the database into you're local docker-compose/mysql/backup.sql path
```
3. Run `./canoe up` to start docker containers and also run `./canoe migrate` but if you are having connection errors please first check if you have set up the .env variables and if you still have the connection error then wait a bit for mysql service to start. You can check that with `docker logs db`
4. Run the following for setting up the `laravel/passport` for oauth2 and generate clients
```
    docker exec app php artisan passport:install
```
For detailed usage of `laravel/passport` you can take a look at the official laravel [documentation](https://laravel.com/docs/10.x/passport#clients-json-api)
5. (optional) If you are like me and you want to tinker a bit with the system and set everyting up by yourself you could use `laravel/valet` package.
You will be needing `homebrew`, `php@8.1`, `composer` and `mysql`. Here is the official [documentation](https://laravel.com/docs/10.x/valet#installation)

## Routes

| Request    | Endpoint               | Description            | Query Params       |
| ---------- | ---------------------- | ---------------------- | ------------------ |
| GET        | /api/v1/score/{word}   | Get a word score       | source(required)   |
| GET        | /api/v2/scores         | Get all scores         | /                  |

### Response Examples
1. `GET /api/v1/score/php?source=1` - `source=1` idicates that we will get it from github and `php` is the word we are searching on github
- Response: 
```
{
  "data": {
    "term": "php",
    "score": 4.19,
    "source": "GitHub"
  }
}
```
2. `GET /api/v2/scores`
- Response:
```
{
  "data": [
    {
      "term": "php",
      "score": 4.19,
      "source": "GitHub"
    },
    {
      "term": "windows",
      "score": 4.28,
      "source": "GitHub"
    }
  ],
  "links": {
    "first": "http://localhost:8000/api/v2/scores?page=1",
    "last": "http://localhost:8000/api/v2/scores?page=1",
    "prev": null,
    "next": null
  },
  "meta": {
    "current_page": 1,
    "from": 1,
    "last_page": 1,
    "links": [
      {
        "url": null,
        "label": "&laquo; Previous",
        "active": false
      },
      {
        "url": "http://localhost:8000/api/v2/scores?page=1",
        "label": "1",
        "active": true
      },
      {
        "url": null,
        "label": "Next &raquo;",
        "active": false
      }
    ],
    "path": "http://localhost:8000/api/v2/scores",
    "per_page": 15,
    "to": 1,
    "total": 1
  }
}
```

## Further development

If you wish to add new sources you would need to add a new service class for searching and implement the required methods in it. You need to implement `SourcServiceInterface`
and add new constant inside `App\Models\Word.php` and afterwords you will have to add a new source name `App\Models\Word::getSourceNameAttribute()` 


## Tests

You can run tests by running `docker exec app php artisan test` or through `./vendor/bin/phpunit tests/...`

