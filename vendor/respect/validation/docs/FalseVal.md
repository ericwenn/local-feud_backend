# FalseVal

- `v::falseVal()`

Validates if a value is considered as `false`.

```php
v::falseVal()->validate(false); //true
v::falseVal()->validate(0); //true
v::falseVal()->validate('0'); //true
v::falseVal()->validate('false'); //true
v::falseVal()->validate('off'); //true
v::falseVal()->validate('no'); //true
```

See also

  * [True](True.md)
