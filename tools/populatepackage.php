<?php

// usage:
// 	populatepackage.php <build.properties> <package.xml> <srcfiles dir>
//
// 	where
// 		<build.properties> is a Phing build.properties file
//
// 		<package.xml file> is the package.xml file that needs
// 		to be expanded / populated
//
// 		<srcfiles dir> is the directory containing the PHP
// 		scripts that we want to install
//
// =======================================================================

if (empty($argv[3]))
{
	echo "usage: " . $argv[0] . " <build.properties> <package.xml> <srcdir>\n";
	exit(1);
}

// can we load the build.properties file?
if (!file_exists($argv[1]))
{
	echo "*** error: " . $argv[1] . " not found; was expending a build.properties file\n";
	exit(1);
}

if (!is_readable($argv[1]))
{
	echo "*** error: " . $argv[1] . " cannot be read. File permissions problem?\n";
	exit(1);
}

// can we load the package.xml file?
if (!file_exists($argv[2]))
{
	echo "*** error: " . $argv[2] . " not found; was expecting a package.xml file\n";
	exit(1);
}

if (!is_readable($argv[2]))
{
	echo "*** error: " . $argv[2] . " cannot be read. File permissions problem?\n";
	exit(1);
}

if (!is_writable($argv[2]))
{
	echo "*** error: " . $argv[2] . " cannot be written to. File permissions problem?\n";
	exit(1);
}

// if we get here, then we have a file that we can read from and write to
// let's get it loaded

$rawBuildProperties = parse_ini_file($argv[1]);
$rawXml = file_get_contents($argv[2]);

// translate the raw properties into the tokens we support
$buildProperties = array();
foreach ($rawBuildProperties as $name => $value)
{
	$buildProperties['${' . $name . '}'] = $value;
}

// let's build up the list of tokens to replace
$buildProperties['${build.date}'] = date('Y-m-d');
$buildProperties['${build.time}'] = date('H:i:s');

$contents = '';

// now for the file contents
$objects = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($argv[3]));
foreach ($objects as $name => $direntry)
{
	// skip entries for current and parent directories
	if ($direntry->getFilename() == '.' || $direntry->getFilename() == '..')
		continue;

	// skip all directories
	if ($direntry->isDir())
		continue;

	$filename = str_replace($argv[3], '', $direntry->getPathname());
	var_dump($filename);
	$contents .= '      <file baseinstalldir="/" md5sum="' . md5(file_get_contents($direntry->getPathname())) . '" name="' . $filename . '" role="php" />' . "\n";
}
$buildProperties['${contents}'] = $contents;

var_dump($buildProperties);

// do the replacement
$newXml = str_replace(array_keys($buildProperties), $buildProperties, $rawXml);

// write out the package.xml file
file_put_contents($argv[2], $newXml);
