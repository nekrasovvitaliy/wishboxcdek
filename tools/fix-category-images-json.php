<?php

$sourceFile = '/Users/user/.codex/attachments/7e35f391-d097-4ce9-b538-aff6a4f5d371/pasted-text.txt';
$imageDir   = '/Users/user/Documents/playandlearn.ru/category_images';
$targetFile = __DIR__ . '/../category_images_fixed.json';

$json = file_get_contents($sourceFile);

if ($json === false)
{
	fwrite(STDERR, "Cannot read source file\n");
	exit(1);
}

$categories = json_decode($json, false, 512, JSON_THROW_ON_ERROR);

foreach ($categories as $category)
{
	$image = $category->image ?? '';

	if ($image === '')
	{
		continue;
	}

	$image = basename($image);
	$imagePath = $imageDir . '/' . $image;

	if (!is_file($imagePath))
	{
		fwrite(STDERR, "Image not found: {$image}\n");
		continue;
	}

	$size = getimagesize($imagePath);

	if ($size === false)
	{
		fwrite(STDERR, "Cannot read image size: {$image}\n");
		continue;
	}

	$joomlaPath = 'category_images/' . $image;

	$category->image = sprintf(
		'images/%s#joomlaImage://local-images/%s?width=%d&height=%d',
		$joomlaPath,
		$joomlaPath,
		$size[0],
		$size[1]
	);
}

$encoded = json_encode(
	$categories,
	JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
);

$encoded = str_replace('/', '\\/', $encoded);

file_put_contents($targetFile, $encoded . "\n");

echo $targetFile . "\n";
