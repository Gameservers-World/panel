<?php
/*
 * Component of the update module
 */

function extractZip( $zipFile, $extract_path, $remove_path = '', $blacklist = '', $whitelist = '' )
{
	$temp_path = rtrim(sys_get_temp_dir(), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
	$base_path = rtrim(getcwd(), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;

	if(!file_exists($extract_path))
	{
		return "Destination path (${extract_path}) does not exists.\n";
	}

	if(!is_writable($extract_path))
	{
		return "Can't extract to ${extract_path}, not writable.\n";
	}

	if($zipFile == '' or $extract_path == '')
		return "Invalid arguments.\n";
	if( ! file_exists( $zipFile ) )
		return "Unable to read ${zipFile}.\n";
	$zip = zip_open($zipFile);
	$remove_path = addcslashes($remove_path,"/");

	if (is_resource($zip))
	{
		$i=0;
		$i2=0;
		$extracted_files = array();
		$ignored_files = array();
		while ($zip_entry = zip_read($zip))
		{
			$filename = zip_entry_name( $zip_entry );
			$file_path = preg_replace( "/$remove_path/", "", $filename  );
			$dir_path = preg_replace( "/$remove_path/", "", dirname( $filename ) );

			if( isset( $blacklist ) and is_array( $blacklist ) and in_array( $file_path , $blacklist  ) )
			{
				if( isset( $whitelist ) and is_array( $whitelist ) and in_array( $filename , $whitelist  ) )
				{
					$ignored_files[$i2] = $file_path;
					$i2++;
				}
				continue;
			}
			if( isset( $whitelist ) and is_array( $whitelist ) and !in_array( $filename , $whitelist  ) )
				continue;

			$completePath = $extract_path . $dir_path;
			$completeName = $extract_path . $file_path;
			$escaped_temp_path = str_replace('\\', '\\\\', $temp_path);// For Windows paths backslashes
			$root = preg_match("#^$escaped_temp_path#", $completePath)?$temp_path:$base_path;
			$escaped_root = str_replace('\\', '\\\\', $root);
			$relative_path = preg_replace("#^$escaped_root(.*)$#","$1",$completePath);

			// Walk through path to create non existing directories
			// This won't apply to empty directories ! They are created further below
			if(!file_exists($completePath) && preg_match( '/^' . $remove_path .'/', dirname(zip_entry_name($zip_entry)) ) )
			{
				$tmp = $root;
				foreach(preg_split('/(\/|\\\\)/',$relative_path) AS $k)
				{
					if( $k != "" )
					{
						$tmp .= $k.DIRECTORY_SEPARATOR;
						if( !file_exists($tmp) )
						{
							if(!mkdir($tmp, 0777))
							{
								return "Unable to write folder ${tmp}.\n";
							}
						}
					}
				}
			}

			if (zip_entry_open($zip, $zip_entry, "r"))
			{
				if( preg_match( '/^' . $remove_path .'/', dirname(zip_entry_name($zip_entry)) ) )
				{
					if ( ! preg_match( "/\/$/", $completeName) )
					{
						if ( $fd = fopen($completeName, 'w+'))
						{
							fwrite($fd, zip_entry_read($zip_entry, zip_entry_filesize($zip_entry)));
							fclose($fd);
							$extracted_files[$i]['filename'] = zip_entry_name($zip_entry);
							$i++;
						}
						else
						{
							return "Unable to write file ${completeName}.\n";
						}
					}
				}
				zip_entry_close($zip_entry);
			}
		}
		zip_close($zip);
		return array('ignored_files' => $ignored_files, 'extracted_files' => $extracted_files);
	}
	return "${zipFile} is corrupt.\n";
}
?>