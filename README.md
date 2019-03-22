# Sort Eloquent model records by their attributes or relationships   

[![Build Status](https://travis-ci.org/Neurony/laravel-sort.svg?branch=master)](https://travis-ci.org/Neurony/laravel-sort)
[![StyleCI](https://github.styleci.io/repos/167262095/shield?branch=master)](https://github.styleci.io/repos/167262095)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Neurony/laravel-sort/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Neurony/laravel-sort/?branch=master)

- [Overview](#overview)   
- [Installation](#installation)   
- [Usage](#usage)   
- [Extra](#extra)   

# Overview

This package allows you to sort Eloquent model records by their attributes, or via their relationships. 
   
Relationship types that can be sorted by: `hasOne`, `belongsTo`   

# Installation

Install the package via Composer:

```
composer require neurony/laravel-sort
```

# Usage

### Step 1

Your Eloquent models should use the `Neurony\Sort\Traits\IsSortable` trait.

```php
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Neurony\Sort\Traits\IsSortable;

class YourModel extends Model
{
    use IsSortable;
    
    ...
}
```

### Step 2

You would access by whatever means the desired URI that specifies how the sort should behave:

```
/search-something?sort=name&direction=asc
```

Please note the `sort` and `direction` parameters!   
   
These are very important if you're using the `IsSortable` trait, as these two parameters are default for defining the:
- field to sort by (**sort** parameter)   
- direction to sort in (**direction** parameter)   
   
To see how to change these parameters, please see the [Extra](#extra) section.

### Step 3

Once you've used the `Neurony\Sort\Traits\IsSortable` trait in your Eloquent models and you've supplied the correct sorting parameters, you can sort the model records by using the `sorted()` query scope present on the trait.

```php
<?php

namespace App\Http\Controllers;

use App\YourModel;
use Illuminate\Http\Request;

class YourController extends Controller
{
    public function index(Request $request)
    {
        $records = YourModel::sorted($request->all())->get();
    }
}
```

The `sorted` query scope receives a mandatory first argument, that should be an associative array containing the field to sort by and the direction to sort in:

```php
// in our case, what's passed inside that parameter is this array:
['sort' => 'name', 'direction' => 'asc']
```

# Extra

### Sorting by relationship

To sort Eloquent model records by a relationship, use the following format when specifying the `sort` parameter:    
`{relationship_name}.{relationship_attribute}`

```
// sort posts by their author name in ascending order

/search-posts?sort=author.name&direction=asc
```

Please note that you can only sort by relationships of type `belongsTo` or `hasOne`.

### Changing the sorting parameters

In [Step 2](#step-2) we've talked about the importance of specifying the parameters that tell the trait the field to sort by and the direction to sort it.   
   
If you wish, those fields can be changed to other fields.   
   
In order to do that, you'll have to create a `Sort` object that will extend the `abstract Sort` object that comes with this package.

```php
<?php

namespace App\Sorts;

use Neurony\Sort\Objects\Sort;

class YourSort extends Sort
{
    /**
     * Get the request field name to sort by.
     *
     * @return string
     */
    public function field()
    {
        return 'field-to-sort-by';
    }

    /**
     * Get the direction to sort by.
     *
     * @return string
     */
    public function direction()
    {
        return 'direction-to-sort-in';
    }
}
```

After you've created the sort object, pass it as the second argument to the `sorted` query scope when sorting your model records.

```php
<?php

namespace App\Http\Controllers;

use App\YourModel;
use App\Sorts\YourSort;
use Illuminate\Http\Request;

class YourController extends Controller
{
    public function index(Request $request, YourSort $sort)
    {
        $records = YourModel::sorted($request->all(), $sort)->get();
    }
}
```

For the example above, your URI should look like this:

```
/search-something?field-to-sort-by=name&direction-to-sort-in=asc

// or to sort by a relationship

/search-something?field-to-sort-by=someRelation.some_attribute&direction-to-sort-in=asc
```

# Credits

- [Andrei Badea](https://github.com/zbiller)
- [All Contributors](../../contributors)

# Security

If you discover any security related issues, please email andrei.badea@neurony.ro instead of using the issue tracker.

# License

The MIT License (MIT). Please see [LICENSE](LICENSE.md) for more information.

# Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

# Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.