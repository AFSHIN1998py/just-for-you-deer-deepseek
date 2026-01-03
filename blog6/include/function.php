<?php
function counting($id,$table,$field)
{
    global $conn;
    $countpost=$conn->query("select count(id) as countRow from $table where $field=$id")->fetch();
    return $countpost['countRow'];
}
function deleting($id,$table)
{
    global $conn;
    $delete=$conn->query("delete from $table where id=$id");
}
function updateComment($id)
{
    global $conn;
    $update=$conn->query("update comments set status=1 where id=$id");
}

?>