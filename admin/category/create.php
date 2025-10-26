<?php 
$error = "";
    if (isset($_POST['submit'])) {
        $name = $_POST['name'];

        if (empty($name)) {
            $error = "Name is required";
        } else {
            $stmt = $conn->prepare("INSERT INTO categories (name) VALUES ('$name')");
            $stmt->execute();
            // header("Location: index.php?page=categories");
            echo "<script>location.href='index.php?page=categories'</script>";
            exit();

    }
}
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <div class="card-header py-3 d-flex align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Category Crate Form</h6>
                        <a href="index.php?page=categories" class="btn btn-primary"> << Back</a>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST">
                        <div class="mb-2">
                            <label for="">Name</label>
                            <input type="text" class="form-control" name="name">
                            <span class="text-danger"><?php echo $error ?? ''; ?></span>
                        </div>
                        <button class="btn btn-primary" name="submit">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>