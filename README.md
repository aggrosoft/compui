# compUI

A graphical user interface for composer, written in PHP. Allows you to view all installed dependencies and edit the composer file directly. You can also run composer commands like install/update etc.

![Screenshot](/docs/screen.jpg?raw=true "Optional Title")

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. See deployment for notes on how to deploy the project on a live system.

### Installing

Installing is simple, you need composer to install compui.

#### Install using composer

```
composer create-project aggrosoft/compui
```

#### Install using checkout

Checkout the git repository or download the zip archive through github. 

```
git checkout https://github.com/aggrosoft/compui.git
```

Go to the installation folder and run the following command.

```
composer install
```

You have a running installation now, the default points to the composer file of compUI itself.

### Configuration
Edit config.json and set the project-path variable to a folder of the installation you want to manage:

```
{
  "composer-binary": "path to your composer binary",
  "project-path": "a relative or absolute path to the folder containing composer.json",
  "allowed-commands": [
    "update",
    "install",
    "dumpautoload"
  ]
}
```

## Deployment

Be sure to add some sort of authentication (e.g. .htaccess to prevent access), otherwise
anybody can edit your composer file.

## Built With

* [Slim Framwork](http://www.slimframework.com/) - The web framework used
* [Composer](https://getcomposer.org/) - Dependency Management
* [Bootstrap](https://getbootstrap.com/) - Frontend CSS Framework

## Contributing

Just create a fork and add a pull request or contact me through github

## Versioning

We use [SemVer](http://semver.org/) for versioning. For the versions available, see the [tags on this repository](https://github.com/aggrosoft/compui/tags). 

## Authors

* **Alexander Kludt** - *Initial work* - [Aggrosoft](https://github.com/aggrosoft)

See also the list of [contributors](https://github.com/aggrosoft/compui/contributors) who participated in this project.

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details
