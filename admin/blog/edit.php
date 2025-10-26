<?php 

    $stmt = $conn->prepare("SELECT * FROM categories");
    $stmt->execute();
    $result = $stmt->get_result();
    $categories = $result->fetch_all(MYSQLI_ASSOC);
    
    $titleError = "";
    $contentError = "";
    $imageError = "";
    $categoryError = "";
    $blog = null;
    if (isset($_GET['id']) && $_GET['id']) {
        $id = $_GET['id'];
        $stmt = $conn->prepare("SELECT * FROM blogs WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $blog = $result->fetch_object();
    }

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

        } else {
            if(empty($imageName)){
                $stmt = $conn->prepare("UPDATE blogs SET title = ?, content = ? WHERE id = ?");
                $stmt->bind_param("ssi", $title, $content, $id);
            } else {
                unlink('../assets/blog-images/' . $blog->image);
                if (in_array($imageType, ['image/jpeg', 'image/png', 'image/gif'])) {
                    move_uploaded_file($imageTmpName, '../assets/blog-images/' . $imageName);
                }
                $stmt = $conn->prepare("UPDATE blogs SET title = ?, content = ?, image = ? WHERE id = ?");
                $stmt->bind_param("sssi", $title, $content, $imageName, $id);
            }
                $result = $stmt->execute();
                if($result){
                    echo "<script>location.href='index.php?page=blogs'</script>";
                    exit(); 
                }
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
                            <input type="text" class="form-control" name="title" value="<?php echo htmlspecialchars($blog->title); ?>">
                            <span class="text-danger"><?php echo $titleError ?: ''; ?></span>
                        </div>
                        <div class="mb-2">
                            <label for="">Category</label>
                            <select name="category_id" id="" class="form-control">
                                <option value=""></option>
                                <?php foreach($categories as $category): ?>
                                    <option value="<?php echo $category['id']; ?>" <?php if($blog->category_id == $category['id']) echo 'selected'; ?>><?php echo $category['name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <span class="text-danger"><?php echo $categoryError ?: ''; ?></span>
                        </div>
                        <div class="mb-2">
                            <label for="">Content</label>
                            <textarea name="content" id="" class="form-control" rows="5"><?php echo htmlspecialchars($blog->content); ?></textarea>
                            <span class="text-danger"><?php echo $contentError ?: ''; ?></span>
                        </div>
                         <div class="mb-2">
                            <label for="">Image</label>
                            <input type="file" name="image" class="form-control">
                            <img src="../assets/blog-images/<?php echo $blog->image; ?>" alt="" width="150" style="margin-top: 10px;">
                            <span class="text-danger"><?php echo $imageError ?: ''; ?></span>

                        </div>
                        <button class="btn btn-primary" name="submit">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>