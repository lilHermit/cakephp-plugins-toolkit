# Toolkit plugin for CakePHP-3

This plugin contains lots of useful content in one plugin

## Installation

- Merge the following to your `require` section of composer.json, replacing {{version}} with any repo tags (eg `v1.0`, `v1.1`) or `dev-master` if you want the bleeding edge

```
  "require": {
    "lilhermit/cakephp-plugin-toolkit": "{{version}}"
  }
```

- Merge the following to your `repositories` section of composer.json add if you don't have one

```
  "repositories": [
    {
      "type": "vcs",
      "url": "https://bitbucket.org/lilHermit/cakephp-plugins-toolkit.git"
    }
  ]
```

- Perform a composer update

- Load the plugin in your `bootstrap.php`

```
Plugin::load('lilHermit/Tookit', ['bootstrap' => true]);
```

## SluggableBehavior

Add the Behavior to any Table using `$this->addBehavior('lilHermit/Sluggable');`

The Behavior takes the following config options

| Option        | Type          | Default   | Description   |
| ------------- | ------------- | --------- | ------------- |
| field         | String        | title     | This is the field that will be the source of the slug
| slug          | String        | slug      | This is the field that will be used for the destination of the slug
| replacement   | String        | - (dash)  | What character will be used to replace spaces
| lowercase     | Boolean       | false     | Should the slug be converted to lowercase
| onCreate      | Boolean       | true      | Should the slug be updated on Create
| onUpdate      | Boolean       | true      | Should the slug be updated on Update