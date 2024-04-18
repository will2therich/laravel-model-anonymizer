![LaravelModelAnonymizer](https://github.com/will2therich/laravel-model-anonymizer/assets/24435180/36bd8957-85ca-4df4-96e1-fdf147ed1171)

# LaravelModelAnonymizer

LaravelModelAnonymizer is a Laravel package designed to help developers anonymize existing data in their models. This is particularly useful for creating non-production datasets where sensitive information needs to be obscured without affecting the integrity of the application data.

## Installation

To install the package, run the following command in your Laravel project:

``composer require will2therich/laravel-model-anonymizer``

After the package is installed, you need to set up the environment by running:

``php artisan model-anonymizer:install``

This command creates a directory called `Anonymize` under your main `app` folder. Here, you can define your anonymization classes.

## Creating Anonymization Classes

Anonymization classes should be placed in the `app/Anonymize` directory. Each class must implement the `AnonymizeInterface` and define how each model attribute should be anonymized. Here is a stub to get you started:

```php
namespace App\Anonymize;

use Faker\Factory;
use Illuminate\Database\Eloquent\Model;
use will2therich\LaravelModelAnonymizer\Contracts\AnonymizeInterface;

class User implements AnonymizeInterface
{
    public static $model = \App\Models\User::class;

    public static $name = "User";

    public static function anonymize(Model $model)
    {
        $faker = Factory::create();
    
        $model->email = $faker->unique()->email();
        $model->save();
    }

}
```

* Replace the content of the `anonymize` method with the appropriate Faker methods to suit your specific model's needs.
* Replace `$model` With the desired model
* Replace `$name` With a name for the command to use

## Usage

Once you have set up your anonymization classes, you can anonymize your database by running:

``php artisan db:model-anonymize``

This command will iterate through each model anonymizer defined in your `Anonymize` directory and anonymize every database item accordingly.

## Contributing

Contributions to LaravelModelAnonymizer are welcome! Please ensure that your code adheres to the Laravel coding standards and include tests for new features or fixes.

## License

This package is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
