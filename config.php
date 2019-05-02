<?php
// header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Origin:*');
header('Content-Type: application/json');

$SERVER="localhost";
$USERNAME="root";
// $PASSWORD="";
$DB="zongxuan";
$PASSWORD="Continue.LJL666";

$con=mysqli_connect($SERVER,$USERNAME,$PASSWORD,$DB);
if(!con)
{
    $result=[
        "errcode" => 1,
        "msg" => "数据库连接错误",
        "data" => ""
    ];
    echo json_encode($result);
    exit;
}
mysqli_query($con,"SET NAMES utf8mb4");

function judge($name)
{
    if($name!="zongxuan" && $name!="sgjn" && $name!="lncz" && $name!="xybkm")
    {
        $result=[
            "errcode" => 2,
            "msg" => "参数错误",
            "data" => ""
        ];
        echo json_encode($result);
        exit;
    }
}



function add($con,$name)
{
    $sql="UPDATE click SET $name=$name+1";
    mysqli_query($con,$sql);

    $sql="SELECT $name From click";
    $res=mysqli_query($con,$sql);
    $amount=mysqli_fetch_array($res);
     
    $result=[
        "errcode" => 0,
        "msg" => "操作成功",
        "data" => $amount
    ];
    echo json_encode($result);

}



















?>