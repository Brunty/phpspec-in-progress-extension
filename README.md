PhpSpec Work In Progress Extension
====================

[![Build Status](https://travis-ci.org/Brunty/phpspec-in-progress-extension.svg?branch=master)](https://travis-ci.org/Brunty/phpspec-in-progress-extension)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/e073ed3e-34a5-498b-a5af-93149709c30a/mini.png)](https://insight.sensiolabs.com/projects/e073ed3e-34a5-498b-a5af-93149709c30a)

## Compatibility

PhpSpec 3.0 and above

## Install

Run the following command:

```
$ composer require brunty/phpspec-skip-work-in-progress-extension
```

## Usage

Add a `@wip` annotation to a docblock for the example you're working on.

```php
class MultiplierSpec extends ObjectBehavior
{
    /**
     * This will be skipped as the example is marked as work-in-progress
     *
     * @wip
     */
    function it_multiplies_two_numbers_together()
    {
    }

    // This will not be skipped as the example and spec are not marked as work-in-progress
    function it_multiplies_three_numbers_together()
    {
    }
}
```


## Contributing

Although this project is small, openness and inclusivity are taken seriously. To that end the following code of conduct has been adopted.

[Contributor Code of Conduct](CONTRIBUTING.md)
