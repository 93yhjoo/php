<?php
include "model.php";
define("URL","http://localhost:8080/list.php?page");
define("PAGESIZE",3);
class list_control{
    private $model;
    private $page;
    private $maxuser;
    function __construct()
    {
        $this->model=new model();
        $this->maxuser =mysqli_fetch_row($this->model->count_user())[0];
        if(!isset($_GET['page']))
        $this->page=1;
        else{
            $this->page=$_GET['page'];
        }
    }

    function make_line(){
       $result= $this->model->listup($this->page);
       $size=mysqli_num_rows($result);
       for($i=0;$i<$size;$i++){
          $row= mysqli_fetch_row($result);
            echo "<tr>";
           echo "<td>$row[0]</td>";
           echo "<td>$row[1]</td>";
           echo "<td>$row[2]</td>";
           echo "<td>$row[3]</td>";
           echo "<td>$row[4]</td>";
           echo "<td>$row[5]</td>";
           echo "<td>$row[6]</td>";
           echo "<td>$row[7]</td>";
           echo "</tr>";
       }
    }
    function pagenation(){
        $lengh=($this->page/ PAGESIZE);
        if(is_int($lengh)){
            $pre=($lengh-1)*PAGESIZE;
            $future = ceil(($this->page) / PAGESIZE) * PAGESIZE+1;
        }
        else {
            $pre = floor(($this->page) / PAGESIZE) * PAGESIZE;
            $future = ceil(($this->page) / PAGESIZE) * PAGESIZE+1;
        }
            if($pre!=0) {
                $location = URL . "=$pre";
                echo "<a href='$location'>&lt;</a>";
            }
           for ($i = $pre;
                 $i < $future-1; $i++) {
                    if($i>=ceil($this->maxuser/MAXSIZE)){
                        break;
                    }
                    $thing = $i+1;
                    $location = URL . "=$thing";
                    echo "<a href='$location'>$thing</a>";

            }
        if($future<=ceil($this->maxuser/MAXSIZE)) {
            $location = URL . "=$future";
            echo "<a href='$location'>&gt;</a>";
        }
    }
}