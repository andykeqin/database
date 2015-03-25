<?php
    include 'auth.php';
    if (!isset($_SESSION['role']) || $_SESSION['role'] != 1) {
        exit;
    }
    include 'db.php';
    $db = new DbHelper();
    $groups = $db->executeQuery("
        select a.id,a.name,(select name from `group` where a.review=id) as reviewgroup
        from `group` a
    ");
?>
<?php include 'header.php'; ?>
<?php include 'nav.php'; ?>
<div class="container-fluid">
    <div class="row-fluid">
        <div class="span3">
            <div class="well sidebar-nav">
                <ul class="nav nav-list">
                    <li class="nav-header">DASHBOARD</li>
                    <li class="active"><a href="group.php">Group</a></li>
                    <li><a href="student.php">Student</a></li>
                </ul>
            </div>
        </div>
        <div class="span9">
            <h3>Group</h3>
            <p>
                <a href="group_create.php">Create New</a>
            </p>
            <table class="table">
                <thead>
                    <tr>
                        <th>Group Name (Please enter the group name as format group1. )</th>
                        <th>Allocate to review</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($groups as $group) { ?>
                    <tr>
                        <td><?php echo $group['name']; ?></td>
                        <td><?php echo $group['reviewgroup']; ?></td>
                        <td>
                            <a href="group_edit.php?id=<?php echo $group['id']; ?>">Edit</a> | <a href="javascript:if(confirm('Delete?'))location.href='group_delete.php?id=<?php echo $group['id']; ?>';">Delete</a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>
