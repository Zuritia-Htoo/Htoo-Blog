<?php 

    // Fetch categories from the database
    $stmt = $conn->prepare("SELECT * FROM categories");
    $stmt->execute();
    $result = $stmt->get_result();
    $categories = $result->fetch_all(MYSQLI_ASSOC);

    $titleError = "";
    $contentError = "";
    $imageError = "";
    $categoryError = "";

    if (isset($_POST['submit'])) {
        $imageName = $_FILES['image']['name'];
        $imageTmpName = $_FILES['image']['tmp_name'];
        $imageType = $_FILES['image']['type'];


        $title = $_POST['title'];
        $categoryId = $_POST['category_id'];
        $content = $_POST['content'];
        if (empty($title)) {
            $titleError = "Title is required";
        } elseif (empty($categoryId)) {
            $categoryError = "Category is required";
        } elseif (empty($content)) {
            $contentError = "Content is required";
        } elseif (empty($imageName)) {
            $imageError = "Image is required";
        } else {
            if (isset($_FILES['image'])) {
                $imageName = uniqid() . '_' . $imageName;
                if (in_array($imageType, ['image/jpeg', 'image/png', 'image/gif'])) {
                    move_uploaded_file($imageTmpName, '../assets/blog-images/' . $imageName);
                }
            }
            $userId = isset($_SESSION['user']->id) ? $_SESSION['user']->id : null;
            $stmt = $conn->prepare("INSERT INTO blogs (title, category_id, image, content, user_id, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
            $stmt->bind_param("ssssi", $title, $categoryId, $imageName, $content, $userId);
            $stmt->execute();
            header("Location: index.php?page=blogs");
            echo "<script>location.href='index.php?page=blogs'</script>";
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
                        <h6 class="m-0 font-weight-bold text-primary">BLOG Crate Form</h6>
                        <a href="index.php?page=blogs" class="btn btn-primary"> << Back</a>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data">
                        <div class="mb-2">
                            <label for="">Title</label>
                            <input type="text" class="form-control" name="title">
                            <span class="text-danger"><?php echo $titleError ?: ''; ?></span>
                        </div>
                        <div class="mb-2">
                            <label for="">Category</label>
                            <select name="category_id" id="" class="form-control">
                                <option value="">Select Category</option>
                                <?php foreach($categories as $category): ?>
                                    <option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <span class="text-danger"><?php echo $categoryError ?: ''; ?></span>
                        </div>
                        <div class="mb-2">
                            <label for="">Content</label>
                            <textarea name="content" id="" class="form-control" rows="5"></textarea>
                            <span class="text-danger"><?php echo $contentError ?: ''; ?></span>
                        </div>
                         <div class="mb-2">
                            <label for="">Image</label>
                            <input type="file" name="image" class="form-control">
                        </div>
                        <button class="btn btn-primary" name="submit">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>