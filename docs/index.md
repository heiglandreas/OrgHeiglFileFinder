# Org_Heigl\FileFinder

[![Build Status](https://travis-ci.org/heiglandreas/OrgHeiglFileFinder.svg?branch=master)](https://travis-ci.org/heiglandreas/OrgHeiglFileFinder)
[![Code Climate](https://codeclimate.com/github/heiglandreas/OrgHeiglFileFinder/badges/gpa.svg)](https://codeclimate.com/github/heiglandreas/OrgHeiglFileFinder)
[![Test Coverage](https://codeclimate.com/github/heiglandreas/OrgHeiglFileFinder/badges/coverage.svg)](https://codeclimate.com/github/heiglandreas/OrgHeiglFileFinder)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/heiglandreas/OrgHeiglFileFinder/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/heiglandreas/OrgHeiglFileFinder/?branch=master)

This library allows to find files from the filesystem that apply to a set of filter-rules. The files are returned in a filelist-object.

## Installation

Org_Heigl\FileFinder is installed via composer. Call ```composer require org_heigl/filefinder``` from the commandline in your project.

Alternatively you can include the following line in your ```composer.json``` inside the ```require```-section:

    :::json
    "org_heigl/filefinder" : "stable"

## Usage

Simplest usage would be to add a filter to the FileFinder as well as a directory.

```php
<?php
$finder = new \Org_Heigl\FileFinder\FileFinder();
$finder->addFilter(new \Org_Heigl\FileFinder\Filter\FileExtension('jpg'));
$finder->addDirectory($dir);
$list = $finder->find();
// $list will be an \Org_Heigl\FileFinder\FileList-Object containing all Files with the extension 'jpg' inside $dir
```

You can also set your own ```FileList```-Object as long as it implements
```\Org_Heigl\FileFinder\FileListInterface```. That would then look like this:

    :::php
    <?php
    $finder = new \Org_Heigl\FileFinder\FileFinder();
    $finder->addFilter(new \Org_Heigl\FileFinder\Filter\FileExtension('jpg'));
    $finder->addDirectory($dir);
    $finder->setFileList(new MyPrettyFileList())
    $list = $finder->find();
    // $list will be the MyPrettyFileList-Object containing all Files with the extension 'jpg' inside ```$dir```

You can also get a mapping of classname to filename for all classes implementing ```\Iterator``` underneath the directory ```$dir``` using this snippet:

    :::php
    <?php
    $finder = new \Org_Heigl\FileFinder\FileFinder();
    $finder->addFilter(new \Org_Heigl\FileFinder\Filter\FileExtension('php'));
    $finder->addFilter(new \Org_Heigl\FileFinder\Filter\ClassIsInstanceof('\Iterator'));
    $finder->setFileList(new \Org_Heigl\FileFinder\ClassMapList());
    $finder->addDirectory($dir);
    $list = $finder->find();
    // $list now contains the classname as key and the filepath as value

The directories added with the ```FileList::addDirectory()```-method will be recursively checked.

The filters have to implement ```\Org_Heigl\FileFinder\FilterInterface```. Therefore you can add your own filters very easily.

## Contains

Currently the library contains the following filters and lists:

### Filters

* [FileExtension](filters/fileExtension.md)
* [FileStart](filters/fileStart.md)
* [HoldsSinglePHPClass](filters/holdsSinglePHPClass.md)
* [DateCompare](filters/dateCompare.md)
* [ClassIsInstanceof](filters/classIsInstanceOf.md)
* [FileSize](filters/fileSize.md)

### Lists

* [FileList]( lists/fileList.md)
* [ClassMapList](lists/classMapList.md)

### Interfaces

### Helpers

## License

This library is licensed under the [MIT-License](http://opensource.org/licenses/MIT).

## Issues

You have an issue? Use the [Issuetracker](https://github.com/heiglandreas/OrgHeiglFileFinder/issues) to report it and we'll see for it.
