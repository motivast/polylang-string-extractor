# Contribution guide
I’m really excited that you are interested in contributing to Polylang String Extractor. Before submitting your contribution though, please make sure to take a moment and read through the following guidelines.

## Development setup

### Clone project
```
git clone git@github.com:motivast/polylang-string-extractor.git
cd polylang-string-extractor
```

### Copy dotenv and fill with your properties
```
cp .env.example .env
```

### Install dependencies
```
composer install
```
During installation WordPress is downloaded to wordpress directory and current directory is self symlinked to wordpress/wp-content/plugins. Pointing your webserver vhost to wordpress directory give you fully working WordPress instance with Polylang String Extractor plugin installed.

### Setup WordPress
```
./vendor/bin/phing wp:init
```

This command will install WordPress with configuration from .env file. After installation you should have fully working WordPress instance with Polylang String Extractor plugin activated.

### Setup tests
```
./vendor/bin/phing tests:db:create tests:config
```

This command will create WordPress database for tests and create config file in wordpress-dev directory.

### Code inspection and tests
Be sure to execute code inspection and test before before making a pull request.
```
./vendor/bin/phing inspect tests
```
