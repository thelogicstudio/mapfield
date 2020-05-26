<?php
    namespace TheLogicStudio\MapField;

    use SilverStripe\ORM\DataObject;

    class MapPolygon extends DataObject {
        
        private static $db = [
            'Active'  => 'Boolean',
        ];
        
        private static $defaults = [
            'Active'  => true
        ];
        
        private static $has_many = [
            'LatLongs' => LatLong::class,
        ];

        private static $table_name = 'MapPolygon';

        private static $cascade_deletes = [
            'LatLongs',
        ];
    }
