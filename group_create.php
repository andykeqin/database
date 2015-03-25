<?php
    include 'auth.php';
    if (!isset($_SESSION['role']) || $_SESSION['role'] != 1) {
        exit;
    }
    include 'db.php';
    $db = new DbHelper();
    if (isset($_POST['name']) && isset($_POST['review'])) {
        $name = trim($_POST['name']);
        $review = intval($_POST['review']);
        if ($name != '') {
            if ($db->executeNonQuery("
                insert into `group`(name,review)
                values('{$name}',{$review})
            ")) {
                header('Location:group.php');
                exit;
            }
        }
    }
    $groups = $db->executeQuery("select * from `group`");
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
            <h3>Create</h3>
            <form action="" method="post" class="form-horizontal">
                <div class="control-group">
                    <label class="control-label" for="inputName">Name</label>
                    <div class="controls">
                        <input type="text" id="inputName" name="name" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="inputReview">Allocate to review</label>
                    <div class="controls">
                        <select id="inputReview" name="review">
                            <option value="0">-- select --</option>
                            <?php foreach ($groups as $group) { ?>
                            <option value="<?php echo $group['id']; ?>"><?php echo $group['name']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <button type="submit" class="btn btn-primary">Create</button>
                    </div>
                </div>
                </form>
            <p>
                <a href="group.php">Back to List</a>
            </p>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>
