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
$_SESSION['cookies'] = "v=mgj; realParentShopId=1025021; JSESSIONID=9D19DA3645BD045F090BEA9376BF2C1B.tomcat1; token=0dfa6bd8-56cf-4ebc-a30c-8f35398a116a; username=18395164433; UM_distinctid=16a8bc2e80a564-0f7181dc40ce18-5a40201d-1fa400-16a8bc2e80b8af; JSESSIONID=B2766E49B69C54E2AA4654EE9BA1DDD6.tomcat1; CNZZDATA1258534273=2062004128-1557122968-http%253A%252F%252Fvip8.meiguanjia.net%252F%7C1557215788";


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
    $shopname = '18395164433';
    $data = '';

    //获取总数
    $curl -> url = "http://vip8.meiguanjia.net/shair/memberInfo!memberlist.action?set=cash";
    $rs = $curl -> curl();
    preg_match('/共(.*)条/isU', $rs, $totals);
    $totals = isset($totals[1])?$totals[1]:100;
    //总页数
    $pages = ceil($totals/100);
    //$pages = 1;
    for($i=1; $i<=$pages; $i++){
        $params = "page.currNum=$i&page.rpp=100&set=cash";
        $curl -> params = $params;
        $curl -> url = "http://vip8.meiguanjia.net/shair/memberInfo!memberlist.action?set=cash";
        $pagesData = $curl -> getMembersPage();
        $data .= $curl ->getMembersInfo($pagesData, $i);
    };
    if($data == '') {
        header('Location: index.php');
    }

    $curl -> downMembersCvs($data, $shopname);
}else if($_GET['action'] == 'curlpackage'){
    $shopname = '18395164433';
    $data = '';

    //获取总数
    $curl -> url = "http://vip8.meiguanjia.net/shair/timesItem!initTreat.action?set=cash";
    $rs = $curl -> curl();
    preg_match('/共(.*)条/isU', $rs, $totals);
    $totals = isset($totals[1])?$totals[1]:100;

    //总页数
    $pages = ceil($totals/100);
    //$pages = 1;
    for($i=1; $i<=$pages; $i++){
        $params = "page.currNum=$i&page.rpp=100&set=cash&r=0.3421386775783387";
        $curl -> params = $params;
        $curl -> url = "http://vip8.meiguanjia.net/shair/timesItem!initTreat.action";
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