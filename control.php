<?php
include "model.php";
class control{
    private $object;

    function check_mode($select){

        switch ($select){
            case "register":$this->check_register();
                                break;
            case "delete": $this->check_delete();break;
            case "modify":$this->check_modify();break;
            //ajax를 통해 들어오게 된 경우
            case "check":$this->check_userinfo();break;
            default:break;
        }


    }
    function check_userinfo(){
        $model=new model();
        $obj=$model->check_user($_POST['userid']);
        if(is_object($obj)){
           $json=json_encode($obj);
            echo $json;
        }
        else{
            echo "fail";
        }

    }
    function check_modify(){
        $this->object=array($_POST['sysid'],$_POST['userid'],$_POST['userpassword'],
            $_POST['username'], $_POST['classification'],
            $_POST['gender'],$_POST['phone'],$_POST['email']);
        $flag=true;
        for($i=0;$i<sizeof($this->object);$i++) {
            if($this->object[$i]==""){
               $flag=false;
                break;
                }
            }
        //무결성 검사결과 null이 없다면
        if($flag==true){
            $model=new model();
            //유저 정보 기입
            $model->update($this->object);
            echo "<script>alert('수정완료.')</script>";
            echo "<script>location.replace('main.html')</script>";
        }
        else{
            echo "<script>history.back()</script>";
            echo "<script>alert('전부 채워 주세요.')</script>";
        }
        }


    //무결성  검사
    function check_register(){
        $this->object=array($_POST['userid'],$_POST['userpassword'],
            $_POST['username'], $_POST['classification'],
             $_POST['gender'],$_POST['phone'],$_POST['email']);

        $flag=true;
        for($i=0;$i<sizeof($this->object);$i++) {
            if($this->object[$i]==""){
            $flag=false;
           switch ($i){
               case 0:echo "userid 결여되었습니다.<br>"; break;
               case 1:echo "password 결여되었습니다.<br>"; break;
               case 2:echo "username 결여되었습니다.<br>"; break;
               case 5:echo "phone 결여되었습니다.<br>";break;
               case 6:echo "email 결여되었습니다.<br>";break;

           }

        }
     }
     //무결성 검사결과 null이 없다면
     if($flag==true){
            $model=new model();
            //유저 정보 기입
            $model->user_register($this->object);
         echo "<script>alert('가입완료되었습니다.')</script>";
         echo "<script>location.replace('main.html')</script>";
     }
     else{
         include "register.html";
         echo "<script>";
             echo "document.getElementsByName('userid')[0].value='{$this->object[0]}';";
             echo "document.getElementsByName('userpassword')[0].value='{$this->object[1]}';";
             echo "document.getElementsByName('username')[0].value='{$this->object[2]}';";

             if($this->object[3]=="staff")
             echo "document.getElementsByName('classification')[0].selectedIndex='0';";
            else
             echo "document.getElementsByName('classification')[0].selectedIndex='1';";
         if($this->object[4]=="male")
             echo "document.getElementsByName('gender')[0].selectedIndex='0';";
         else
             echo "document.getElementsByName('gender')[0].selectedIndex='1';";

             echo "document.getElementsByName('phone')[0].value='{$this->object[5]}';";
             echo "document.getElementsByName('email')[0].value='{$this->object[6]}';";

         echo "</script>";
     }
    }
    //아이디,비밀번호 무결성 검사
    function check_delete(){
        $model=new model();
        $obj=$model->check_user($_POST['userid']);
        //id와 일치하는 객체가 반환이 된다면..
        if(is_object($obj)) {
            //그리고 비밀번호도 일치한다면..
            if ($_POST['userpassword'] == $obj->password) {
                $model->user_delete($_POST['userid']);
                echo "<script>alert('삭제 완료 되었습니다..')</script>";
                echo "<script>location.replace('main.html')</script>";
            }
            else{
                echo "<script>alert('암호가 일치 하지 않습니다.')</script>";
                echo "<script>location.replace('delete.html')</script>";
            }
        }
        else{
            echo "<script>alert('등록되지 않은 ID입니다')</script>";
            echo "<script>location.replace('delete.html')</script>";
        }
    }
}

$user=new control();
$user->check_mode($_POST['mode']);