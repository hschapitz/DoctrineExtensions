<?php
namespace DoctrineExtensions\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

/**
 * Type that maps an SQL LONGBLOB to a string.
 */
class LongBlobType extends Type
{
	const LONG_BLOB = 'longblob';

	public function getName()
	{
		return self::LONG_BLOB;
	}

	public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
	{
		return $platform->getBlobTypeDeclarationSQL($fieldDeclaration);
	}

	public function convertToDatabaseValue($value, AbstractPlatform $platform)
	{
		return ($value === null) ? null : base64_encode($value);
	}

	public function convertToPHPValue($value, AbstractPlatform $platform)
	{
		return ($value === null) ? null : base64_decode($value);
	}
}