<?php

//$conn = oci_connect('aaa', 'aaa', 'localhost/XE');
//$s = new PDO("oci:dbname=//127.0.0.1:1521/XE,XX1,xulei");
 
// oracle php oracle测试成功。
// php平台 phpStudy 2014.10.02
// orcle支持配置实现教程：http://blog.csdn.net/wuya145/article/details/14231267
/*
好像是下面第三种方式测试通过的。 中间注意版本和oracle client的安装.
win10 X64测试通过的。


折腾了好久的php关于oracle扩展问题终于解决了，

网上查找了好多资料大致解决办法有以下三种：

一.去Oracle官网下载“Instant Client Package - Basic”，点击这里或百度云盘,下载完成后将其解压在D:\Program Files\instantclient_10_2，并且将此目录加入系统环境变量Path中，依次单击“开始”->“设置”->“控制面板”->“系统”->“高级”->“环境变量”，编辑系统变量列表中的 PATH。
编辑 php.ini，并不要将 OCI8 扩展设为注释：
extension=php_oci8.dll
将 extension_dir 指令设置为完整的 PHP 扩展 DLL 路径。它们位于“ext”中。
重新启动 Apache。
要检查是否配置了扩展，请在 web 服务器可以读取的地方创建一个简单的 PHP 脚本。
phpinfo();
?>
使用“http://”URL 将此脚本加载到浏览器中。页面如果显示“OCI8 Support enabled”的“oci8”部分说明安装成功。

二.Oracle官网提供的方法【前往】，大致意思是：
1、下载32位Oracle Instantclient Basic版； 
2、解压缩至 C:\WINDOWS\SYSWOW64\INSTANTCLIENT；
3、系统环境变量PATH中，在Oracle数据库Home库之前，添加 C:\WINDOWS\SYSTEM32\INSTANTCLIENT（注意这一步目录名的值，是SYSTEM32而不是SYSWOW64）这么做的理由是，Windows对指向 C:\WINDOWS\SYSTEM32 的32应用程序，实际上也会查找 C:\WINDOWS\SYSWOW64 目录。而64位应用程序则会忽略 C:\WINDOWS\SYSTEM32 目录，并且能正确定位到 64 位的Oracle数据库上。这样，就通过Instantclient的客户端库，连接到Oracle数据库了。

三.直接下载覆盖到Apache的bin目录。
把instantclient_.xxxx.zip安装包中oci.dllorannzsbb11.dlloraociei11.dll解压到apache的bin目录下，重启apache就可以了。

注 ：我是应用第三种方案才解决问题的。需注意的是Window_x64一定要使用instantclient-basic-windows.x64.xxx.zip版本的扩展包，否则扩展还是无法安装成功。如果使用Navicat 连接oracle数据库需要使用instantclient_win32版本中的oci.dll才能连接成功。

*/

 $db = new PDO("oci:dbname=127.0.0.1:1521/XE;charset=UTF8","aaa","aaa" ,array(PDO::ATTR_PERSISTENT => true));

 

 if($_GET['delid']!="")
 {
	echo $sql = " delete from stu where ID   = '{$_GET['delid']}'   ";

 		 $db->exec($sql);

 }
 if($_POST)
 {

 		$sql = " insert into stu( STUNAME , qq  ,age ,ADDRESS ) values ( '{$_POST['uname']}','{$_POST['qq']}' , '{$_POST['age']}', '{$_POST['addr']}') ";

 		 $db->exec($sql);
 }

 function getRandChar($length){
   $str = null;
   $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
   $max = strlen($strPol)-1;

   for($i=0;$i<$length;$i++){
    $str.=$strPol[rand(0,$max)];//rand($min,$max)生成介于min和max两个数之间的一个随机整数
   }

   return $str;
  }

for($i=0;$i<300000;$i++)
{
            $sql = " insert into stu( STUNAME , qq  ,age ,ADDRESS ) values ( 'TT ". getRandChar(2) . " " .getRandChar(4) ."','". rand(10000,30000) ."' , '" .rand(4,77). "', '".  getRandChar(5) ."') ";

         $db->exec($sql);
}
 exit();
       /*
 }
  $db->exec("  create table t2(a int , b varchar(20) ) ");

    $db->exec(" insert into t2 values(1253,'asd123')");
        $db->exec(" insert into t2 values(12543,'asd123')");
 */

 $sql = "select * from stu order by id  ";  
 
        $rs = $db->query($sql);  

        $l  = $rs->fetchAll();

 
echo "<hr/>";

        foreach  ($l as $r)
        {
echo " {$r['ID']}：    {$r['STUNAME']}   {$r['QQ']}   {$r['AGE']}   {$r['ADDRESS']}  <a href=?delid={$r['ID']}>删除</a>  <br/>";

        }



 $sql = "SELECT * FROM 
(SELECT A.*, ROWNUM RN FROM STU A 
WHERE ROWNUM <= 8
)
WHERE RN >= 4";  
 
        $rs = $db->query($sql);  

        $l  = $rs->fetchAll();

 
echo "<hr/>";

        foreach  ($l as $r)
        {
echo " {$r['ID']}：    {$r['STUNAME']}   {$r['QQ']}   {$r['AGE']}   {$r['ADDRESS']}  <a href=?delid={$r['ID']}>删除</a>  <br/>";

        }


 ?>
  <form method="post" action="">
	

 
<br>
	<br>uname :<input type="text" name="uname" /></input>
		<br>age:<input  type="text" name="age"></input>
		<br>addr:<input  type="text" name="addr"></input>
	<br>	qq: <input  type="text"  name="qq"></input>
	<br>	<input type="submit" value="提交"> </input>
 </form>
 