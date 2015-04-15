<?php


class mysql_query_build
{
    private $db;
    private $tableName;
    
    function __get($name)
    {
        $this->tableName    = $name;
        return $this;
    }
    
    function __construct()
    {
        $this->db   = new stdClass();
    }
    
    function queryAll()
    {
        
    }
    
    function qeuryRow()
    {

    }
    
    function delete()
    {
        
    }
    
    function update()
    {
        
    }
    
    function insert($data)
    {
        $va     = [];
        $value_str  = '';
        $name_str   = '';
        foreach ($data as $key => $value)
        {
            $va[':' . $key]     = $value;
            $value_str         .= ':' . $key . ', ';
            $name_str          .= $key . ', ';
        }
        $name_str    = trim($name_str , ', ');
        $value_str   = trim($value_str , ', ');
        
        $sql = "INSERT INTO {$this->tableName}(". $name_str .") VALUES ("
                . $value_str . ")";
        
        var_dump($sql, $va);
    }
    
    function comWhere( $args )
    {
        $where  = ' ';
        $data   = array();
        
        if ( empty( $args ))
            return array( 'where' => '' , 'data' => $data );
        foreach ( $args as $option )
        {
            if ( empty( $option ))
            {
                $where  .= '';
                continue;
            } else if ( is_array( $option ))
            {
                foreach ( $option as $k => $v )
                {
                    if ( is_array( $v ))
                    {
                        if ( strpos( $k, ':' ))
                        {
                            $where  .= $k;
                            $data    = $data + $v;
                        }
                        else
                        {
                            $temp_str   = '';
                                 foreach ( $v as $key => $val )
                                 {
                                     $data[':'.$k.'_'. $key] = $val;
                                     $temp_str  .= ':'.$k.'_'. $key . ',';
                                 }
                                 $temp_str  = trim($temp_str, ',');

                                $where  .= $k . " IN ( $temp_str )";
                        }

                    } else if ( strpos( $k, ' ' ))
                    {
                        $k          = trim($k);
                        $temp_k     = explode(' ', $k);
                        $where      .= $k . '  :'. $temp_k[0];
                        $data[':'.$temp_k[0]]     = $v;
                    } else
                    {
                        $where      .= "$k = :$k";
                        $data[':'.$k]     = $v;
                    }
                    $where  .= ' AND ';
                }
                $where = rtrim( $where, 'AND ' );
                $where .= ' OR ';
                continue;
            }
        }
        $where  = rtrim( $where, 'OR ' );
        return array( 'where' =>  " $where ", 'data' => $data );
    }
    
    
    
    
}


$db     = new mysql_query_build;


$data   = ['name' => 'jack', 'sex' => 1, 'job' => 'enginner'];


$data   = $db->jack->comWhere( [ array( 'id <' => 'iweo', 'ioew >' => 'iw' ) ] );



var_dump($data);






