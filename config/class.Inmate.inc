<?php
	
	class Inmate {
		public $id;
		public $first_name;
		public $last_name;
		public $gender;
		public $cell_number;

		const TABLE_NAME = 'inmates';

		public function __construct($data = array())  {
			foreach($data as $property => $value) {
				if(property_exists($this, $property)) {
					$this->$property = $value;
				}
			}
			return $this;
		}

		public static function findAll($pagination) {
			global $db;
			$sql = 'SELECT * FROM '.self::TABLE_NAME.' '
				. 'ORDER BY gender DESC, cell_number ASC '
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

		public function save() {
			return !$this->id ? $this->create() : $this->update();
		}

		public function create() {
			global $db;
			$params = array(
				'first_name' => $this->first_name,
				'last_name' => $this->last_name,
				'gender' => $this->gender,
				'cell_number' => $this->cell_number
			);
			return $db->insert(self::TABLE_NAME, $params);
		}

		public function update() {
			global $db;
			$params = array(
				'first_name' => $this->first_name,
				'last_name' => $this->last_name,
				'gender' => $this->gender,
				'cell_number' => $this->cell_number
			);
			$ids = array('id' => $this->id);
			return $db->update(self::TABLE_NAME, $params, $ids);
		}

		public function getFullName() {
			return htmlentities($this->last_name.', '.$this->first_name);
		}

		public static function findByID($id) {
			global $db;
			$sql = 'SELECT * FROM '.self::TABLE_NAME.' '
				. 'WHERE id = '.$id;
			$result = $db->query($sql);
			if($result->rowCount() > 0) {
				return new self($result->fetch(PDO::FETCH_ASSOC));
			}
			else {
				return null;
			}
		}
	}