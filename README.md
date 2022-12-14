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

> Language Override
```php
$language_manager = \Drupal::service('language_manager');
$language = $language_manager->getLanguage('fr');
$original_language = $language_manager->getGetConfigOverrideLanguage();
$language_manager->setConfigOverrideLanguage($language);
$config = \Drupal::config('system.maintenance');
$message = $config->get('message');
$language_manager->setConfigOverrideLanguage($original_language);
```

> Config Overrride priority order

Global override config > Module override config > Language override config.

> Work with ImmutableConfig
```php
/**
 * @var \Drupal\Core\Config\ConfigFactoryInterface $factory
 */
$factory = \Drupal::service('config.factory');
// Get a config object. in readonly mode.
$read_only_config = $factory->get('hello_world.custom_salutation');
// Get a config object. in read/write mode.
$read_and_write_config = $factory->getEdtable('hello_world.custom_salutation');
$read_and_write_config->set('salutation', 'Hello World');
$read_and_write_config->save();
```
> Load in a static way a config object
```php
\Drupal::config('system.maintenance');
```

> Travers down a nested config object
```php
$config = \Drupal::config('system.site');
$value = $config->get('page.403');
```
> Get the original config object despite the possible overrides
```php
$config = $factoy->get('system.maintenance');
$value = $config->getOriginal('message', FALSE);
```

> Clear values of a config object element (set the value to NULL)
```php
$config->clear('message')->save();
```

> Remove a config object
```php
$config->delete();
```

## Entities

> Content versus configuration entity types

"Essentially, configuration entities are exportable sets of configurations values that inherit much of the same handling API as content entities"

## Typed data API

> Two main aspects: DataType and data definition

> Modeling a simple string
```php
$definition = DataDefinition::create('string');
$definition->setLabel('Define a simple label string');
/**
 * @var \Drupal\Core\TypedData\TypedDataInterface $data
 */
$data = \Drupal::typedDataManager()->create($definition, 'my_value');

$value = $data->getValue();
$data->setValue('another string');
$type = $data->getDataDefinition()->getDataType();
$label = $data->getDataDefinition()->getLabel();

// Other example (the plate definition)
$plate_number_definition = DataDefinition::create('string')
$plate_number_definition->setLabel('A license plate number');
$state_code_definition = DataDefinition::create('string')
$state_code_definition->setLabel('A state code');

$plate_definition = MapDataDefinition::create();
$plate_definition->setLabel('A US license plate');

$plate_definition->setPropertyDefinition('number', $plate_number_definition);
$plate_definition->setPropertyDefinition('state', $state_code_definition);

// Instanciation of the plugin
/**
 * @var \Drupal\Core\TypedData\Plugin\DataType\Map $plate
 */
$plate = \Drupal::typedDataManager()->create($plate_definition, [
  'number' => '405-307',
  'state' => 'NY',
]);
// Manage the object created
$label = $plate->getDataDefinition()->getLabel();
$number = $plate->get('number');
$state = $plate->get('state');
```
## Interact with the Entity API

> Querying entities
```php
$query = \Drupal::entityTypeManager()->getStorage('node')->getQuery();
$query
    ->condition('type', 'article')
    ->condition('status', TRUE)
    ->sort('created', 'DESC')
    ->range(0, 10);
$ids = $query->execute();
// A more complex condition
    ->condition('type', ['article', 'page'], 'IN')

// Using conditions groups
$query->condition('status', TRUE);
$or = $query->orConditionGroup()
    ->condition('title', 'Drupal', 'CONTAINS')
    ->condition('field_tags.entity.name', 'Drupal', 'CONTAINS');
$query->condition($or);
$ids = $query->execute();
```

> Querying configuration entities
```php
$query = \Drupal::entityTypeManager()->getStorage('view')->getQuery();
$query
    ->condition('display.*.display_plugin', 'page');
$ids = $query->execute();
```

> Loading entities
```php
// Load multiple entities (returns an array of EntityInterface objects)
$nodes = \Drupal::entityTypeManager()->getStorage('node')->loadMultiple($ids);
// Load only one entity (returns an NodeInterface object)
$node = \Drupal::entityTypeManager()->getStorage('node')->load($id);
```

> Querying and loading in one go
```php
// Cannot manage complex queries
// Check access will be taken into account on the query
// For full control just build your own query
$nodes = \Drupal::entityTypeManager()->getStorage('node')->loadByProperties([
  'type' => 'article',
  'status' => TRUE,
]);
```
> Reading entities
```php
// Get data from a configuration Entity
/** @var \Drupal\node\Entity\NodeType $type */
$type = \Drupal::entityTypeManager()->getStorage('node_type')->load('article');
// Using invidual methods from the entity
$description = $type->getDescription();
// Using ConfigEntityBase methods (that the Node class extend)
$description = $type->get('description');
//Using methods of the EntityInterface (that the Node class implements)
$id = $type->id();
$label = $type->label();
$uuid = $type->uuid();
$bundle = $type->bundle();
$language = $type->language();
```
