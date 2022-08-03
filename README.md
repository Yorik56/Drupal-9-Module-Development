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

> SMACSS Standards
http://smacss.com/

- base: CSS reset/normalizers and HTML styling
- layout: High-level page styling (grid system)
- component: UI elements and reusable components
- states: Styles used in client-side changes to components
- theme: Visual styling of components

> Differents ways to attach libraries by context
https://www.drupal.org/docs/creating-modules/adding-assets-css-js-to-a-drupal-module-via-librariesyml

# Chapter 5 - Menu and links

- The menu system
- Working with menu links
- Defining local tasks
- Defining local actions
- Defining contextual links

> Local tasks
groupe of local tasks (tabs) "module_name.links.task.yml"
> Local actions
"module_name.links.action.yml"
> Contextual links
"module_name.links.contextual.yml"

> implementing an admin menu.
````php
$menu_link_tree = \Drupal::menuTree();
$parameters = $menu_link_tree->getCurrentRouteMenuTreeParameters('admin');
$tree = $menu_link_tree->load('admin', $parameters);
$manipulators = [
['callable' => 'menu.default_tree_manipulators:checkAccess'],
];
$tree = $menu_link_tree->transform($tree, $manipulators);
$menu = $menu_link_tree->build($tree);
````

# Chapter 6 - Data Modeling and Storage

- Different types of data storage
- State API
- TempStore
- UserData API
- Entity
- Typed data
- Interacting with the Entity API

> Drupal State API
````php
# Set a value
\Drpal::state()->set('hello_world.message', 'Hello World');

# Get a value
Drupal::state()->get('hello_world.message');

# Set/Get multiple values
Drupal::state()->setMultiple([
  'hello_world.message' => 'Hello World',
  'hello_world.message2' => 'Hello World2',
]);

$values = Drpal::state()->getMultiple([
  'hello_world.message',
  'hello_world.message2',
]);

# Delete a value
Drupal::state()->delete('hello_world.message');

# Delete multiple values
Drupal::state()->deleteMultiple([
  'hello_world.message',
  'hello_world.message2',
]);
````

> Private TempStore
````php
/**
 * @var \Drupal\Core\TempStore\PrivateTempStoreFactory $factory
 */
$factory = \Drupal::service('tempstore.private');
$store = $factory->get('my_module.my_collection');
$store->set('my_key', 'my_value');
$value = $store->get('my_key');
# Delete entrie
$store->delete('my_key');
# Get metadata
$metadata = $store->getMetadata('my_key');
````
> Shared TempStore
```php
/**
 * @var \Drupal\Core\TempStore\SharedTempStoreFactory $factory
 */
$factory = \Drupal::service('tempstore.shared');
$store = $factory->get('my_module.my_collection');
# Set/Get entrie
$store->set('my_key', 'my_value');
$value = $store->get('my_key');
#Get metadata
$metadata = $store->getMetadata('my_key');
# Delete entrie
$store->delete('my_key');
# Set entrie if it does not exist
$store->setIfNotExists('my_key', 'my_value');
# Set entrie if it does not exist or belongs to the current user
$store->setIfOwner('my_key', 'my_value');
```

> Use the UserData API
```php
/**
 * @var \Drupal\user\UserData\UserDataInterface $user_data
 */
$user_data = \Drupal::service('user.data');

# get entrie
$value = $user_data->get('my_module', 'my_collection', 'my_key');

# set entrie
$user_data->set('my_module', 'my_collection', 'my_key', 'my_value');

# delete entrie
$user_data->delete('my_module', 'my_collection', 'my_key');

# All option of the three previous methods are optional, so you can filter your actions depending on  your needs.
```
> Configuration Shema

- web/core/config/schema/core.data_types.schema.yml (exemples of data types)
