<?php
    namespace TheLogicStudio\MapField;

    use SilverStripe\ORM\DataObject;

    class LatLong extends DataObject {
        private static $db = [
            'Latitude'  => 'Decimal(12,9)',
            'Longitude' => 'Decimal(12,9)',
            'Order'     => 'Int',
        ];

        private static $has_one = [
            'MapPolygon' => MapPolygon::class,
        ];

        private static $table_name = 'MapLatLong';
    }
