<?php
    include 'auth.php';
    if (!isset($_SESSION['role']) || $_SESSION['role'] != 1) {
        exit;
    }
    if (!isset($_GET['id'])) {
        exit;
    }
    $id = intval($_GET['id']);
    include 'db.php';
    $db = new DbHelper();
    $group = $db->executeQuery("select * from `group` where id={$id}");
    if (!$group || count($group) == 0) {
        exit;
    }
    if ($db->executeNonQuery("delete from `group` where id={$id}")) {
        header('Location:group.php');
        exit;
    }