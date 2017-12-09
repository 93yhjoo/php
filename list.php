<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
<table>
    <tbody colspan="8">
    <tr>
        <td>번호</td>
        <td>아이디</td>
        <td>분류</td>
        <td>이름</td>
        <td>성별</td>
        <td>비밀번호</td>
        <td>연락처</td>
        <td>이메일</td>
    </tr>
        <? include "list_control.php";
        $control=new list_control();
        $control->make_line();
        ?>
    </tbody>

</table>
<?
$control->pagenation();
?>

</body>
</html>