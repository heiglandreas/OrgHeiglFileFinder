# Org_Heigl\FileFinder

[![Build Status](https://travis-ci.org/heiglandreas/OrgHeiglFileFinder.svg?branch=master)](https://travis-ci.org/heiglandreas/OrgHeiglFileFinder)
[![Code Climate](https://codeclimate.com/github/heiglandreas/OrgHeiglFileFinder/badges/gpa.svg)](https://codeclimate.com/github/heiglandreas/OrgHeiglFileFinder)
[![Test Coverage](https://codeclimate.com/github/heiglandreas/OrgHeiglFileFinder/badges/coverage.svg)](https://codeclimate.com/github/heiglandreas/OrgHeiglFileFinder)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/heiglandreas/OrgHeiglFileFinder/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/heiglandreas/OrgHeiglFileFinder/?branch=master)

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

You can also get a mapping of classname to filename for all classes implementing ```\Iterator``` underneath the directory ```$dir``` using this snippet:

```php
$finder = new \Org_Heigl\FileFinder\FileFinder();
$finder->addFilter(new \Org_Heigl\FileFinder\Filter\FileExtension('php'));
$finder->addFilter(new \Org_Heigl\FileFinder\Filter\ClassIsInstanceof('\Iterator'));
$finder->setFileList(new \Org_Heigl\FileFinder\ClassMapList());
$finder->addDirectory($dir);
$list = $finder->find();
// $list now contains the classname as key and the filepath as value
```

The directories added with the ```FileList::addDirectory()```-method will be recursively checked.

The filters have to implement ```\Org_Heigl\FileFinder\FilterInterface```. Therefore you can add your own filters very easily.

The default ```FileList```-implementation also contains a ```sort```-method that
allows sorting the filelist before using it. Just provide an implementation of the
```SortInterface``` as argument like this:

```php
$finder = new \Org_Heigl\FileFinder\FileFinder();
$finder->addDirectory($dir);
$list = $finder->find();
$list->sort(new \Org_Heigl\FileFinder\Sorter\MTime());
// $list now is sorted by MTime ascending.
```


## Contains

Currently the library contains the following filters:

* **FileExtension** - A filter to check whether the files extension is one of a given number of extensions. The list of extensions if given to the constructor like so: ```new FileExtension(array('foo', 'bar'))```.
* **FileStart** - A filter that checks whether the files content starts with the given string. You could use it like this: ```new FileStart('<?php')``` to check for a PHP-file.
* **ClassIsInstanceOf** - A filter to check whether the file contains a class that implements at least one of the looked for Interfaces. The interfaces can be given like this: ```new ClassIsInstanceOf(['InterfaceOne','\Org_Heigl\FileFinder\FilterInterface']);```. 
* **DateCompare** - A filter that compares the files create-, modification- or alter-date with the given date. Comparison can be either before, after or equals. So it can be invoked like this: ```new DateCompare(new DateTime(), DateCompare::MTIME, DateCompare::CHECK_BEFORE);```. That will include files whose content has been altered before the current date (which schould include everything(-; )
* **FileSize** - Find files with a filesize within the given range: It can be used like this: ```new FileSize('1kb', '2gb');``` which will find files between 1kB and 2GB in size. 
* **HoldsSinglePHPClass** - Find files that old only one class. Files with more than one class will be ommited.
* **MimeType** - Find files of a certain mime-Type. You can use it like this: ```$finfo = new \Org_Heigl\FileFinder\Service\FinfoWrapper();
  $filter = new MimeType($finfo, 'application/pdf');```
  That will find all PDF-files. This filter requires a FinfoWrapper-Object as first object that will handle the actual mime-type detection.
* **Not** - Negate the contained filters.
* **OrList** - Holds a number of filters where only one needs to match to include the file in the list.

## License

This library is licensed under the MIT-License as found in the [LICENSE](LICENSE)-File.

## Issues

You have an issue? Use the [Issuetracker](https://github.com/heiglandreas/OrgHeiglFileFinder/issues) to report it and we'll see for it.

## Contributing

Contributions are always welcome. Fork the repo, do whatever you like and open a pull request!

