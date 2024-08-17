# Contribution Guide

## Turns all the multi-line comments `(/* */)` with a single line into a single-line comment `(//)`

```PHP
// Before...

/* Run every 30 minutes except when directed not to by the `SkipDetector` */
$schedule->command('do:thing')->everyThirtyMinutes()->skip(function () {
    return app('SkipDetector')->shouldSkip();
});

// After...

// Run every 30 minutes except when directed not to by the `SkipDetector`
$schedule->command('do:thing')->everyThirtyMinutes()->skip(function () {
    return app('SkipDetector')->shouldSkip();
});
```

## Turns all the Upper case words `(NOT)` to Lower case `(not)`

```PHP
// Before...

// The `secret` method does NOT show what you are typing
$password = $this->secret('Please Enter Password');

// After...

// The `secret` method does not show what you are typing
$password = $this->secret('Please Enter Password');
```

## The `NOTE that` must be in a separate sentence, and without `that`

```PHP
// Before...

/* `sendEmail` is an option BUT `userId` is an argument, NOTE that: you should put [=] sign to say that
the option accepts a value */

// After...

// The `sendEmail` is an option but `userId` is an argument
/* NOTE: You should put the [=] sign to say that the option accepts a value, also the string after the `:` is a
description for this argument or option */
```
