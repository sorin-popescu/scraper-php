# Php scraper

## Installation

1. Clone repository
2. cd into project root directory
3. Run
```bash
    composer install
```

## Usage

Run the symfony console command below in your shell (you can specify any list url):
```bash

 bin/console get:list http://hiring-tests.s3-website-eu-west-1.amazonaws.com/2015_Developer_Scrape/5_products.html
```

## Tests

Run the following command from the project root directory.

#### PhpUnit

```bash
 phpunit
```