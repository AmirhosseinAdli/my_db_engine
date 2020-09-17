<?php

$menu = [
    '0' => 'create table',
    '1' => 'insert data',
    '2' => 'retrive data',
    '3' => 'edit data',
    '4' => 'delete data',
    'q' => 'exit',
];

$functions = [
    '0' => 'create',
    '1' => 'insert',
    '2' => 'retrive',
    '3' => 'edit',
    '4' => 'delete',
    'q' => 'exiti',
];

$exit = false;

function show_menu(): void
{
    global $menu;

    foreach ($menu as $key => $title) {
        echo "[$key] $title \n";
    }
    echo "choose your key: ";
}

do{
    show_menu();
    $k = trim(fgets(STDIN));

    if(!isset($functions[$k])){
        echo "key not found!\n";
    }
    else{
        $functions[$k]();
    }

}while(!$exit);

function create(){
    echo "  Create table: ";
    $table = readline();
    echo "Please enter the fields: ";
    $fields = readline();
    $createtable = fopen($table . ".txt", "w+");
    $writefields = fwrite($createtable, $fields, 1024);
    echo "\n" . "Table `" . $table . "` created successfully!\n\n";
}


function insert(){
    echo "\nINSERT\n";
    echo "Table: ";
    $table = readline();
    echo "Fields: ";
    $fields = readline();
    $exist_table = fopen($table . ".txt", "a+");
    $exist_table_read = fgets($exist_table);
    $exist_table_read = explode(" ",$exist_table_read);
    $fields = explode(" ", $fields);
    $arr = array();
    for ($i = 0; $i < count($exist_table_read); $i++)
    {
        $arr[] = $exist_table_read[$i] . "=" . $fields[$i];
    }
    $arr = implode(", ", $arr);
    fwrite($exist_table, "\n" . $arr, 1024);
    unset($arr);
    echo "The fields inserted successfully in table " . $table;
}

function retrive(){}

function edit(){
    echo "Edit\nEnter your table: ";
    $table = readline();
    $exist_table = fopen($table . ".txt", "a+");
    $read = fread($exist_table, 10000);
    $read = explode("\n", $read);
    $arr = array();
    for ($i = 1; $i < count($read); $i++)
    {
        $arr[] = explode(", ",$read[$i]);
    }
    $x = array(array());
    for ($j = 0; $j < count($arr); $j++)
    {
        foreach ($arr[$j] as $item){
            $item = explode("=", $item);
            $x[$j+1][$item[0]] = $item[1];
        }
    }
    echo "Enter your table: ";
    $table = readline();
    echo "Enter id: ";
    $id = readline();
    echo "Enter your field: ";
    $field = readline();
    echo "Enter new data: ";
    $data = readline();
    $ret = array();
    $x[$id][$field] = $data;
    for ($k = 0; $k < count($x); $k++)
    {
        foreach ($x[$k] as $key => $value)
        {
            $ret[] = $key . "=" . $value;
        }
    }
    $ret = implode(", ",$ret);
    $ret = explode("student_id",$ret);
    unlink($table . ".txt");
    $exist_table = fopen($table . ".txt", "a+");
    fwrite($exist_table,$read[0] . "\n");
    for ($l = 1; $l < count($ret); $l++)
    {
        $ret[$l] = "student_id" . $ret[$l] . "\n";
        fwrite($exist_table,$ret[$l]);
    }
    var_dump($ret);
}

function delete(){
    echo "Edit\nEnter your table: ";
    $table = readline();
    $exist_table = fopen($table . ".txt", "a+");
    $read = fread($exist_table, 10000);
    $read = explode("\n", $read);
    $arr = array();
    for ($i = 1; $i < count($read); $i++)
    {
        $arr[] = explode(", ",$read[$i]);
    }
    $x = array(array());
    for ($j = 0; $j < count($arr); $j++)
    {
        foreach ($arr[$j] as $item){
            $item = explode("=", $item);
            $x[$j+1][$item[0]] = $item[1];
        }
    }
}

function exiti(){
    global $exit;
    $exit = true;
    echo "\n Good Bye! \n";
}
