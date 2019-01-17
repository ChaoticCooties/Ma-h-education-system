<?php 
class DB {
	private static $_instance = null;
	private $_pdo, //ᴘᴅᴏ ᴏʙᴊᴇᴄᴛ
		 	$_query, //ʟᴀsᴛ ᴇxᴇᴄᴜᴛᴇᴅ ǫᴜᴇʀʏ
		 	$_error = false, //ᴇʀʀᴏʀ ᴏʀ ɴᴏᴛ
		 	$_results, //sᴛᴏʀᴇ ʀᴇsᴜʟᴛ sᴇᴛ
		 	$_count = 0; //ᴄᴏᴜɴᴛ ʀᴏᴡs

	private function __construct() {
		try { //ᴛʀʏ ᴄᴀᴛᴄʜ ʙʟᴏᴄᴋ
			$this->_pdo = new PDO('mysql:host=' . Config::get('mysql/host') . ';dbname=' . Config::get('mysql/db'), Config::get('mysql/username'), Config::get('mysql/password')); //ᴄᴏɴɴᴇᴄᴛ ᴛᴏ ᴘᴅᴏ ᴅʙ
		} catch(PDOException $e) {
			die($e->GetMessage()); //sᴇɴᴅ ᴏᴜᴛ ᴇxᴄᴇᴘᴛɪᴏɴ ɪꜰ ꜰᴀɪʟs
		}
	}

	public static function getInstance() {
		if(!isset(self::$_instance)) {
			self::$_instance = new DB(); //ɪꜰ ɴᴏ ᴅʙ ɪɴsᴛᴀɴᴄᴇ, ᴄʀᴇᴀᴛᴇ ɴᴇᴡ ᴏɴᴇ
		}
		return self::$_instance; //ᴇʟsᴇ ᴊᴜsᴛ ʀᴇᴛᴜʀɴ ᴘʀᴇsᴇɴᴛʟʏ ʀᴜɴɴɪɴɢ ɪɴsᴛᴀɴᴄᴇ
	}

	public function query($sql, $params = array()) { //ᴘʀᴇᴘᴀʀᴇ sᴛʀɪɴɢ ᴘᴀʀsᴇᴅ ᴛʜʀᴏᴜɢʜ
		$this->_error = false; //ʀᴇsᴇᴛ ᴛᴏ ᴘʀᴇᴠᴇɴᴛ ᴇʀʀᴏʀ ꜰʀᴏᴍ ᴘʀᴇᴠɪᴏᴜs ǫᴜᴇʀʏ
		if($this->_query = $this->_pdo->prepare($sql)) { //ɪꜰ ᴘʀᴇᴘᴀʀᴇᴅ sᴛᴀᴛᴇᴍᴇɴᴛ
			$x = 1;
			if(count($params)) {
				foreach($params as $param) {
					$this->_query->bindValue($x, $param); //ᴀssɪɢɴ ᴍᴜʟᴛɪᴘʟᴇ ᴘᴀʀᴀᴍs ᴛᴏ sᴜʙsᴇǫᴜᴇɴᴛ ? ᴍᴀʀᴋs
					$x++;
				}
			}

			if($this->_query->execute()) { //ɪꜰ ᴇxᴇᴄᴜᴛᴇᴅ, sᴜᴄᴄᴇss ᴏʀ ɴᴏᴛ
				$this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
				$this->_count = $this->_query->rowCount();
			} else{
				$this->_error = true; //ᴇʟsᴇ, ʀᴇᴛᴜʀɴ ᴇʀʀᴏʀ
			}

		}

		return $this; //return

	}

	public function action($action, $table, $where = array()) { //ǫᴜᴇʀʏɪɴɢ
		if(count($where) === 3) {
			$operators = array('=', '>', '<', '>=', '<='); 		//ᴅᴇꜰɪɴᴇ ᴏᴘᴇʀᴀᴛᴏʀs

			$field 		= $where[0]; //1sᴛ ᴀʀɢᴜᴍᴇɴᴛ - ꜰɪᴇʟᴅ
			$operator 	= $where[1]; //2ɴᴅ ᴀʀɢᴜᴍᴇɴᴛ - ᴏᴘᴇʀᴀᴛᴏʀ
			$value 		= $where[2]; //3ʀᴅ ᴀʀɢᴜᴍᴇɴᴛ - ᴠᴀʟᴜᴇ

			if(in_array($operator, $operators)) { 	//ɪꜰ $ᴏᴘᴇʀᴀᴛᴏʀ ɪɴ ᴏᴘᴇʀᴀᴛᴏʀs
				$sql = "{$action} FROM {$table} WHERE {$field} {$operator} ?"; 	//sᴘᴇᴄɪꜰʏɪɴɢ ǫᴜᴇʀʏ ꜰᴏʀᴍᴀᴛ

				if(!$this->query($sql, array($value))->error()) {	//ǫᴜᴇsᴛɪᴏɴ ᴍᴀʀᴋ $ᴠᴀʟᴜᴇ
					return $this;
				}
			}
		}
		return false;
	}

	public function get($table, $where) {
		return $this->action('SELECT *', $table, $where); 	//get feature
	}

	public function delete($table, $where) {
		return $this->action('DELETE', $table, $where); 	//delete feature
	}

	public function insert($table, $fields = array()) {		//insert feature
		$keys = array_keys($fields);
		$values = '';
		$x = 1;

		 //ʀᴇᴀsᴏɴ ᴡʜʏ ɴᴏᴛ '? ,' ɪs ʙᴇᴄᴀᴜsᴇ ᴛʜᴇ ʟᴀsᴛ ꜰɪᴇʟᴅ ᴡɪʟʟ ʜᴀᴠᴇ ᴀ ᴄᴏᴍᴍᴀ ɪꜰ ᴅᴏɴᴇ ᴍᴇɴᴛɪᴏɴᴇᴅ ᴡᴀʏ
		foreach($fields as $field) { //ʟᴏᴏᴘ ᴛʜʀᴜ ꜰɪᴇʟᴅs 
			$values .= '?';
			if($x < count($fields)) { //ᴄʜᴇᴄᴋ ɪꜰ ᴇɴᴅ ᴏꜰ ʟᴏᴏᴘ
				$values .= ', '; //ᴘʟᴀᴄᴇ ᴄᴏᴍᴍᴀs ʙᴇᴛᴡᴇᴇɴ
			}
			$x++;
		}

		//results should be "INSERT INTO users (`field1`,`field2`,`field3`)"
		$sql = "INSERT INTO {$table} (`" . implode('`,`', $keys) . "`) VALUES ({$values})";

		if(!$this->query($sql, $fields)->error()) {
			return true;
		}
		return false;
	}

	public function update($table, $id, $fields) { //ᴜᴘᴅᴀᴛᴇ ꜰᴇᴀᴛᴜʀᴇ
		$set = '';
		$x = 1;

		foreach(array_keys($fields) as $name) {
			$set .= "{$name} = ?";
			if($x < count($fields)) {	
				$set .= ', ';
			} 
			$x++;
		}

		$sql = "UPDATE {$table} SET {$set} WHERE id = {$id}";

		if(!$this->query($sql, $fields)->error()) { //ɪꜰ ɴᴏ ᴇʀʀᴏʀs ʀᴇᴛᴜʀɴᴇᴅ
			return true;
		}

		return false;
	}

	public function results() {
		return $this->_results;			//ʀᴇᴛᴜʀɴ ʀᴇsᴜʟᴛs
	}

	public function first() {
		return $this->results()[0]; 	//ʀᴇᴛᴜʀɴ ꜰɪʀsᴛ ʀᴇsᴜʟᴛ
	}

	public function error() {
		return $this->_error; 			//ʀᴇᴛᴜʀɴ ᴇʀʀᴏʀ
	}

	public function count() {
		return $this->_count; 			//ʀᴇᴛᴜʀɴ ᴄᴏᴜɴᴛ
	}

}