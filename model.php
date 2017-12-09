<?php
define("MAXSIZE", 3);
class model{
    private $dbconnect;
    function __construct()
    {
    $this->dbconnect=mysqli_connect("Localhost","root","autoset");
    mysqli_select_db($this->dbconnect,"midtermexam");
    }
    function __destruct()
    {
        // TODO: Implement __destruct() method.
        mysqli_close($this->dbconnect);
    }
        function check_user($id){
        $sql="select * from userinfo where userid='$id'";
           return mysqli_fetch_object(mysqli_query($this->dbconnect,$sql));
        }
    function user_register($object){
        $sql="insert into userinfo(userid,classification,name,gender,password,phone,email)";
        $sql.="values('$object[0]','$object[3]','$object[2]','$object[4]','$object[1]','$object[5]','$object[6]')";
        mysqli_query($this->dbconnect,$sql);
    }
    function user_delete($id){
        $sql="delete from userinfo where userid='$id'";
        return mysqli_query($this->dbconnect,$sql);

    }
    function update($object){
        $sql="update userinfo set 
              userid='$object[1]', password='$object[2]', name='$object[3]',
              classification='$object[4]',gender='$object[5]',phone='$object[6]',
              email='$object[7]' where sysid={$object[0]}";
        return mysqli_query($this->dbconnect,$sql);
    }
    function listup($argnum){
        $start=($argnum-1)*MAXSIZE;
        $sql="select * from userinfo limit $start,".MAXSIZE;
        return mysqli_query($this->dbconnect,$sql);

    }
    function count_user(){
        $sql="select count(*) from userinfo";
        return mysqli_query($this->dbconnect,$sql);
    }
}