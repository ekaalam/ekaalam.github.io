<?php
    final class Advertisement extends Database{
        use DataTraits;
        public function __construct()
        {
            Database:: __construct();
            $this ->table = 'advertisements';
        }
        public function getAdvertisementByPosition($posn){
            //id, titile, image, link, status, start_date, end_date, Postion => date
            $today = date("Y-m-d");
            $args = array(
                'where' => "status = 'active' AND position ='".$posn."' AND start_date <= '".$today."' AND end_date >= '".$today."'",
                'limit' => "0,1"
            );
            return $this->select($args);
        }
    }
