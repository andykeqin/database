<?php
    include 'auth.php';
    if (!isset($_GET['id'])) {
        exit;
    }
    $id = intval($_GET['id']);
    include 'db.php';
    $db = new DbHelper();
    $report = $db->executeQuery("
        select a.*,b.name as `group`,c.firstname,c.lastname
        from report a,`group` b,`user` c
        where a.id={$id} and a.authorid=c.id and a.groupid=b.id
    ");
    if ($report && count($report) > 0) {
        $report = $report[0];
    }
    else {
        exit;
    }
    if (isset($_POST['assessment']) && isset($_POST['comment'])) {
        $assessment = intval($_POST['assessment']);
        $comment = $_POST['comment'];
        $createtime = time();
        if (!$db->executeNonQuery("
            insert into `comment`(userid,reportid,assessment,content,createtime)
            values({$_SESSION['id']},{$id},{$assessment},'{$comment}',{$createtime})
        ")) {
            exit;
        }
    }
    $comments = $db->executeQuery("
        select a.*,b.name as `group`,c.firstname,c.lastname 
        from `comment` a,`group` b,`user` c
        where a.reportid={$id} and b.id=c.groupid and a.userid=c.id
    ");
    $hasComment = $db->executeQuery("
        select * from `comment` where userid={$_SESSION['id']}
    ");
    $group = $db->executeQuery("select * from `group` where id={$_SESSION['groupid']}");
    $group = $group[0];
    $ranks = $db->executeQuery("
        select a.reportid,sum(a.assessment) as sum,b.groupid
        from `comment` a,report b
        where a.reportid=b.id
        group by reportid
        order by sum desc
    ");
    $rank = count($ranks);
    foreach ($ranks as $key => $item) {
        if ($item['groupid'] == $_SESSION['groupid']) {
            $rank = $key;
            break;
        }
    }
    $rank++;
?>
<?php include 'header.php'; ?>
<?php include 'nav.php'; ?>
<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12">
            <h3><?php echo $report['name']; ?></h3>
            <p>
                Author: <?php echo $report['firstname'] . ' ' . $report['lastname']; ?>
            </p>
            <p>
                Group: <?php echo $report['group']; ?>
            </p>
            <p>
                <?php readfile($report['url']); ?>
            </p>
            <h3>Marks and Comments</h3>
            <?php if ($report['groupid'] == $_SESSION['groupid']) { ?>
            <h4>rank: <?php echo $rank; ?></h4>
            <?php } ?>
            <ul>
                <?php foreach ($comments as $c) { ?>
                <li><?php echo $c['firstname'] . ' ' . $c['lastname']; ?>(<?php echo $c['group']; ?>): <?php echo $c['content']; ?>(<?php echo $c['assessment']; ?>)</li>
                <?php } ?>
            </ul>
            <?php if ($group['review'] == $report['groupid'] && count($hasComment) == 0) { ?>
            <form action="" method="post">
                <p>
                    <label for="txt-assessment">Mark (Please enter the mark from 0 to 100)</label>
                    <input type="text" id="txt-assessment" name="assessment" />
                </p>
                <p>
                    <label for="txt-comment">Comment (Please enter your comments here.)</label>
                    <input type="text" id="txt-comment" name="comment" />
                </p>
                <p>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </p>
            </form>
            <?php } ?>
            <p>
                <a href="report.php">Go Back</a>
            </p>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>
