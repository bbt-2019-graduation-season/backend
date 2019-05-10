<?php
// header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Origin:*');
header('Content-Type: application/json');

$SERVER="localhost";
$USERNAME="root";
$PASSWORD="";//密码示例
$DB="zongxuan";

//DDL示例
$zongxuanDDL = "2019-5-4";
$sgjnDDL = "2019-4-24";
$lnczDDL = "2019-5-12";
$xybkmDDL = "2019-5-10";

//连接服务器
$con=mysqli_connect($SERVER,$USERNAME,$PASSWORD,$DB);
if(!$con)
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

//设置默认时区
date_default_timezone_set("Asia/Shanghai");

//判断参数是否合法
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

//增加访问量
function add($name)
{
    global $con;
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

//根据Y-m-d的格式返回格林威治时间
function getTime($pattern)
{
    $timeObj = date_create_from_format("Y-m-d",$pattern);
    $time = date_timestamp_get($timeObj);
    return $time;
}

//判断活动是否截止，截止返回true
function overdue($name)
{
    
    $time = time();
    global $zongxuanDDL;
    global $sgjnDDL;
    global $lnczDDL;
    global $xybkmDDL;
    $zongxuan = getTime($zongxuanDDL);
    $sgjn = getTime($sgjnDDL);
    $lncz = getTime($lnczDDL);
    $xybkm = getTime($xybkmDDL);
    

    if($name == "zongxuan" && $time > $zongxuan)
        return true;
    else if($name == "sgjn" && $time > $sgjn)
        return true;
    else if($name == "lncz" && $time > $lncz)
        return true;
    else if($name == "xybkm" && $time > $xybkm)
        return true;
    
    return false;
}

//判断活动是否截止,截止返回信息
function isDDL($name)
{
    if(overdue($name))
    {
        global $con;
        $sql="SELECT $name From click";
        $res=mysqli_query($con,$sql);
        $amount=mysqli_fetch_array($res);

        $result = [
            "errcode" => 3,
            "msg" => "活动时间已截止",
            "data" => $amount
        ];
        echo json_encode($result);
        exit;
    }
}

//获取活动DDL
function DDL($name)
{
    global $zongxuanDDL;
    global $sgjnDDL;
    global $lnczDDL;
    global $xybkmDDL;
    
    $result = [
        "errcode" => 0,
        "msg" => "活动时间",
        "data" => ""
    ];

    if($name == "zongxuan")
        $result["data"]=$zongxuanDDL;
    else if($name == "sgjn")
        $result["data"]=$sgjnDDL;
    else if($name == "lncz")
        $result["data"]=$lnczDDL;
    else if($name == "xybkm")
        $result["data"]=$xybkmDDL;

    echo json_encode($result);
}
















?>