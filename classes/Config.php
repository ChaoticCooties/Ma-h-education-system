<?php 
class Config {
	public static function get($path = null) {
		if($path) {
				$config = $GLOBALS['config'];
				$path = explode('/', $path);

				foreach($path as $bit) { //Fᴏʀ ᴇᴀᴄʜ ᴘᴀᴛʜ sᴇᴛ ᴀs $ʙɪᴛ
					if(isset($config[$bit])) { //Iꜰ ᴍʏsǫʟ ᴇxɪsᴛs ɪɴsɪᴅᴇ ᴄᴏɴꜰɪɢ, ᴛʜᴇɴ sᴇᴛ ᴄᴏɴꜰɪɢ ᴀs ᴍʏsǫʟ
						$config = $config[$bit]; //Iꜰ ʜᴏsᴛ ᴇxɪsᴛ ɪɴsɪᴅᴇ ᴄᴏɴꜰɪɢ, ᴄᴏɴꜰɪɢ = ʜᴏsᴛ(127.0.0.1)

					}
				}

				return $config; //ʀᴇᴛᴜʀɴs ᴛʜᴇ ᴄᴏɴꜰɪɢ ꜰʀᴏᴍ ᴀʙᴏᴠᴇ ^
		}

		return false; //ɪꜰ ᴅᴏᴇsɴ'ᴛ ᴇxɪsᴛ, ʀᴇᴛᴜʀɴ ꜰᴀʟsᴇ
	}
}