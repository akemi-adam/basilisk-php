<?php

use AkemiAdam\Basilisk\App\Komodo\Model;
use App\Models\User;

uses()->group('model');

// it('has the following properties: $connection, $table, $columns, $query, $statement, $fields, $options', fn () => expect(new User)->toHaveProperties([ 'table', 'columns', 'query', 'statement', 'fields', 'options' ]));

// it('has the following methods: reset, getColumns, getTableName, isString, save, all, get, where, orderBy', fn () => expect(new User)->toHaveMethods([ 'reset', 'getColumns', 'getTableName', 'isString', 'save', 'all', 'get', 'where', 'orderBy' ]));

it('can save a new entity in the database based in a specific entity through of method create', function ()
{
    $data = [
        'first_name' => faker()->name(),
        'email' => faker()->safeEmail(),
        'password' => password_hash(faker()->word(), PASSWORD_DEFAULT),
    ];

    User::create($data);

    expect($data)->toBeInDatabase('users');
})->only();

it('can save a new entity in the database based in a specific entity through of method save with a instance of class', function ()
{
    $user = new User;

    $user->first_name = faker()->name();

    $user->email = faker()->safeEmail();
    
    $user->password = password_hash(faker()->word(), PASSWORD_DEFAULT);

    $user->save();

    expect($user)->toBeModelInDatabase();
});

it('can find a existing entity in the database with find() method', function ()
{
    $user = get_new_user();

    $findedUser = User::find($user->id);

    expect($findedUser)->toBeModelInDatabase()->toBeInstanceOf(User::class);
});

it('can find a existing entity in the database with where() and get() methods', function ()
{
    $user = get_new_user();

    $users = User::init()->where('id', $user->id)->get();
    // $user = (new User)->where('id', $user->id)->get();

    expect($users)->toContainOnlyInstancesOf(User::class);

    expect($users[0])->toBeModelInDatabase()->toBeInstanceOf(User::class);
});

it('can recovery all data of a table with all() method', function ()
{
    $users = User::all();

    expect($users)->toBeArray()->toContainOnlyInstancesOf(User::class);

    while ($user = current($users)) {
        expect($user)->toBeModelInDatabase();
        next($users);
    }
});

it('can deletes a model', function ()
{
    $user = get_new_user();

    expect($user->delete())->toBeTrue();
});

it('can update all model collumns', function ()
{
    $user = get_new_user();

    $oldProperties = \get_dynamics_properties($user);

    $user->update([
        'first_name' => faker()->name(),
        'email' => faker()->safeEmail(),
        'password' => password_hash(faker()->word(), PASSWORD_DEFAULT),
    ]);

    $updatedsProperties = \get_dynamics_properties($user);

    expect($updatedsProperties)->not->toMatchArray($oldProperties);

    expect($user)->toBeInstanceOf(User::class)->toBeModelInDatabase();
});

it('can update a specif model property', function ()
{
    $user = get_new_user();

    $oldProperties = \get_dynamics_properties($user);

    $user->update([ 'first_name' => faker()->name() ]);

    $updatedsProperties = \get_dynamics_properties($user);

    expect($updatedsProperties)->not->toMatchArray($oldProperties);

    expect($user)->toBeInstanceOf(User::class)->toBeModelInDatabase();
});
