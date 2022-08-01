# Chapter 2 - Module creation

- Module creation
- Using services
- The form API
- Block Plugins
- Working with links
- Event dispatchers

https://github.com/PacktPublishing/Drupal-9-Module-Development-Third-Edition/tree/master/packt/chapter2

> Module creation, Routing, Plugin block,  Event (subscribers, dispatchers), Config form, Service creation

https://github.com/Yorik56/Drupal-9-Module-Development/tree/main/web/modules/custom/hello_world

> Structure of routes
- https://www.drupal.org/docs/drupal-apis/routing-system/structure-of-routes

> Drupal form API
https://api.drupal.org/api/drupal/elements/9.0.x

> Autoload an entity inside a controller from a parameter

```yaml
options:
  parameters:
    param:
      type: entity:node
```

> Route greeting salutation route
http://drupal.docker.localhost:8000/hello

> Route greeting form salutation route
http://drupal.docker.localhost:8000/admin/config/salutation-configuration


# Chapter 3 - Logging & Mailing

- Logging 
- Mail API
- Tokens

> logging
>http://drupal.docker.localhost:8000/admin/reports/dblog

> Drupal 7 watchdog
> https://api.drupal.org/api/drupal/includes%21bootstrap.inc/function/watchdog/7.x

> Drupal 9 logging
```php
\Drupal::logger('hello_world')->error('Hello World');
```

# Chapter 4 - Theming

- Buisness logic vs presentation logic
- Twig
- Theme hooks
- Render arrays
- Assets and libraries
- Common theme hooks
- Attributes
- Layouts
- Theming the Hello World module

