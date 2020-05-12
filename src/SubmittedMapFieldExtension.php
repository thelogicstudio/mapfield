<?php
    namespace TheLogicStudio\MapField;

    use SilverStripe\Control\Controller;
    use SilverStripe\ORM\DataExtension;

    class SubmittedMapFieldExtension extends DataExtension {
        function onPopulationFromField($field) {
            $polygon = MapPolygon::create();

            $value = Controller::curr()->getRequest()->postVar($field->Name);
            $value = preg_replace('~[^0-9\.,;\-]~', '', $value);
            $value = explode(';', $value);
            foreach($value as $i => $item) {
                $item = explode(',', $item);
                $latlng = LatLong::create();
                $latlng->Latitude = $item[0];
                $latlng->Longitude = $item[1];
                $latlng->Order = $i;
                $latlng->write();
                $polygon->LatLongs()->add($latlng);
            }
            $polygon->write();
            $this->owner->MapPolygonID = $polygon->ID;
        }
    }
