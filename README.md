# Algolia technical test

### Objective

The goal of this test is to evaluate your ability to parse and process a big amount of data and to use the appropriate data structures to solve a simple challenge.  
The goal is to extract the popular (most frequent) queries that have been done during a specific time range.

### Bootstrap

Either create a specific vhost or run a php server locally.

`php -S localhost:8000 -t public` 

### Prerequisites

- The application needs the provided [data file](https://www.dropbox.com/s/duv704waqjp3tu1/hn_logs.tsv.gz?dl=0) to be stored in `storage/app/queries/`. It is added to the project for simplicity. 

### Routes available

- `1/queries/count/{date}`
    - The date must follow the example format `2015-08-01 00:04`
- `1/queries/popular/{date}?size={size}`
    - The size must be a valid integer
    - The date must follow the example format `2015-08-01 00:04` 

### Run tests

```bash
$ # all tests
$ ./vendor/bin/phpunit

$ # e2e tests
$ # Integration test are based on the examples defined in the subject.md
$ ./vendor/bin/phpunit --testsuite e2e

$ # unit tests
$ ./vendor/bin/phpunit --testsuite unit
```

### Enhancements

- The project lacks monitoring. We should add application logs.
- A simple reduce algorithm on the file gives better performances but is currently stored locally. 
To scale, we may envisage a Key/Value DB (redis) for partitioning and concurrency.
- Some unit tests are missing, notably for the File reducer algorithm and the cache.
- We should enhance the way we work with the files. We may use an S3 connector and refine the whole configuration management of the app.
- Some parts of the app should be driven by events, like the management of the cache.
