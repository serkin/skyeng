# Skyeng test


## How to run

### Using vagrant

```bash

    git clone https://github.com/serkin/skyeng.git
    cd skyeng
    vagrant up
    vagrant ssh
    cd /vagrant
    composer install
    php yii migrate
    php yii serve --port=8888
```

Now access app on `http://192.168.33.33:8888`


### Bare running

Be sure you have `php`, `mysql`, `composer` installed on your system.
Create DB `yii2basic`

```bash
    git clone https://github.com/serkin/skyeng.git
    cd skyeng
    composer install
    php yii migrate
    php -S localhost:8888  -t web
```

Now access app on `http://localhost:8888`




