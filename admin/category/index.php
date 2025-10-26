<?php 
    $stmt = $conn->prepare("SELECT * FROM categories");
    $stmt->execute();

    $result = $stmt->get_result(); // get mysqli_result object
    $categories = $result->fetch_all(MYSQLI_ASSOC);

     if (isset($_POST['delete'])) {
        $id = $_POST['id'];
        $stmt = $conn->prepare("DELETE FROM categories WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        echo "<script>location.href='index.php?page=categories'</script>";
        exit(); 
    }

?>
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Category List</h6>
        <a href="index.php?page=categories-create" class="btn btn-primary"><i class="fas fa-plus"></i> Add New</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categories as $category): ?>
                    <tr>
                        <td><?php echo $category['id'] ?></td>
                        <td><?php echo $category['name'] ?></td>
                        <td>
                            <form method="post">
                                <input type="hidden" name="id" value="<?php echo $category['id'] ?>">
                                <a href="index.php?page=categories-edit&id=<?php echo $category['id'] ?>" class="btn btn-sm btn-info"><i class="fas fa-pen"></i></a>
                                <button type="submit" class="btn btn-sm btn-danger" name="delete"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>