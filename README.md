# [Zipato API PHP Browser](https://github.com/Nikya/zipatoAPI_phpBrowser)

Version 2.0_1.0

*Abandoned projet!*

# What is it
A PHP browser to use the *Zipato web API V2*.

This is a basic structure to start more advanced personal implementations.

See also [Zipato Web API](https://my.zipato.com/zipato-web/api/)

# Installation
Clone the repo [zipatoAPI_phpBrowser](https://github.com/Nikya/zipatoAPI_phpBrowser)

# How to use
1. Rename the file *config_RENAME_ME.ini* to *config.ini*
1. Fill it with your *My Zipato* login
1. Fill it with your *My Zipato* sha1(password). See [PHP manual Sha1](http://php.net/manual/function.sha1.php)
1. Go to the *index* page with your browser and play with the examples
1. See how is works in :
    - `implementation/ExemplesServices.php`,
    - `core/ZipatoServices.php`
    - `core/ZipatoBrowser.php`
1. Now it only remains to use
  * Use already implemented Services (in `./implementation`)
  * or create your own implementations by extending the class `ZipatoService.php`
  * Load the class system by including `autoload.php` file

# Features
- Login : Manage login to the API
- List : List all devices, endpoints, attributes
- Read : Exemple to read a value : A temperature
- Switch : Change a value to On/Off a light

# Features to come
- Abandoned projet
