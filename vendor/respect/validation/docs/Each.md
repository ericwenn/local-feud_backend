# Each

- `v::each(v $validatorForValue)`
- `v::each(null, v $validatorForKey)`
- `v::each(v $validatorForValue, v $validatorForKey)`

Iterates over an array or Iterator and validates the value or key
of each entry:

```php
$releaseDates = array(
    'validation' => '2010-01-01',
    'template'   => '2011-01-01',
    'relational' => '2011-02-05',
);

<<<<<<< HEAD
v::arr()->each(v::date())->validate($releaseDates); //true
v::arr()->each(v::date(), v::strType()->lowercase())->validate($releaseDates); //true
=======
v::arrType()->each(v::date())->validate($releaseDates); //true
v::arrType()->each(v::date(), v::stringType()->lowercase())->validate($releaseDates); //true
>>>>>>> a3f2935... Rename rule "Arr" to "ArrType"
```

Using `arr()` before `each()` is a best practice.

See also:

  * [Key](Key.md)
  * [ArrType](ArrType.md)
