# Algolia technical test

### Objective

The goal of this test is to evaluate your ability to parse and process a big amount of data and to use the appropriate data structures to solve a simple challenge.  
The goal is to extract the popular (most frequent) queries that have been done during a specific time range.

### Bootstrap

Clone the project and install the dependencies

`composer install`

Either create a specific vhost or run a php server locally.

`php -S localhost:8000 -t public`

### Prerequisites

- The application needs the provided [data file](https://www.dropbox.com/s/duv704waqjp3tu1/hn_logs.tsv.gz?dl=0) to be stored in `storage/app/queries/`. It is automatically copied from the test fixtures to get up and running. 

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

$ # Integration tests
$ # Integration test are based on the examples defined in the subject.md
$ ./vendor/bin/phpunit --testsuite feature

$ # unit tests
$ ./vendor/bin/phpunit --testsuite unit
```