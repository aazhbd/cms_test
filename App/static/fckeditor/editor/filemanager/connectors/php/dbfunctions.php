<?php
function dbConn()
{
    $con = mysql_connect("localhost", "root", "");
    mysql_select_db("conlive") or die('Error occured: '.mysql_error());
}

function getNewId($table)
{
    $q = "select max(id) as max from $table";
    
    if($r = mysql_query($q))
    {
        while($l = mysql_fetch_assoc($r))
        {
            $max = $l["max"];
        }
        return $max + 1;
    }
    else
    {
        
        return 0;
    }
}

function getAlbumId($email, $UPLOAD_ALBUM_NAME = "personals")
{
    $UPLOAD_ALBUM_NAME = "personals";
    $q = "select * from albums where user_email = '$email' and album_name = '$UPLOAD_ALBUM_NAME'";
    $r = selectData($q);
    
    if(is_string($r))
    {
        return 0;
    }
    else if(is_array($r))
    {
        if(count($r) > 0)
        {
            foreach($r as $a)
            {
                $album = $a;
            }
            $album_id = $album['id'];
            return $album_id;
        }
        else
        {
            $dt = date("Y-m-d G:i:s");
            $table = "albums";
            $id = getNewId("$table");
            
            $albumimg_id = 0;
            
            $fields = array("id",  "album_name", "user_email", "date_pub", "privacy", "admin_perm", "remarks", "albumimg_id",  "view_count", "rating" ); 
            $values = array( "$id" , "$UPLOAD_ALBUM_NAME" , "$email" , "$dt" , 1,  1,  "" , "$albumimg_id" , 0, 0 );
            
            $rs = insertData($table, $fields, $values);
            
            if($rs == true)
            {
                return $id; 
            }
            else
            {
                return 0;
            }
        }
    }
    else
    {
        return 0;
    }
}

function getThumbImage($imagepath = 'interface/icos', $modwidth = 60, $fileName = 'user.gif')
{
    $save = "$imagepath/sml_" . $fileName; //This is the new file you saving
    $file = "$imagepath/" . $fileName; //This is the original file

    list($width, $height) = getimagesize($file) ; 
                                             
    $diff = $width / $modwidth;
                                            
    $modheight = $height / $diff; 

    $tn = imagecreatetruecolor($modwidth, $modheight) ; 
    
    $ar = explode(".", $fileName);
    if(is_array($ar))
    {
        $c = count($ar);
        if($c > 1)
            $ext = $ar[$c - 1];
    }
    
    if($ext == "gif")
    {
        $image = imagecreatefromgif($file);
    }
    if($ext == "jpeg" or $ext == "jpg" or $ext == "JPG" or $ext == "JPEG")
    {
        $image = imagecreatefromjpeg($file);
    }
    if($ext == "bmp" or $ext == "BMP")
    {
        $image = imagecreatefromwbmp($file);
    }
    
    if($ext == "png" or $ext == "PNG")
    {
        $image = imagecreatefrompng($file);
    }
    
    imagecopyresampled($tn, $image, 0, 0, 0, 0, $modwidth, $modheight, $width, $height) ; 

    if($ext == "gif")
    {
        $image = imagegif($tn, $save, 100);
    }
    if($ext == "jpeg" or $ext == "jpg" or $ext == "JPG" or $ext == "JPEG")
    {
        $image = imagejpeg($tn, $save, 100);
    }
    if($ext == "bmp" or $ext == "BMP")
    {
        $image = image2wbmp($tn, $save, 100);
    }
    if($ext == "png" or $ext == "PNG")
    {
        $image = imagepng($tn, $save);
    }

    $thumb_image = file_get_contents($save);
    
    exec("del $save");
    exec("del $file");
    
    unlink($save);
    unlink($file);
    
    return $thumb_image;
}

function insertData($table, $fields, $values)
{
    $n = count($fields);
    $m = count($values);
    
    if($n != $m) return false;
    
    for($i = 0; $i < $m ; $i++)
    {
        $values[$i] = mysql_real_escape_string($values[$i]);
    }
    
    $query = "insert into `" . $table . "`(";

    for($i = 0; $i < $n; $i++)
    {
        $query .= "`" . $fields[$i] . "`";
        if($i != ($n - 1)) $query .= ",";
    }
    
    $query .= ") values(";
    
    for($i = 0; $i < $m; $i++)
    {
        $query .= "'" . $values[$i] . "'";
        if($i != ($m - 1)) $query .= ",";
    }
    $query .= ")";
    if($r = mysql_query($query))
    {
        return true;
    }
    else
    {
        return mysql_error();
    }
}

function selectData($query)
{
    $result = array();
    $q = stripslashes(mysql_real_escape_string($query));
    
    if($r = mysql_query($q))
    {
        while($line = mysql_fetch_array($r, MYSQL_ASSOC))
        {
            $result[] = $line;
        }
        
        return $result;
    }
    else
    {
        return mysql_error();
    }
}
?>
