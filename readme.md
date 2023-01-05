# Concept Library
## The framework for generate code 

[![N|Solid](https://img.shields.io/badge/concept-beta--version-blue?style=for-the-badge)](https://nodesource.com/products/nsolid)

![Build Status](https://img.shields.io/badge/asd-daniel-brightgreen?style=flat-square)

Concept is a framework for generate code with a json config file.
the framework is built in php for the moment, but aims to be built in different programming languages, the author is counting on the contributors to build a new way of designing applications by gaining productivity while focusing on the conceptual aspects.
## Features
The framework is based on the following concepts:
- creation of commands to generate codes
- exploitation of configuration files in json
- Generating of code and template of application following a json config file

## License 
GNU General Public License (GPL) version 2

## Getting started

concept is based on the creation of application templates that can be generated according to customizable configurations by each developer. in this version ***Daniel Assani*** has created a laravel api template. if you are interested, you can contribute by adding another application template or by improving the existing templates

> to start using the framework you must clone or fork the example project on github 
you must start by cloning the starter project on github, this project contains all the elements necessary to load and use the base library that will generate your application.  this starter project only contains the tools needed to generate the Laravel api application template
the link for the repository is [here](https://github.com/asddaniel/concept-start.git)

    git clone https://github.com/asddaniel/concept-start.git
then you must install the basic package containing all the dependency libraries


    composer require asddaniel/concept

> once install the next  step is to use basic commands to generate your application. the startup project contains a folder named manifest, you will find there a file named LaravelManifest.json, all the configuration of your application must be written in this file, the program will interpret the data above in order to generate the application
## Commands and uses
the example configuration file contains an example of the minimal configuration to be done. all parameters are optional, but the data format must be respected to guarantee a functional application
> example config file 
> { "name":"AppLaravel", "finalize":"true", "output_dir":  "test2", 
> "database":{ "db_name":"test", "username":"root", "password":"" },
> "models":{
> "Article":{"attributes":
> {"title":"string",  "content":  "string",  "onLine":"boolean"}, 
> "fillable":["title",  "content"]	},       }           }

once the file is configured you can start the command
if you are under windows start the command with the word ***execute***

    execute

the command Line will ask you to enter a command then you must give : 

    create laravel-api

if you are under linux or Mac start only the phpcommand (you must ensure that php is installed and it is present in the path whether you are under windows or linux)

    phpcomand create laravel-api

if you have correctly filled your configuration file in json and you have chosen to start the application immediately, the whole application will be generated and you can already go to the browser and test the api endpoints under localhost and port 8000