<?php
    namespace TheLogicStudio\MapField;

    use SilverStripe\Core\Injector\Injector;
    use SilverStripe\Forms\FormField;
    use SilverStripe\ORM\DataObject;
    use SilverStripe\ORM\DataObjectInterface;
    use SilverStripe\View\Requirements;

    class MapField extends FormField {
        /**
         * @var int
         */
        protected $recordID = null;

        protected $schemaDataType = FormField::SCHEMA_DATA_TYPE_CUSTOM;

        protected $schemaComponent = 'MapField';

        protected $inputType = 'hidden';

        protected $Latitude = 0;
        protected $Longitude = 0;

        /**
         * Create a new file field.
         *
         * @param string $name The internal field name, passed to forms.
         * @param string $title The field label.
         * @param int $value The value of the field.
         */
        public function __construct($name, $title = null, $value = null)
        {
            $key = $this->config()->get('google_maps_key');
            Requirements::javascript('https://maps.google.com/maps/api/js?libraries=drawing&key='.$key);
            Requirements::javascript('thelogicstudio/mapfield:client/dist/js/bundle.js');
            Requirements::css('thelogicstudio/mapfield:client/dist/styles/bundle.css');
            parent::__construct($name, $title, $value);
        }

        public function setDefaultLatLong($Latitude, $Longitude) {
            $this->Latitude = $Latitude;
            $this->Longitude = $Longitude;
        }

        /**
         * @return DataObject
         */
        public function getRecord()
        {
            if ($this->recordID) {
                return DataObject::get_by_id(MapPolygon::class, $this->recordID);
            }
            return null;
        }

        /**
         * @param Integer $recordID
         * @return $this
         */
        public function setRecordID($recordID)
        {
            $this->recordID = $recordID;
            return $this;
        }
    }
