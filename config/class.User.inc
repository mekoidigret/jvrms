<?php
	class User {
		public $id;
		public $username;
		public $password;
		public $access_level;

		const TABLE_NAME = 'users';

		public function __construct($data = array()) {
			foreach($data as $property => $value) {
				if(property_exists($this, $property)) {
					$this->$property = $value;
				}
			}
			$this->access_level = static::LEVEL;
			return $this;
		}

		public static function authenticate($username, $password) {
			global $db;
			$output = array(
				'status' => false
			);
			$user = $db->search(self::TABLE_NAME, array('username' => $username), 'fetch');
			if($user) {
				if(password_verify($password, $user[0]['password'])) {
					$output['status'] = true;
					$output['message'] = 'Logged in successfully.';
					$data;
					switch($user[0]['access_level']) {
						case Visitor::LEVEL:
							$data = new Visitor($user[0]);
							break;
						case Officer::LEVEL:
							$data = new Officer($user[0]);
							break;
						case Admin::LEVEL:
							$data = new Admin($user[0]);
							break;
					}
					$output['data'] = $data;
					return $output;
				}
				else {
					$output['message'] = 'Wrong password.';
					return $output;
				}
			}
			else {
				$output['message'] = 'Username not found.';
				return $output;
			}
		}

		public static function findAll($pagination) {
			global $db;
			$sql = 'SELECT * FROM '.self::TABLE_NAME.' '
				. 'WHERE access_level = '.static::LEVEL.' ';
			if($_SESSION['user_access_level'] == Admin::LEVEL) {
				$sql .= 'AND id NOT IN ('.$_SESSION['user_id'].') ';
			}
			$sql .= 'LIMIT '.$pagination->per_page.' '
				 .  'OFFSET '.$pagination->offset();
			$result = $db->query($sql);
			if($result->rowCount() > 0) {
				$object_array = array();
				$class = get_called_class();
				while($row = $result->fetch(PDO::FETCH_ASSOC)) {
					$object_array[] = new $class($row);
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

		private function create() {
			global $db;
			$sql = 'SELECT * FROM '.self::TABLE_NAME.' '
				. 'WHERE username = '.$db->quote($this->username);
			if($db->query($sql)->rowCount() == 0) {
				$params = array(
					'username' => $this->username,
					'password' => password_hash($this->password, PASSWORD_DEFAULT),
					'access_level' => $this->access_level
				);
				return $db->insert(self::TABLE_NAME, $params);
			}
			else {
				return false;
			}
		}

		private function update() {
			global $db;
			$sql = 'SELECT * FROM '.self::TABLE_NAME.' '
				. 'WHERE username = '.$db->quote($this->username).' '
				. 'AND id NOT IN ('.$this->id.')';
			if($db->query($sql)->rowCount() == 0) {
				$params = array(
					'username' => $this->username,
					'password' => password_hash($this->password, PASSWORD_DEFAULT),
					'access_level' => $this->access_level
				);
				$ids = array('id' => $this->id);
				return $db->update(self::TABLE_NAME, $params, $ids);
			}
			else {
				return false;
			}
		}
	}