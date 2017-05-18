# Toolkit plugin for CakePHP-3

This plugin contains lots of useful content in one plugin

## Installation

- Add this Bitbucket repository with the following:

```
composer config repositories.lilhermit-cakephp-plugin-toolkit vcs https://bitbucket.org/lilHermit/cakephp-plugins-toolkit.git
```

- Add the plugin with the following command, replacing `1.*` with `dev-master` if you want the bleeding edge:

```
composer require lilhermit/cakephp-plugin-toolkit:1.*
```

- Load the plugin in your `bootstrap.php`

```
Plugin::load('LilHermit/Tookit', ['bootstrap' => true]);
```

## SluggableBehavior

Add the Behavior to any Table using `$this->addBehavior('LilHermit/Toolkit.Sluggable');` in the `initialize` method

The Behavior takes the following config options

| Option        | Type          | Default   | Description   |
| ------------- | ------------- | --------- | ------------- |
| field         | String        | title     | This is the field that will be the source of the slug
| slug          | String        | slug      | This is the field that will be used for the destination of the slug
| replacement   | String        | - (dash)  | What character will be used to replace spaces
| lowercase     | Boolean       | false     | Should the slug be converted to lowercase
| onCreate      | Boolean       | true      | Should the slug be updated on Create
| onUpdate      | Boolean       | true      | Should the slug be updated on Update

Pass the options as an array like

```
$this->addBehavior('LilHermit/Toolkit.Sluggable', [
    'field' => 'name',
    'lowerCase' => true,
    'onUpdate' => false
]);
```