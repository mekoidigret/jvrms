<?php

	class Visit {
		public $id;
		public $inmate_id;
		public $date;
		public $time_in;
		public $time_out;
		public $visitor_name;
		public $contact_number;

		const TABLE_NAME = 'visits';

		public function __construct($data = array()) {
			foreach($data as $property => $value) {
				if(property_exists($this, $property)) {
					$this->$property = $value;
				}
			}
			return $this;
		}

		public function save() {
			global $db;
			$params = array(
				'inmate_id' => $this->inmate_id,
				'time_in' => $this->time_in,
				'time_out' => $this->time_out,
				'visitor_name' => $this->visitor_name,
				'contact_number' => $this->contact_number 
			);
			return $db->insert(self::TABLE_NAME, $params);
		}

		public static function findAll($pagination) {
			global $db;
			$sql = 'SELECT * FROM '.self::TABLE_NAME.' '
				. 'ORDER BY date DESC '
				. 'LIMIT '.$pagination->per_page.' '
				. 'OFFSET '.$pagination->offset();
			$result = $db->query($sql);
			if($result->rowCount() > 0) {
				$object_array = array();
				while($row = $result->fetch(PDO::FETCH_ASSOC)) {
					$object_array[] = new self($row);
				}
				return $object_array;
			}
			else {
				return null;
			}
		}

		public function getDate() {
			$date = new DateTime($this->date);
			return $date->format('F d, Y');
		}

		public function getTimeIn() {
			$time = new DateTime($this->time_in);
			return $time->format('h:i A');
		}

		public function getTimeOut() {
			$time = new DateTime($this->time_out);
			return $time->format('h:i A');
		}


		public function getInmateName() {
			return Inmate::findByID($this->inmate_id)->getFullName();
		}
	}