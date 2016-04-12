<?php

    namespace LocalFeud\Helpers;

    class Location {
        private
            $latitude,
            $longitude;

        // Coordinates has be in degrees
        public function __construct($latitude, $longitude) {
            $this->latitude = $latitude;
            $this->longitude = $longitude;
        }


        public function distanceTo( Location $there ) {
            $R = 6371000;

            $phi_1 = deg2rad($this->latitude);
            $phi_2 = deg2rad($there->getLatitude());

            $delta_lat = deg2rad($there->getLatitude() - $this->latitude);
            $delta_lon = deg2rad($there->getLongitude() - $this->longitude);

            $a = sin( $delta_lat / 2) * sin( $delta_lon / 2) +
                cos($phi_1) * cos($phi_2) *
                sin($delta_lon / 2) * sin($delta_lat / 2);

            $c = 2 * atan2( sqrt( $a ), sqrt( 1 - $a ));

            $d = $R * $c;

            return $d;
        }


        public function getLatitude() {
            return $this->latitude;
        }

        public function getLongitude() {
            return $this->longitude;
        }
    }