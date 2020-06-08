<?php

    namespace TheLogicStudio\MapField;

    use SilverStripe\UserForms\Model\Submission\SubmittedFormField;

    /**
     * A Map Polygon uploaded on a {@link UserDefinedForm} and attached to a single
     * {@link SubmittedForm}.
     *
     * @package userforms
     */

    class SubmittedMapField extends SubmittedFormField
    {
        private static $has_one = [
            'MapPolygon' => MapPolygon::class
        ];

        private static $table_name = 'SubmittedMapField';

        public function __construct($record = null, $isSingleton = false, $queryParams = []) {
             parent::__construct($record, $isSingleton, $queryParams);
        }

        /**
         * Return the value of this field for inclusion into things such as
         * reports.
         *
         * @return string
         */
        public function getFormattedValue()
        {

            return $this->dbObject('Value');
        }

        /**
         * Return the value for this field in the CSV export.
         *
         * @return string
         */
        public function getExportValue()
        {
            return '';
        }
    }
