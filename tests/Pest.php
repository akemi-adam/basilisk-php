<?php

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "uses()" function to bind a different classes or traits.
|
*/

// uses(Tests\TestCase::class)->in('Feature');


require __DIR__ . '/../app.php';

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
 */

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});

expect()->extend('toBeInDatabase', function (string $table)
{
    $connection = \get_connection();
    
    $query = "SELECT * FROM $table WHERE ";

    $count = 0;

    foreach ($this->value as $collumn => $value)
    {
        $query .=  sprintf("%s %s",  (!$count ? '' : ' AND '), "$collumn = " . (\isString($value)));
    
        $count++;
    }

    $statement = $connection->prepare($query);

    return expect($statement->execute())->toBeTrue();
});

expect()->extend('toBeModelInDatabase', 
    fn () => expect(\get_dynamics_properties($this->value))->toBeInDatabase($this->value::getTableName())
);

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

function getInvisibleMethod(string|object $methodOwner, string $name) : ReflectionMethod
{
    return (new ReflectionClass($methodOwner))->getMethod($name);
}

function get_new_user() : App\Models\User
{
    return App\Models\User::create([
        'first_name' => faker()->name(),
        'email' => faker()->safeEmail(),
        'password' => password_hash(faker()->word(), PASSWORD_DEFAULT),
    ]); 
}

