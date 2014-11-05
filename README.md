# Org_Heigl\FileFinder

[![Build Status](https://travis-ci.org/heiglandreas/OrgHeiglFileFinder.svg?branch=master)](https://travis-ci.org/heiglandreas/OrgHeiglFileFinder)
[![Code Climate](https://codeclimate.com/github/heiglandreas/OrgHeiglFileFinder/badges/gpa.svg)](https://codeclimate.com/github/heiglandreas/OrgHeiglFileFinder)

This library allows to iterate through a number of folders and filter the list of files. The files are returned in a filelist-object.

## Installation

Org_Heigl\FileFinder is installed via composer. Call ```composer require org_heigl/filefinder``` from the commandline in your project.

Alternatively you can include the following line in your ```composer.json``` inside the ```require```-section:

    "org_heigl/filefinder" : "stable"

## Usage

Simplest usage would be to add a filter to the FileFinder as well as a directory.

```php
$finder = new \Org_Heigl\FileFinder\FileFinder();
$finder->addFilter(new \Org_Heigl\FileFinder\Filter\FileExtension('jpg'));
$finder->addDirectory($dir);
$list = $finder->find();
// $list will be an \Org_Heigl\FileFinder\FileList-Object containing all Files with the extension 'jpg' inside ```$dir```
```

You can also set your own ```FileList```-Object as long as it implements
```\Org_Heigl\FileFinder\FileListInterface```. That would then look like this:

```php
$finder = new \Org_Heigl\FileFinder\FileFinder();
$finder->addFilter(new \Org_Heigl\FileFinder\Filter\FileExtension('jpg'));
$finder->addDirectory($dir);
$finder->setFileList(new MyPrettyFileList())
$list = $finder->find();
// $list will be the MyPrettyFileList-Object containing all Files with the extension 'jpg' inside ```$dir```
```

The directories added with the ```FileList::addDirectory()```-method will be recursively checked.

The filters have to implement ```\Org_Heigl\FileFinder\FilterInterface```. Therefore you can add your own filters very easily.

## Contains

Currently the library contains the following filters:

* **FileExtension** - A filter to check whether the files extension is one of a given number of extensions. The list of extensions if given to the constructor like so: ```new FileExtension(array('foo', 'bar'))```.
* **fileStart** - A filter that checks whether the files content starts with the given string. This filter is invoked like this: ```new FileStart('<?php')``` to check for a PHP-file.
## License

This library is licensed under the MIT-License as found in the [LICENSE](LICENSE)-File.

## Issues

You have an issue? Use the [Issuetracker](https://github.com/heiglandreas/OrgHeiglFileFinder/issues) to report it and we'll see for it.

## Contributing

Contributions are always welcome. Fork the repo, do whatever you like and open a pull request!

