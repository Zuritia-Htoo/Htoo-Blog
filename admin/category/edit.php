<?php 
    $nameError = "";
    $cateID = $_GET['id'];

    $stmt = $conn->prepare("SELECT * FROM categories WHERE id = ?");
    $stmt->bind_param("i", $cateID);
    $stmt->execute();
    $category = $stmt->get_result()->fetch_assoc();

    $nameError = "";
    if(isset($_POST['update'])){
        $name = $_POST['name'];

        if(empty($name)){
            $nameError = "Name is required";
        } else {
            $stmt = $conn->prepare("UPDATE categories SET name = ? WHERE id = ?");
            $stmt->bind_param("si", $name, $cateID);
            $stmt->execute();

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
                        <h6 class="m-0 font-weight-bold text-primary">Category Update Form</h6>
                        <a href="index.php?page=categories" class="btn btn-primary"> << Back</a>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST">
                        <div class="mb-2">
                            <label for="">Name</label>
                            <input type="text" class="form-control" name="name" value="<?php echo htmlspecialchars($category['name']); ?>">  
                            <span class="text-danger"><?php echo $nameError; ?></span>
                        </div>
                        <button class="btn btn-primary" name="update">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>