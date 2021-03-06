<?php
/**************************************
* Project Name:盛传移动商务平台
* Time:2016-03-22
* Author:MarkingChanning QQ:380992882
**************************************/
error_reporting(0);
require 'querylist/phpQuery.php';
require 'querylist/QueryList.php';
use QL\QueryList;

class curlapi{
    public $url; //提交地址
    public $params; //登入的post数据
    public $cookies=""; //cookie
    public $referer=""; //http referer
    
    /*
        获取验证码
    */
    public function get_code(){
        $ch = curl_init($this -> url);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        preg_match("/Set-Cookie:(.*);/siU", $output, $arr);
        $cookies = $arr[1];

        //cookies存SESSION
        session_start();
        $_SESSION['cookies'] = "realParentShopId=969654; v=mgj; JSESSIONID=F5A6D4C4DC9156986559C2E381760114.tomcat1; code=4006; token=0eba24a8-6a23-4763-a494-00c82b99647a; username=%E5%B0%9A%E9%9B%85%E9%80%A0%E5%9E%8B%E6%94%B6%E9%93%B6; UM_distinctid=163fd4dbafd83c-0715073c9c1813-36624209-1fa400-163fd4dbafed37; Hm_lvt_cc903faaed69cca18f7cf0997b2e62c9=1535956653; JSESSIONID=8F56CA8E4E42BA3E73FF1C53433F1F39.tomcat1; Hm_lvt_4e5bdf78b2b9fcb88736fc67709f2806=1536912078,1537434752,1538122014,1538296333; Hm_lpvt_4e5bdf78b2b9fcb88736fc67709f2806=1538296366; CNZZDATA1258534273=312623051-1529563067-%7C1538296367";

        // $_SESSION['cookies'] = $cookies;
        // //截取GIF二进制图片
        // $explode = explode("HttpOnly",$output);
        // return $explode = trim($explode[1]);
    }
    
    /*
        模拟登陆
    */
    public function login(){
        session_start();
        $ch=curl_init();
        curl_setopt($ch, CURLOPT_URL,$this -> url);
        curl_setopt($ch, CURLOPT_HEADER,0);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch,CURLOPT_COOKIE,$_SESSION['cookies']);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$this -> params);
        curl_setopt ($ch, CURLOPT_REFERER,$this -> url);
        $result=curl_exec($ch);
        curl_close($ch);
        return $result;
    }
    
    /*
        curl模拟采集数据
    */
    public function curl(){
        session_start();
        $cacert = getcwd() . '/cacert.pem'; //CA根证书
        $ch=curl_init();
        curl_setopt($ch, CURLOPT_URL,$this -> url);
        curl_setopt($ch, CURLOPT_HEADER,0);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch,CURLOPT_COOKIE,$_SESSION['cookies']);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$this -> params);
        curl_setopt ($ch, CURLOPT_REFERER,$this -> referer);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);   // 只信任CA颁布的证书
        curl_setopt($ch, CURLOPT_CAINFO, $cacert); // CA根证书（用来验证的网站证书是否是CA颁布）
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2); // 检查证书中是否设置域名，并且是否与提供的主机名匹配
        $result=curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    /*
    curl模拟采集数据，会员数据
    */
    public function getMembersPage(){
        session_start();
        $cacert = getcwd() . '/cacert.pem'; //CA根证书
        $ch=curl_init();
        curl_setopt($ch, CURLOPT_URL,$this -> url);
        curl_setopt($ch, CURLOPT_HEADER,0);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch,CURLOPT_COOKIE,$_SESSION['cookies']);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$this -> params);
        curl_setopt ($ch, CURLOPT_REFERER,$this -> referer);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);   // 只信任CA颁布的证书
        curl_setopt($ch, CURLOPT_CAINFO, $cacert); // CA根证书（用来验证的网站证书是否是CA颁布）
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2); // 检查证书中是否设置域名，并且是否与提供的主机名匹配
        $result=curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    /*
    curl模拟采集数据，会员一些详细数据
    */
    public function getMembersInfos(){
        session_start();
        $cacert = getcwd() . '/cacert.pem'; //CA根证书
        $ch=curl_init();
        curl_setopt($ch, CURLOPT_URL,$this -> url);
        curl_setopt($ch, CURLOPT_HEADER,0);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch,CURLOPT_COOKIE,$_SESSION['cookies']);
        curl_setopt ($ch, CURLOPT_REFERER,$this -> referer);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$this -> params);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);   // 只信任CA颁布的证书
        curl_setopt($ch, CURLOPT_CAINFO, $cacert); // CA根证书（用来验证的网站证书是否是CA颁布）
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2); // 检查证书中是否设置域名，并且是否与提供的主机名匹配
        $result=curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    /**分析会员数据
     * @param $rs
     * @param $page
     * @return mixed|string
     */
    public function getMembersInfo($rs, $page){
        $rsBlank = preg_replace("/\s\n\t/","",$rs);
        //$rsBlank = str_replace(' ', '', $rsBlank);
        preg_match_all("/delForm.*>(.*)<\/form>/isU", $rsBlank ,$tables);
        if(isset($tables[1][0])) {
            if($page>1) {
                return preg_replace("/<thead[^>]*>.*<\/thead>/isU", '', $tables[1][0]);
            } else {
                return $tables[1][0];
            }
        } else {
            return '';
        }
        return $tables[1][0];
    }

    /**
     * 获取会员信息下载到CVS
     * @param $html
     * @param $shopname
     */
    public function downMembersCvs($html,$shopname){
        $rules = array(
            //采集tr中的纯文本内容
            'other' => array('tr','html'),
            'id' => array('tr','id'),
        );
        $newdata = array();
        $data = QueryList::Query($html, $rules)->data;
        $k = 0;
        foreach ($data as &$item) {
            $other = explode('</td>', $item['other']);
            $html = $item['other'];
            if(count($other) > 15) {
                //unset($other[0]);//去掉第一空白项
                //unset($other[14]);//去掉14项
                //unset($other[15]);//去掉15项
                //unset($other[18]);//去掉15项
                $item['other'] = $other;

                //有几个会员卡列表
                $counts = count($other)-1-20;
                $rows = $counts/10+1;

                //积分
                $k18 = 18+10*($rows-1);
                preg_match_all('/value\=\"(.*)分\"/isU', $other[$k18], $jf);
                $other[$k18] = isset($jf[1][0])?$jf[1][0]:0;

                foreach ($other as &$v1) {
                    $v1 = strip_tags($v1);;
                    $v1 = preg_replace("/\s\n\t/","",$v1);
                    $v1 = str_replace(' ', '', $v1);
                    $v1= trim(str_replace(PHP_EOL, '', $v1));
                }
                ksort($other);

                //获取shopid和会员id
                preg_match("/shopid=(.*)\&/isU", $html, $shopids);
                preg_match("/\?id=(.*)\&/isU", $html, $ids);

                for($i=1; $i<=$rows; $i++) {
                    //卡号
                    $k0 = 7+10*($i-1);
                    $newdata[$k][0] = "\t".$other[$k0]; //卡号
                    $newdata[$k][1] = $other[2]; //姓名
                    $newdata[$k][2] = $other[1]; //手机号
                    $newdata[$k][3] = $other[3] == '男'?0:1; //性别

                    //卡类型
                    $k7 = 8+10*($i-1);
                    $newdata[$k][4] = $other[$k7]; //卡类型

                    $newdata[$k][5] = $other[10]; //折扣

                    //卡金余额(必填),疗程,
                    $newdata[$k][6] = 0; //卡金余额
                    $newdata[$k][7] = 0; //充值总额
                    $newdata[$k][9] = 0; //消费总额
                    $newdata[$k][10] = 0; //赠送金

                    //卡金余额
                    $k6 = 13+10*($i-1);
                    preg_match_all('/(.*)元/isU', $other[$k6], $data1);
                    if(isset($data1[1]) && count($data1[1]) == 2) {
                        $newdata[$k][6] = str_replace('元:', '', $data1[1][0]);
                        $newdata[$k][6] = str_replace('余:次:', '', $data1[1][0]);
                        //$newdata[$k][7] = str_replace('疗程:', '', $data1[1][1]);
                    } else {
                        $newdata[$k][6] = str_replace('元', '', $other[$k6]);
                        $newdata[$k][6] = str_replace('余:次', '', $other[$k6]);
                        //$newdata[$k][7] = 0;
                    }

                    //充值总额
                    $k7 = 11+10*($i-1);
                    $newdata[$k][7] += str_replace('元', '', $other[$k7]); //充值总额

                    //消费总额
                    $k11 = 12+10*($i-1);
                    $newdata[$k][9] += str_replace('元', '', $other[$k11]); //消费总额

                    //赠送金
                    $k13 = 14+10*($i-1);
                    $newdata[$k][10] += str_replace('元', '', $other[$k13]); //赠送金

                    $k17 = 18+10*($rows-1)-1;
                    $newdata[$k][8] = str_replace('次', '', $other[$k17]); //消费次数

                    $newdata[$k][11] = $other[$k18]; //积分

                    $newdata[$k][12] = 0; //开卡时间

                    //日期格式转换
                    $date1 = substr($other[5], 0, 3).' '.substr($other[5], 3, 3).' '.substr($other[5], 19, 4);
                    $date1 = date('Y-m-d', strtotime($date1));

                    $k19 = 19+10*($rows-1);
                    $date2 = substr($other[$k19], 0, 3).' '.substr($other[$k19], 3, 3).' '.substr($other[$k19], 19, 4);

                    $date2 = date('Y-m-d', strtotime($date2));
                    $newdata[$k][13] = $date1; //最后消费时间
                    $newdata[$k][14] = $date2 == '1970-01-01'?$date1:$date2; //生日
                    $newdata[$k][15] = ''; //会员备注

                    //获取shopid和会员id
                    $newdata[$k][20] = $shopids[1];
                    $newdata[$k][21] = $ids[1];

                    ksort($newdata[$k]);
                    $k = $k+$i;
                }
                /*
                if(preg_match('/余/isU', $newdata[$k][6])) {
                    $tmp = explode('余', $newdata[$k][6]);
                    $newdata[$k][6] = $tmp[0];
                }
                */
                $k++;
            }
        }

        //导出CVS
        $cvsstr = "卡号(必填[唯一]),姓名(必填),手机号(必填[唯一]),性别(必填[“0”代表男，“1”代表女]),卡类型(必填[系统编号]),折扣(必填),卡金余额(必填),充值总额,消费次数,消费总额,赠送金,积分,欠款,开卡时间(格式：YYYY-mm-dd),最后消费时间(格式：YYYY-mm-dd),生日(格式：YYYY-mm-dd),会员备注\n";
        $filename = $shopname.'_会员信息.csv';
        $cvsstr = iconv('utf-8','gb2312//ignore',$cvsstr);

        $newdata = array_values($newdata);
        ksort($newdata);

        foreach($newdata as &$v){
            //获取会员备注和欠款
            $keyword = trim($v[0]);
            $this -> url = "https://vip8.meiguanjia.net/shair/consumerHelp!find.action?searchType=1&keyType=1&keyword=$keyword";
            $rs = $this -> curl();

            //会员备注
            $rules = array(
                'mark' => array('textarea','html'),
            );
            $mark = QueryList::Query($rs, $rules)->data;
            $v[16] = $mark[0]['mark'];
            if(isset($mark[1]['mark'])){
                $v[16] .= " ".$mark[1]['mark'];
            }
            $v[16] = preg_replace("/\s\n\t/","",$v[16]);
            $v[16] = str_replace('&amp;', ' ', $v[16]);
            $v[16] = preg_replace("/\s/","", $v[16]);
            //欠款
            $debt = 0;
            $rules = array(
                'debt' => array('.table_list tr','html'),
            );
            $debtHtml = QueryList::Query($rs, $rules)->data;
            foreach ($debtHtml as $dk => $dv){
                if($dk > 0){
                    $debtTmp = explode('</td>', $dv['debt']);
                    foreach ($debtTmp as &$v1) {
                        $v1 = strip_tags($v1);;
                        $v1 = preg_replace("/\s\n\t/","",$v1);
                        $v1 = str_replace(' ', '', $v1);
                        $v1= trim(str_replace(PHP_EOL, '', $v1));
                    }
                    if($debtTmp[4] == '未还清' || strpos($debtTmp[4], '未还清')>=0) {
                        $debt += $debtTmp[2];
                    }
                }
            }
            $v[12] = $debt;


            //卡备注
//            $shopid = $v[20];
//            $id = $v[21];
//            $this -> url = "http://vip8.meiguanjia.net/shair/memberArchives!editMember.action?id=$id&shopid=$shopid&flag=2&dickey=1";
//            $rs = $this -> curl();
//            $rules = array(
//                 'mark' => array('input','name'),
//                 'value' => array('input','value'),
//             );
//             $cardRemark = QueryList::Query($rs, $rules)->data;
//             if(isset($cardRemark[40]['value']) && $cardRemark[40]['value'] != ''){
//                 $v[16] .= "，卡备注：".$cardRemark[40]['value'];
//             }
            unset($v[20]);
            unset($v[21]);

            foreach($v as $k=>&$v1){
                //时间转换
                if($k == 5 || $k == 19) {
                    //$v1 = strtotime($v1);
                }
                //转码
                $cvsdata = iconv('utf-8','gb2312//ignore',$v1);
                $cvsstr .= $cvsdata; //用引文逗号分开
                if($k < 19) {
                    $cvsstr .= ","; //用引文逗号分开
                }
            }
            $cvsstr .= "\n";
        }
        header("Content-type:text/csv");
        header("Content-Disposition:attachment;filename=".$filename);
        header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
        header('Expires:0');
        header('Pragma:public');
        echo $cvsstr;
    }

    /*
    curl模拟采集数据，会员套餐数据
    */
    public function getPackagePage(){
        session_start();
        $cacert = getcwd() . '/cacert.pem'; //CA根证书
        $ch=curl_init();
        curl_setopt($ch, CURLOPT_URL,$this -> url);
        curl_setopt($ch, CURLOPT_HEADER,0);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch,CURLOPT_COOKIE,$_SESSION['cookies']);
        curl_setopt ($ch, CURLOPT_REFERER,$this -> referer);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$this -> params);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);   // 只信任CA颁布的证书
        curl_setopt($ch, CURLOPT_CAINFO, $cacert); // CA根证书（用来验证的网站证书是否是CA颁布）
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2); // 检查证书中是否设置域名，并且是否与提供的主机名匹配
        $result=curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    /**
     *获取套餐页面数据
     */
    public function getPackageInfo($rs, $page){
        $rsBlank = preg_replace("/\s\n\t/","",$rs);
        //$rsBlank = str_replace(' ', '', $rsBlank);
        preg_match_all("/table-responsive.*>(.*)<\/form>/isU", $rsBlank ,$tables);
        if(isset($tables[1][0])) {
            if($page>1) {
                return preg_replace("/<thead[^>]*>.*<\/thead>/isU", '', $tables[1][0]);
            } else {
                return $tables[1][0];
            }
        } else {
            return '';
        }
        return $tables[1][0];
    }

    /**
     * 获取会员套餐信息下载到CVS
     * @param $html
     * @param $shopname
     */
    public function downPackageCvs($html,$shopname){
        $rules = array(
            //采集tr中的纯文本内容
            'other' => array('tr','html'),
        );
        $newdata = array();
        $data = QueryList::Query($html, $rules)->data;
        foreach ($data as $k=>&$item) {
            $other = explode('</td>', $item['other']);
            if(count($other) > 8) {
                //unset($other[0]);//去掉第一空白项
                $item['other'] = $other;
                foreach ($other as $k1 => &$v1) {
                    $v1 = strip_tags($v1);;
                    $v1 = preg_replace("/\s\n\t/","",$v1);
                    $v1 = str_replace(' ', '', $v1);
                    $v1= trim(str_replace(PHP_EOL, '', $v1));
                    if($k1 == 5) {
                        $v1 = trim(str_replace(',', '，', $v1));
                        $v1 = trim(str_replace('项目名称:已删除', '项目编号:-1,项目名称:已删除', $v1));
                        $v1 = explode('项目编号:', $v1);
                        unset($v1[0]);
                    }
                }

                foreach($other[5] as $k2=>$v2) {
                    $newA[0] = $other[0]; //手机号
                    $newA[1] = "\t".$other[1]; //卡号
                    $newA[2] = $other[2]; //姓名
                    $newA[3] = $other[3]; //卡名称
                    $newA[4] = $other[4]; //卡类型

                    $v2 .= "#";
                    //获取项目套餐信息
                    preg_match('/(.*)，项目名称/isU', $v2, $p1);  //项目编号
                    preg_match('/项目名称:(.*)，/isU', $v2, $p2);  //项目名称
                    preg_match('/总次数:(.*)，/isU', $v2, $p3);  //总次数
                    preg_match('/剩余次数:(.*)，/isU', $v2, $p4);  //剩余次数
                    preg_match('/单次消费金额:(.*)，/isU', $v2, $p5);  //单次消费金额
                    if(preg_match("/，失效日期/", $v2)){
                        preg_match('/剩余金额:(.*)，失效日期/isU', $v2, $p6);  //剩余金额
                    } else {
                        preg_match('/剩余金额:(.*)#/isU', $v2, $p6);  //剩余金额
                    }
                    if(!isset($p6[1])) {
                        preg_match('/剩余金额:(.*)，/isU', $v2, $p6);  //剩余金额
                    }
                    preg_match('/失效日期：(.*)#/isU', $v2, $p7);  //失效日期
                    $newA[5] = isset($p1[1])?$p1[1]:' ';//项目编号
                    $newA[6] = isset($p2[1])?$p2[1]:' ';//项目名称
                    $newA[7] = isset($p3[1])?$p3[1]:' ';//总次数
                    $newA[8] = isset($p4[1])?$p4[1]:' ';//剩余次数
                    $newA[9] = isset($p5[1])?$p5[1]:' '; //单次消费金额
                    $newA[10] = isset($p6[1])?$p6[1]:' '; //剩余金额
                    $newA[11] = isset($p7[1])?$p7[1]:' ';//失效日期

                    $newA[12] = $newA[8];//总剩余次数
                    $newA[13] = $newA[10]; //总剩余金额
                    $newA[14] = $other[8];

                    if($newA[5] != '' && $newA[6] != '已删除'){
                        $newdata[] = $newA;
                    }
                }
            }
        }

        //导出CVS
        $cvsstr = "手机号,卡号,姓名,卡名称,卡类型,项目编号,项目名称,总次数,剩余次数,单次消费金额,剩余金额,失效日期,总剩余次数,总剩余金额\n";
        $filename = $shopname.'_会员套餐信息.csv';
        $cvsstr = iconv('utf-8','gb2312//ignore',$cvsstr);
        foreach($newdata as &$v){
            foreach($v as $k=>&$v1){
                //时间转换
                if($k == 5 || $k == 19) {
                    //$v1 = strtotime($v1);
                }
                //转码
                $cvsdata = iconv('utf-8','gb2312//ignore',$v1);
                $cvsstr .= $cvsdata; //用引文逗号分开
                if($k < 14) {
                    $cvsstr .= ","; //用引文逗号分开
                }
            }
            $cvsstr .= "\n";
        }
        header("Content-type:text/csv");
        header("Content-Disposition:attachment;filename=".$filename);
        header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
        header('Expires:0');
        header('Pragma:public');
        echo $cvsstr;
    }

    /**
     * 获取员工信息下载到CVS
     * @param $html
     * @param $shopname
     */
    public function downStaffCvs($html,$shopname){
        $rules = array(
            //采集tr中的纯文本内容
            'other' => array('tr','html'),
        );
        $newdata = array();
        $data = QueryList::Query($html, $rules)->data;
        foreach ($data as $k=>&$item) {
            $other = explode('</td>', $item['other']);
            if(count($other) > 8) {
                //unset($other[0]);//去掉第一空白项
                $item['other'] = $other;
                foreach ($other as $k1 => &$v1) {
                    $v1 = strip_tags($v1);;
                    $v1 = preg_replace("/\s\n\t/","",$v1);
                    $v1 = str_replace(' ', '', $v1);
                    $v1= trim(str_replace(PHP_EOL, '', $v1));
                }

                $date1 = substr($other[11], 0, 3).' '.substr($other[11], 3, 3).' '.substr($other[11], 19, 4);
                $date1 = date('Y-m-d', strtotime($date1));
                $newdata[$k][0] = "\t".$other[1];
                $newdata[$k][1] = $other[2];
                $newdata[$k][2] = $other[3];
                $newdata[$k][3] = preg_match('/男/', $other[4])?0:1;
                $newdata[$k][4] = $other[9];
                $newdata[$k][5] = str_replace('阴', '', $other[10]);
                $newdata[$k][5] = str_replace('阳', '', $newdata[$k][5]);
                $newdata[$k][5] = str_replace('"', '', $newdata[$k][5]);
                $newdata[$k][6] = $date1;
                $newdata[$k][7] = $other[8];
                $newdata[$k][8] = '';

                //日期格式含有1900，设置为空
                if(preg_match("/1900/isU", $newdata[$k][5])) {
                    $newdata[$k][5] = '';
                }
            }
        }
        unset($newdata[count($newdata)]);
        unset($newdata[count($newdata)]);

        //导出CVS
        $cvsstr = "编号(必填[唯一]),姓名(必填),级别(必填),性别,手机号码,生日,入职时间,身份证号,银行账号\n";
        $filename = $shopname.'_员工信息.csv';
        $cvsstr = iconv('utf-8','gb2312//ignore',$cvsstr);

        foreach($newdata as &$v){
            foreach($v as $k=>&$v1){
                //转码
                $cvsdata = iconv('utf-8','gb2312//ignore',$v1);
                $cvsstr .= $cvsdata; //用引文逗号分开
                if($k < 8) {
                    $cvsstr .= ","; //用引文逗号分开
                }
            }
            $cvsstr .= "\n";
        }
        header("Content-type:text/csv");
        header("Content-Disposition:attachment;filename=".$filename);
        header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
        header('Expires:0');
        header('Pragma:public');
        echo $cvsstr;
    }
}

?>