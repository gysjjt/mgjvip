<?php
/**************************************
* Project Name:盛传移动商务平台
* Time:2016-03-22
* Author:MarkingChanning QQ:380992882
**************************************/
set_time_limit(0);
header("Content-Type: text/html;charset=utf-8");
include_once("curlapi.class.php");
$curl = new curlapi();

session_start();
$_SESSION['cookies'] = "v=mgj; realParentShopId=131771; username=%E5%88%A9%E5%85%B4%E5%8F%91%E5%9E%8B%E8%AE%BE%E8%AE%A1; cacheShopId_b4cdd36a-aeec-4b61-bdeb-7b90d3906501=131771; JSESSIONID=1CAB1C5FEFE12EA2B53CF9C772E42440; token=be9e16ac-13ac-40de-a67c-c0eff570f166; cacheShopId_be9e16ac-13ac-40de-a67c-c0eff570f166=131771; UM_distinctid=171f8aad816131-04078b997c94ac-70103e47-1fa400-171f8aad817dc; JSESSIONID=B5ED5F63D0364A44BF6E42818498D1D9; CNZZDATA1258534273=2062004128-1557122968-http%253A%252F%252Fvip8.meiguanjia.net%252F%7C1596329128";


//$_SESSION['cookies'] = "v=mgj; realParentShopId=192300; JSESSIONID=E7664905F13B72FBB68F66E9F409039F.tomcat1; token=ac250798-9a56-4446-9d22-ba3c15ca90ec; username=%E4%B8%9D%E5%B0%9A%E7%BE%8E%E5%AE%B9%E7%BE%8E%E5%8F%912; UM_distinctid=16a8bc2e80a564-0f7181dc40ce18-5a40201d-1fa400-16a8bc2e80b8af; JSESSIONID=C5109178A6EC249581D2C6148423B024.tomcat1; CNZZDATA1258534273=2062004128-1557122968-http%253A%252F%252Fvip8.meiguanjia.net%252F%7C1565159026";


if($_GET['action'] == "code"){//获取验证码
    $curl -> url = "http://vip8.meiguanjia.net/shair/vc";
    echo $curl -> get_code();
}else if($_GET['action'] == "login"){
    $login = urlencode($_POST['login']);
    $passwd = $_POST['passwd'];
    $rand = $_POST['rand'];
    $params = "login={$login}&passwd={$passwd}&rand={$rand}";
    $curl -> url = "http://vip8.meiguanjia.net/shair/loginAction!ajaxLogin.action?v=mgj";
    $curl -> params = $params;
    $result = $curl -> login();
    $result = json_decode($result,true);
    if($result['code'] == 4){
        echo "验证码错误！";
    }else if($result['code'] == 5){
        echo "不存在的账号！";
    }else if($result['code'] == 6){
        echo "密码错误！";
    }else if($result['role']){
        echo 1;
    }
}else if($_GET['action'] == 'curlmember'){
    $shopname = '利兴发型设计';
    $data = '';

    //获取总数
    $curl -> url = "https://vip8.meiguanjia.net/shair/memberInfo!memberlist.action?set=cash";
    $rs = $curl -> curl();
    preg_match('/共(.*)条/isU', $rs, $totals);
    $totals = isset($totals[1])?$totals[1]:100;
    //总页数
    $pages = ceil($totals/100);
    //$pages = 1;
    for($i=1; $i<=$pages; $i++){
        $params = "page.currNum=$i&page.rpp=100&set=cash";
        $curl -> params = $params;
        $curl -> url = "https://vip8.meiguanjia.net/shair/memberInfo!memberlist.action";
        $pagesData = $curl -> getMembersPage();
        $data .= $curl ->getMembersInfo($pagesData, $i);
    };
    if($data == '') {
        header('Location: index.php');
    }
    $curl -> downMembersCvs($data, $shopname);
}else if($_GET['action'] == 'curlpackage'){
    $shopname = '利兴发型设计';
    $data = '';

    //获取总数
    $curl -> url = "https://vip8.meiguanjia.net/shair/timesItem!initTreat.action?set=cash";
    $rs = $curl -> curl();
    preg_match('/共(.*)条/isU', $rs, $totals);
    $totals = isset($totals[1])?$totals[1]:100;

    //总页数
    $pages = ceil($totals/15);
    $pages = 1;
    for($i=1; $i<=$pages; $i++){
        $params = "page.currNum=$i&page.rpp=100&set=manage";
        $curl -> params = $params;
        $curl -> url = "https://vip8.meiguanjia.net/shair/timesItem!initTreat.action";
        $pagesData = $curl -> getPackagePage();
        $data .= $curl ->getPackageInfo($pagesData, $i);
    };
    if($data == '') {
        header('Location: index.php');
    }
    $curl -> downPackageCvs($data, $shopname);
}else if($_GET['action'] == 'curlstaff'){
    $shopname = $_REQUEST['shopname'];
    $data = '';

    //获取员工数据
    $curl -> url = "http://vip8.meiguanjia.net/shair/employee!employeeInfo.action?set=manage&r=0.5704847458180489";
    $rs = $curl -> curl();

    $rsBlank = preg_replace("/\s\n\t/","",$rs);
    //$rsBlank = str_replace(' ', '', $rsBlank);
    preg_match_all("/table_fixed_head.*>(.*)<\/form>/isU", $rsBlank ,$tables);

    if(count($tables[0]) == 0) {
        header('Location: index.php');
    }
    $curl -> downStaffCvs($tables[1][0], $shopname);
}
?>