<p align=center><img height=150 src="https://raw.githubusercontent.com/php-protein/docs/master/assets/protein-large.png"></p>

# Protein | Filter
## Class trait for permitting users to override data via callback hooks

### Install
---

```
composer require protein/filter
```
Require the global class via :

```php
use Protein\Filter;
```

or the include the trait in your classes via :

```php
use Protein\Filters;

class MyClass {
    use Filters;
}
```

### Adding a filter
---

You can attach a filter function to a custom named group via the `add` method.

```php
Filter::add('title',function($title){
   return strtoupper($title);
});
```

Multiple calls to the same group attach multiple filter functions.

```php
// Concatenate effects :
Filter::add('title',function($title){
   return strtoupper($title);
});

Filter::add('title',function($title){
   return $title . '!';
});
```

You can assign a single callback to multiple filters defining them with an array of keys :

```php
Filter::add(['href','src'], function($link){
   return BASE_URL . $link;
});
```

>This is the same as :
>
>```php
>Filter::add('href', function($link){
>   return BASE_URL . $link;
>});
>
>Filter::add('src', function($link){
>   return BASE_URL . $link;
>});
>```

You can also pass an array map filter => callback :

```php
Filter::add([
   'src' => function($src){
     return BASE_URL . $src;
    },
   'href' => function($href){
     return HTTPS . $href;
    },
]);
```

>This is the same as :
>
>```php
>Filter::add('href', function($href){
>   return HTTPS . $href;
>});
>
>Filter::add('src', function($src){
>   return BASE_URL . $src;
>});
>```

### Removing a filter
---

You can remove an attached filter function to a custom named group via the `remove` method.

```php
$the_filter = function($title){
   return strtoupper($title);
};

Filter::add('title',$the_filter);

...

Filter::remove('title',$the_filter);
```

You can remove all filters attached to a group by not passing the filter function.


```php
Filter::remove('title');
```

### Applying a filter
---

You can apply a filter to a value via the `with` method.

```php
Filter::with('title','This was a triumph')
```

**Example**

```php
Filter::add('title',function($title){
   return strtoupper($title);
});

Filter::add('title',function($title){
   return $title . '!';
});

echo Filter::with('title','This was a triumph');

// THIS WAS A TRIUMPH!
```

Multiple fallback keys can be passed, the first non-empty queue will be used for the current filter.

```php
Filter::with(["document.title", "title"],'This was a triumph')
```

**Example**

```php
Filter::add("title", "strtoupper");
echo Filter::with(["document.title", "title"],'This was a triumph');
```

The `title` filter will be executed instead of the empty `document.title`.

```
THIS WAS A TRIUMPH
```

```php
Filter::add("title", "strtoupper");
Filter::add("document.title", "str_rot13");
echo Filter::with(["document.title", "title"],'This was a triumph');
```

Here the `document.title` filter will be executed instead of `title`.

```
Guvf jnf n gevhzcu
```