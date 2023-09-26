<?php 
//ENTER THE RELEVANT INFO BELOW
set_time_limit(0);
    $mysqlUserName      = "studimky_rolcusr";
    $mysqlPassword      = "Sbra@#hma";
    $mysqlHostName      = "18.212.59.161";
    $DbName             = "studimky_rollcodb";


    $backup_name        = $DbName."backup.sql";

$table= "";
if(isset($_GET['tbl']) && $_GET['tbl']!='')$table=$_GET['tbl'];

if($table!='') $backup_name= $table."_backup.sql";

    function Export_Database($host,$user,$pass,$name,  $tables=false, $backup_name=false )
    {
        $mysqli = new mysqli($host,$user,$pass,$name); 
        $mysqli->select_db($name); 
      //  $mysqli->query("SET NAMES 'utf8'");
        $queryTables    = $mysqli->query('SHOW TABLES'); 
echo "<table border='1' cellspacing='5' cellpadding='5'>";        
echo "<tr><td>Table</td><td>Export</td></tr>";        
        foreach($queryTables as $row){
echo "<tr><td>".$row['Tables_in_'.$name]."</td><td><a target='_blank' href='?tbl=".$row['Tables_in_'.$name]."'>Export</a></td></tr>";        
        }
echo "</table>";        
    }        


if($table==''){
    
    Export_Database($mysqlHostName,$mysqlUserName,$mysqlPassword,$DbName,  $tables=false, $backup_name=false );

    }        
    

    if($table!=''){
        $mysqli = new mysqli($mysqlHostName,$mysqlUserName,$mysqlPassword,$DbName); 
        $mysqli->select_db($DbName); 
        //table fetch...
            $result         =   $mysqli->query('SELECT * FROM '.$table);  
            $fields_amount  =   $result->field_count;  
            $rows_num=$mysqli->affected_rows;     
            $res            =   $mysqli->query('SHOW CREATE TABLE '.$table); 
            $TableMLine     =   $res->fetch_row();
            $content        = (!isset($content) ?  '' : $content) . "\n\n"."DROP TABLE IF EXISTS ".$table." ;". "\n\n".$TableMLine[1].";\n\n";

            for ($i = 0, $st_counter = 0; $i < $fields_amount;   $i++, $st_counter=0) 
            {
                while($row = $result->fetch_row())  
                { //when started (and every after 100 command cycle):
                    if ($st_counter%100 == 0 || $st_counter == 0 )  
                    {
                            $content .= "\nINSERT INTO ".$table." VALUES";
                    }
                    $content .= "\n(";
                    for($j=0; $j<$fields_amount; $j++)  
                    { 
                        $row[$j] = str_replace("\n","\\n", addslashes($row[$j]) ); 
                        if (isset($row[$j]))
                        {
                            $content .= '"'.$row[$j].'"' ; 
                        }
                        else 
                        {   
                            $content .= '""';
                        }     
                        if ($j<($fields_amount-1))
                        {
                                $content.= ',';
                        }      
                    }
                    $content .=")";
                    //every after 100 command cycle [or at last line] ....p.s. but should be inserted 1 cycle eariler
                    if ( (($st_counter+1)%100==0 && $st_counter!=0) || $st_counter+1==$rows_num) 
                    {   
                        $content .= ";";
                    } 
                    else 
                    {
                        $content .= ",";
                    } 
                    $st_counter=$st_counter+1;
                }
            } $content .="\n\n\n";
//echo $content;
//exit;
//table fetch...
	    
//		}
		/*$backup_name='geneo19.sql';
        header('Content-Type: application/octet-stream');   
        header("Content-Transfer-Encoding: Binary"); 
        header("Content-disposition: attachment; filename=\"".$backup_name."\"");  
		echo $content;
	exit;
						exit;
*/
            
//        $backup_name = $backup_name ? $backup_name : $DbName."___(".date('H-i-s')."_".date('d-m-Y').")__rand".rand(1,11111111).".sql";
//        $backup_name = $backup_name ? $backup_name : $DbName.".sql";
        header('Content-Type: application/octet-stream');   
        header("Content-Transfer-Encoding: Binary"); 
        header("Content-disposition: attachment; filename=\"".$backup_name."\"");  
        echo $content; exit;
    }
?>
