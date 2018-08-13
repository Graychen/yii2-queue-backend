
# yii2 queue-backend module
[![Latest Stable Version](https://poser.pugx.org/graychen/yii2-queue-backend/version)](https://packagist.org/packages/graychen/yii2-queue-backend)
[![Total Downloads](https://poser.pugx.org/graychen/yii2-queue-backend/downloads)](https://packagist.org/packages/graychen/yii2-queue-backend)
[![Build Status](https://travis-ci.org/Graychen/yii2-queue-backend.svg?branch=master)](https://travis-ci.org/Graychen/yii2-queue-backend)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Graychen/yii2-queue-backend/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Graychen/yii2-queue-backend/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/Graychen/yii2-queue-backend/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/Graychen/yii2-queue-backend/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/Graychen/yii2-queue-backend/badges/build.png?b=master)](https://scrutinizer-ci.com/g/Graychen/yii2-queue-backend/build-status/master)
[![StyleCI](https://styleci.io/repos/109097207/shield?branch=master)](https://styleci.io/repos/109097207)

This is a background for yii-queue, there are queue statistics, temporary support redis driver

## Install by Composer

`composer install graychen/yii2-queue-backend`

## Migrate database

### add migrationPath in console file

```php
'controllerMap' => [
    'migrate' => [
        'class' => 'yii\console\controllers\MigrateController',
        'migrationPath' => [
             '@graychen/yii2/queue/backend/migrations'
        ],
    ],
],
```
## run migration

```bash
yii migrate/up --migrationPath=@graychen/yii2/queue/backend/migrations
```

## For Backend Module

### Config module in config file

``` php 
'queue' => [
    'class' => 'graychen\yii2\queue\backend\Module',
]
```

### after that, visit `https://localhost/admin/queue/default`

![image](./queue.png)

## ChangeLog
[changelog](https://github.com/Graychen/yii2-queue-backend/blob/master/CHANGELOG.md)

