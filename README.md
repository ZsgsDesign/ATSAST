# ATSAST
Auxiliary Teaching for SAST

## Install
Create a new php file named CONFIG.php in /protected/model/ and insert:
```
<?php

class CONFIG {
	
	/**
	 * CONFIG
	 *
	 * @author John Zhang
	 * @param string $KEY
	 */

	public static function GET($KEY)
	{
		$config=array(
			"ATSAST_DEBUG_MYSQL_HOST"=>"",
			"ATSAST_DEBUG_MYSQL_PORT"=>"",
			"ATSAST_DEBUG_MYSQL_USER"=>"",
			"ATSAST_DEBUG_MYSQL_DATABASE"=>"",
			"ATSAST_DEBUG_MYSQL_PASSWORD"=>"",

			"ATSAST_MYSQL_HOST"=>"",
			"ATSAST_MYSQL_PORT"=>"",
			"ATSAST_MYSQL_USER"=>"",
			"ATSAST_MYSQL_DATABASE"=>"",
			"ATSAST_MYSQL_PASSWORD"=>"",

			"ATSAST_CDN"=>"https://static.1cf.co",
			"ATSAST_DOMAIN"=>"",
			"ATSAST_SALT"=>"@SAST+1s"
		);
		return $config[$KEY];
	}
	

}

```

The type in the configuration of your mysql server to this file.

**NOTICE :** Normally, you only need to set fields with DEBUG.

## For Developers

We highly recommend VSCode and PHPStorm for development. And do aware, **AT THIS MOMENT ALL PUSH ACTION WOULD DIRECTLY DEPLOIED TO PRODUCE ENVIRONMENT**. Please do not push unless gain permission from the leader.