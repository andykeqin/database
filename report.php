<?php
    include 'auth.php';
    include 'db.php';
    $db = new DbHelper();
    $reports = $db->executeQuery("
        select a.*,b.name as `group`,c.firstname,c.lastname
        from report a,`group` b,`user` c
        where a.groupid=b.id and a.authorid=c.id and a.groupid={$_SESSION['groupid']}
        order by a.createtime desc
    ");
    $group = $db->executeQuery("select * from `group` where id={$_SESSION['groupid']}");
    $group = $group[0];
    $reviews = $db->executeQuery("
        select a.*,b.name as `group`,c.firstname,c.lastname
        from report a,`group` b,`user` c
        where a.groupid=b.id and a.authorid=c.id and a.groupid={$group['review']}
        order by a.createtime desc
    ");
?>
<?php include 'header.php'; ?>
<?php include 'nav.php'; ?>
<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12">
            <h3>Report</h3>
            <?php if (count($reports) == 0) { ?>
            <p>
                <a href="report_create.php">Create New</a>
            </p>
            <?php } else { ?>
            <p>
                <a href="javascript:alert('report exists!');">Create New</a>
            </p>
            <?php } ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Group</th>
                        <th>Create Time</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reports as $report) { ?>
                    <tr>
                        <td><?php echo $report['name']; ?></td>
                        <td><?php echo $report['firstname'] . ' ' . $report['lastname']; ?></td>
                        <td><?php echo $report['group']; ?></td>
                        <td><?php echo date('Y-m-d H:i', $report['createtime']); ?></td>
                        <td>
                            <a href="report_details.php?id=<?php echo $report['id']; ?>">Details</a><?php if ($report['authorid'] == $_SESSION['id']) { ?> | <a href="javascript:if(confirm('Delete?'))location.href='report_delete.php?id=<?php echo $report['id']; ?>';">Delete</a><?php } ?>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            <h3>Allocate to review</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Group</th>
                        <th>Create Time</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reviews as $review) { ?>
                    <tr>
                        <td><?php echo $review['name']; ?></td>
                        <td><?php echo $review['firstname'] . ' ' . $review['lastname']; ?></td>
                        <td><?php echo $review['group']; ?></td>
                        <td><?php echo date('Y-m-d H:i', $review['createtime']); ?></td>
                        <td>
                            <a href="report_details.php?id=<?php echo $review['id']; ?>">Details</a><?php if ($review['authorid'] == $_SESSION['id']) { ?> | <a href="javascript:if(confirm('Delete?'))location.href='report_delete.php?id=<?php echo $review['id']; ?>';">Delete</a><?php } ?>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>
