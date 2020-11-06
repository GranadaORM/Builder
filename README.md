# Builder
Class builder for models and controllers for the Granada ORM

## Installation

Install easily with composer:

```composer require granadaorm/builder```

I highly recommend getting the form component instead, which also pulls builder:

```composer require granadaorm/form```

## Introduction

GranadaORM is a fantastic ORM but creating and managing the classes for each table in a large system can get tedious.
Builder addresses this problem using a script that analyses the (MySQL only for now) database structure and automatically builds the required classes for models and controllers.

An added bonus is that a modern IDE will get autocomplete for the elements and functions available in the models.

## Overview

When working with GranadaORM there are two main modes of interaction with the models: Building a query, and working with results of a query.

The builder creates a level of classes extending \Granada\Model to add functionality and split these two modes of operation:

- The _Query_ classes contain functions to help filter the database to get a desired set of results
- The _Base_ classes contain data elements and functions to work on the data for a record or set of records

### Hierarchy

Let's use an example of a table of People. It has the fields:

| myapp_person |
| ----- |
| id |
| first_name |
| last_name |
| created_at |
| deleted_at |

The _\Myapp\Person_ class is created that extends _\Myapp\BasePerson_ which extends a class you define in your configuration, to allow for system-wide additions. That class needs to extend _\Granada\Builder\ExtendedModel_ which extends _\Granada\Model_

### Added functionality

To make Granada models more useful, the following functions and features have been added for all models created and managed by Builder:

* __Before / After Save__ - functions are called just before and just after every save operation

* __Before / After SaveNew__ - functions are called just before and just after when the record is being inserted into the table. Only happens the first time that item is saved. The above before / after save functions are also called.

* __Before / After Delete__ - functions are called just before and just after the record is deleted from the database

* __Representation__ - define a field or fields and a display function (defaults to the first not-null field in the table) to use as a representation of the row. For example the Person record above may combine first_name and last_name fields to create a full name representation of the row.

* __find_pairs_representation()__ - pulls the data from the database and returns an array with the id of the row as key and the representation of the model as the value.

* __Date and DateTime__ fields are represented by the fabulous Chronos library by CakePHP. The database fields are all stored using the same timezone (default and recommended UTC) but can be optionally configured on a per-field basis to have a timezone or not. The interface is automatic and timezone headaches are a thing of the past!

* __Sort Order__ automation by using an integer sort_order field that defaults to "0" the order is automatically set to the end of the list when created

* __Reload__ or __refresh__ functions to fetch fresh contents from the database. This happens automatically on save to ensure any related data is not stale

* __Typed data__ is properly returned, so an integer field returns an integer and a boolean (tinyint(1)) returns boolean. This makes outputting json for REST interfaces much cleaner.

* __Pluralized and Singularized__ versions of the model name. Use ```humanName()``` to get "Person" and ```humanNames()``` to get "People"

* __Nested Sets__ by adding integer fields of `root`, `level`, `lft` and `rgt` you can store trees of data, with functions to manage the hierarchy of the records in the table.

## Usage

Here's some examples of how you can use the classes to interact with the database through Granada even easier.

### Querying

Using the example above, let's get the list of the 50 people who were most recently updated:

```
$people = \Myapp\Person::model()
          ->order_by_updated_at_desc()
          ->limit(50)
          ->find_many();

foreach ($people as $person) {
    echo $person->representation();
}
```

Now let's get the list of all the people with the surname "Smith"

```
$people = \Myapp\Person::model()
          ->where_last_name('Smith')
          ->order_by_first_name()
          ->find_many();

foreach ($people as $person) {
  echo $person->first_name;
  echo $person->created_at_chronos->toDateString();
}

```

For more functions available, see the list at the top of the ```BasePerson.php``` and ```QueryPerson.php``` files.

## Set up for building

The build system needs to know where to put the files, how to access the database and what to namespace to use if you haven't named your table names with the namespace prefix.

### Create the config file

Create a config file with contents similar to the following:

```

<?php
$db_host = 'database';
$db_name = 'db_name';
$db_username = 'db_user';
$db_password = 'db_pass';
$model_to_extend = '\MyAppCore\ORMBase';
$models_output_dir = __DIR__ ;
$controller_model_to_extend = '\MyAppCore\Controller';
$use_namespaces = false; // If set to true, you don't need the next two and it splits the namespace from the prefix of the table name
$namespace_prefixes = [
    'blog', // Blog namespace has table names starting with "blog_"
];
$default_namespace = 'MyApp';

$plural_tables = [];

```

That config file should be put somewhere that your script can run it. You can see that in the example the output dir is the same directory as the config file.

### Add the directory to the autobuilder

In your system index.php or wherever your main entrypoint / config include, add an autoloader for these created classes to be loaded on access. For example you could use something like this - adjust your folders appropriately

```

$base_autoload_folder = __DIR__ . '/models';

spl_autoload_register(function ($classname) {
    $nsmodel = explode('\\', $classname);
    if (count($nsmodel) > 1) {
        $filename = $base_autoload_folder . "/" . $nsmodel[0] . '/' . $nsmodel[1] . ".php";
        if (file_exists($filename)) {
            include($filename);
        }

        $filename = $base_autoload_folder . "/cms/" . $nsmodel[0] . '/Models/' . $nsmodel[1] . ".php";
        if (file_exists($filename)) {
            include($filename);
        }

        $filename = $base_autoload_folder . "/cms/" . $nsmodel[0] . '/Models/_base/' . $nsmodel[1] . ".php";
        if (file_exists($filename)) {
            include($filename);
        }

        $filename = $base_autoload_folder . "/cms/" . $nsmodel[0] . '/Controllers/' . $nsmodel[1] . ".php";
        if (file_exists($filename)) {
            include($filename);
        }
    }
});

```

In the example above, we have a structure where the model and controller classes to extend sit in the ```$base_autoload_folder``` and under that is the ```cms``` folder which is where the config file sits, and all the classes are created.

## Doing the actual build

Run ```./vendor/bin/granadabuild /path/to/config/file```

It may take a minute if your database has a large number of tables.

Note that the builder creates four files for each table. For the ```myapp_person``` table above, the builder will create:

* /cms/Myapp/Models/Person.php

* /cms/Myapp/Models/_base/BasePerson.php

* /cms/Myapp/Models/_base/QueryPerson.php

* /cms/Myapp/Controllers/PersonController.php

Only the files in _base are managed automatically - the other two are meant for you to modify the class specific to the data in that table and should be managed by your version control system. You should ignore the _base folders and auto-generate those on the server with each system update.

## More details

Look in the generated source code, and in the Builder ExtendedModel and the tests to see how you can use the system.
