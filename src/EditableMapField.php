<?php
    namespace TheLogicStudio\MapField;

    use SilverStripe\Forms\FormField;
    use SilverStripe\Forms\TextField;
    use SilverStripe\UserForms\Model\EditableFormField;

    class EditableMapField extends EditableFormField
    {
        private static $singular_name = 'Map Field';

        private static $plural_name = 'Map Fields';

        private static $has_placeholder = false;

        private static $table_name = 'MapField';

        private static $db = [
            'Latitude'  => 'Decimal(12,9)',
            'Longitude' => 'Decimal(12,9)',
        ];

        private static $defaults = [
            'Rows' => 1
        ];

        public function getCMSFields()
        {
            $fields = parent::getCMSFields();
            $fields->removeByName('Default');


            $fields->addFieldsToTab(
                'Root.Main',
                [
                    TextField::create('Latitude', _t(__CLASS__.'.DEFAULT', 'Initial Latitude')),
                    TextField::create('Longitude', _t(__CLASS__.'.DEFAULT', 'Initial Longitude')),
                ]
            );

            return $fields;
        }

        /**
         * @return FormField
         */
        public function getFormField()
        {
            $field = MapField::create($this->Name);
            $field->setDefaultLatLong($this->Latitude, $this->Longitude);

            $this->doUpdateFormField($field);

            return $field;
        }

        /**
         * Updates a formfield with the additional metadata specified by this field
         *
         * @param FormField $field
         */
        protected function updateFormField($field)
        {
            parent::updateFormField($field);

        }

        public function getSubmittedFormField()
        {
            return SubmittedMapField::create();
        }

        /**
         * Return the value for the database, link to the file is stored as a
         * relation so value for the field can be null.
         *
         * @return string
         */
        public function getValueFromData()
        {
            return null;
        }
    }
