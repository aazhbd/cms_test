<?php
/*
 * FCKeditor - The text editor for Internet - http://www.fckeditor.net
 * Copyright (C) 2003-2009 Frederico Caldeira Knabben
 *
 * == BEGIN LICENSE ==
 *
 * Licensed under the terms of any of the following licenses at your
 * choice:
 *
 *  - GNU General Public License Version 2 or later (the "GPL")
 *    http://www.gnu.org/licenses/gpl.html
 *
 *  - GNU Lesser General Public License Version 2.1 or later (the "LGPL")
 *    http://www.gnu.org/licenses/lgpl.html
 *
 *  - Mozilla Public License Version 1.1 or later (the "MPL")
 *    http://www.mozilla.org/MPL/MPL-1.1.html
 *
 * == END LICENSE ==
 *
 * This is the File Manager Connector for PHP.
 */
 
//Modified 
require_once('dbfunctions.php'); 


function GetFolders( $resourceType, $currentFolder )
{
	// Map the virtual path to the local server path.
	$sServerDir = ServerMapFolder( $resourceType, $currentFolder, 'GetFolders' ) ;

	// Array that will hold the folders names.
	$aFolders	= array() ;

	$oCurrentFolder = @opendir( $sServerDir ) ;

	if ($oCurrentFolder !== false)
	{
		while ( $sFile = readdir( $oCurrentFolder ) )
		{
			if ( $sFile != '.' && $sFile != '..' && is_dir( $sServerDir . $sFile ) )
				$aFolders[] = '<Folder name="' . ConvertToXmlAttribute( $sFile ) . '" />' ;
		}
		closedir( $oCurrentFolder ) ;
	}

	// Open the "Folders" node.
	echo "<Folders>" ;

	natcasesort( $aFolders ) ;
	foreach ( $aFolders as $sFolder )
		echo $sFolder ;

	// Close the "Folders" node.
	echo "</Folders>" ;
}

//Modified
function GetFoldersAndFiles( $resourceType, $currentFolder )
{
    
    dbConn();
    //$email = $_GET['e'];
    // Map the virtual path to the local server path.
	$sServerDir = ServerMapFolder( $resourceType, $currentFolder, 'GetFoldersAndFiles' );
    
    
    $f = fopen("log2.txt", "a");
    fwrite($f, "\r\nemail = $currentFolder\r\n");

    // Arrays that will hold the folders and files names.
	$aFolders	= array() ;
	$aFiles		= array() ;
    /*
	$oCurrentFolder = @opendir( $sServerDir ) ;
    
    if($sFile = readdir( $oCurrentFolder ))
    {
        if ( is_dir( $sServerDir . $sFile ) )
        $aFolders[] = '<Folder name="' . ConvertToXmlAttribute( $sFile ) . '" />' ;
        
	}
    closedir( $oCurrentFolder );
    */
    
    // Arrays that will hold the folders and files names.
    $aFolders    = array() ;
    $aFiles        = array() ;
    
    $email = getEmailFCK();
    
    if($email != "")
    {
        //$f = fopen("cok.txt", "w");
        //fprintf($f, "$email");
    }
    
    $email = "a@b.com";
    $email = $_SESSION['em'];
    
    $email = $_GET['email'];
    
    //import_request_variables("c", "c_");
    $email = $c_conlivefck_cookie;
    
    $f = fopen("cok.txt", "w");
    fprintf($f, "$email");
    
    $album_id = getAlbumId($email);
    
    $r = selectData("select * from user_imgs where user_email = '$email' and stat = 1 and album_id = $album_id ");
    
    foreach($r as $file)
    {
        $fs = $file['file_size'];
        if($fs > 1) $fs = round($fs);
        else $fs = 1;
        
        $aFiles[] = '<File name="' . ConvertToXmlAttribute( $file['id'] ) . '" size="' . $fs . '" />' ;
    }

	// Send the folders
	natcasesort( $aFolders ) ;
	echo '<Folders>' ;

	foreach ( $aFolders as $sFolder )
		echo $sFolder ;

	echo '</Folders>' ;

	// Send the files
	natcasesort( $aFiles ) ;
	echo '<Files>' ;

	foreach ( $aFiles as $sFiles )
		echo $sFiles ;

	echo '</Files>' ;
}

function CreateFolder( $resourceType, $currentFolder )
{
	if (!isset($_GET)) {
		global $_GET;
	}
	$sErrorNumber	= '0' ;
	$sErrorMsg		= '' ;

	if ( isset( $_GET['NewFolderName'] ) )
	{
		$sNewFolderName = "Personals";
        //$sNewFolderName = $_GET['NewFolderName'] ;
		//$sNewFolderName = SanitizeFolderName( $sNewFolderName ) ;

		if ( strpos( $sNewFolderName, '..' ) !== FALSE )
			$sErrorNumber = '102' ;		// Invalid folder name.
		else
		{
			// Map the virtual path to the local server path of the current folder.
			$sServerDir = ServerMapFolder( $resourceType, $currentFolder, 'CreateFolder' ) ;

			if ( is_writable( $sServerDir ) )
			{
				$sServerDir .= $sNewFolderName ;

				$sErrorMsg = CreateServerFolder( $sServerDir ) ;

				switch ( $sErrorMsg )
				{
					case '' :
						$sErrorNumber = '0' ;
						break ;
					case 'Invalid argument' :
					case 'No such file or directory' :
						$sErrorNumber = '102' ;		// Path too long.
						break ;
					default :
						$sErrorNumber = '110' ;
						break ;
				}
			}
			else
				$sErrorNumber = '103' ;
		}
	}
	else
		$sErrorNumber = '102' ;

	// Create the "Error" node.
	echo '<Error number="' . $sErrorNumber . '" />' ;
}
//Modified 
function FileUpload( $resourceType, $currentFolder, $sCommand )
{
	dbConn();
    $email = getEmailFCK();
    $thumb_widthpx = 160;
    
    if (!isset($_FILES)) {
		global $_FILES;
	}
	$sErrorNumber = '0' ;
	$sFileName = '' ;

	if ( isset( $_FILES['NewFile'] ) && !is_null( $_FILES['NewFile']['tmp_name'] )  && $email != "")
	{
		global $Config ;

		$oFile = $_FILES['NewFile'] ;

		// Map the virtual path to the local server path.
		//$sServerDir = ServerMapFolder( $resourceType, $currentFolder, $sCommand ) ;
        
        
        $s = GetRootPath() . $Config['UserTempPath'] . $currentFolder ."/";
        $s = str_replace("\\", "/", $s);
        $sServerDir = $s;
        
        $f = fopen("log2.txt", "a");
        fwrite($f, "\r\n  s = $s \r\n");
        
		// Get the uploaded file name.
		$sFileName = $oFile['name'] ;
		$sFileName = SanitizeFileName( $sFileName ) ;

		$sOriginalFileName = $sFileName ;

		// Get the extension.
		$sExtension = substr( $sFileName, ( strrpos($sFileName, '.') + 1 ) ) ;
		$sExtension = strtolower( $sExtension );

		if ( isset( $Config['SecureImageUploads'] ) )
		{
			if ( ( $isImageValid = IsImageValid( $oFile['tmp_name'], $sExtension ) ) === false )
			{
				$sErrorNumber = '202' ;
			}
		}

		if ( isset( $Config['HtmlExtensions'] ) )
		{
			if ( !IsHtmlExtension( $sExtension, $Config['HtmlExtensions'] ) &&
				( $detectHtml = DetectHtml( $oFile['tmp_name'] ) ) === true )
			{
				$sErrorNumber = '202' ;
			}
		}

		// Check if it is an allowed extension.
		if ( !$sErrorNumber && IsAllowedExt( $sExtension, $resourceType ) )
		{
			$iCounter = 0 ;

			while ( true )
			{
				$sFilePath = $sServerDir ."/" .$sFileName ;
                //fwrite($f, "\r\n sFilePath = $sFilePath \r\n");
                //fwrite($f, "\nsServerDir = $sServerDir\n");
				
                if ( is_file( $sFilePath ) )
				{
					$iCounter++ ;
					$sFileName = RemoveExtension( $sOriginalFileName ) . '(' . $iCounter . ').' . $sExtension ;
					$sErrorNumber = '201' ;
				}
				else
				{
					move_uploaded_file( $oFile['tmp_name'], $sFilePath ) ;
                    
					if ( is_file( $sFilePath ) )
					{
						$ftype = $_FILES['NewFile']['type'];
                        $file_size = $_FILES['NewFile']['size'];
                        
                        $originalpic = file_get_contents($sFilePath);
                        list($width, $height) = getimagesize($sFilePath);
                        
                        if($width > $thumb_widthpx)
                        {
                            $count = 1;
                            $p = str_replace($sFileName, "", $sFilePath, $count);
                            //fwrite($f, "\r\nfpath: $sFilePath\r\n");
                            $thumbpic = getThumbImage($p, $thumb_widthpx, $sFileName);
                        }
                        else
                        {
                            $thumbpic = $originalpic;
                            unlink($sFilePath);
                        }
                        
                        $album_id = getAlbumId($email);
                        $table = 'user_imgs';
                        $fields = array('id', 'user_email', 'large_image','thumb_image', 'file_type','stat', 'file_name', 'file_size', 'album_id', 'admin_perm', 'view_count', 'rating');
                        $values = array(null, $email, $originalpic , $thumbpic,  $ftype,  1,  $sFileName, $file_size, $album_id, 1, 0, 0);
                        
                        $rs = insertData($table, $fields, $values);
                        if(is_string($rs) || $rs == false)
                        {
                            //$sErrorNumber = '202' ;
                            //file_put_contents("$sFileName", $thumbpic);
                            
                        }
                        else
                        {
                            //fwrite($f, "is inserted = true");
                        }
                        
                        if ( isset( $Config['ChmodOnUpload'] ) && !$Config['ChmodOnUpload'] )
						{
							break ;
						}

						$permissions = 0777;

						if ( isset( $Config['ChmodOnUpload'] ) && $Config['ChmodOnUpload'] )
						{
							$permissions = $Config['ChmodOnUpload'] ;
						}

						$oldumask = umask(0) ;
						chmod( $sFilePath, $permissions ) ;
						umask( $oldumask ) ;
					}

					break ;
				}
			}

			if ( file_exists( $sFilePath ) )
			{
				//previous checks failed, try once again
				if ( isset( $isImageValid ) && $isImageValid === -1 && IsImageValid( $sFilePath, $sExtension ) === false )
				{
					@unlink( $sFilePath ) ;
					$sErrorNumber = '202' ;
				}
				else if ( isset( $detectHtml ) && $detectHtml === -1 && DetectHtml( $sFilePath ) === true )
				{
					@unlink( $sFilePath ) ;
					$sErrorNumber = '202' ;
				}
			}
		}
		else
			$sErrorNumber = '202' ;
	}
	else
		$sErrorNumber = '202' ;


	$sFileUrl = CombinePaths( GetResourceTypePath( $resourceType, $sCommand ) , $currentFolder ) ;
	$sFileUrl = CombinePaths( $sFileUrl, $sFileName ) ;

	SendUploadResults( $sErrorNumber, $sFileUrl, $sFileName ) ;

	exit ;
}
?>
