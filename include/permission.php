<?php
// permission code

$login_id=$_SESSION['login_id'];
$db->where('id',$login_id);
$role_id=$db->getValue('users_tbl','role_id');

$db->join("role_permissions rp", "rp.permission_id=p.id", "INNER");
$db->where('rp.role_id',$role_id);
$permissions = $db->get ("permissions p", null, "p.name");



 ?>