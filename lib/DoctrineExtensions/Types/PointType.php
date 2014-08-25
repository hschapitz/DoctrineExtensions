<?php
namespace DoctrineExtensions\Types;

use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use DoctrineExtensions\Spatial\Point;

class PointType extends Type {

	const POINT = 'POINT';

	public function getName()
	{
		return self::POINT;
	}

	public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform) {
		return $platform->getDoctrineTypeMapping('VARBINARY');
	}

	public function convertToPHPValue($value, AbstractPlatform $platform) {
        //Null fields come in as empty strings
        if($value == '') {
            return null;
        }
 
        $data = unpack('x/x/x/x/corder/Ltype/dlat/dlon', $value);
        return new Point($data['lat'], $data['lon']);
    }
 
    public function convertToDatabaseValue($value, AbstractPlatform $platform) {
        if (!$value) return;
 
        return pack('xxxxcLdd', '0', 1, $value->getLatitude(), $value->getLongitude());
    }

}
