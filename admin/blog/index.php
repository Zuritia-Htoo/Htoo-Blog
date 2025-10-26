<?php 
    $blogstmt = $conn->prepare("SELECT blogs.*, categories.name AS category_name, 
    users.name AS author_name FROM blogs 
    INNER JOIN categories ON blogs.category_id = categories.id 
    INNER JOIN users ON blogs.user_id = users.id ORDER BY blogs.created_at DESC");
    $blogstmt->execute();

    $result = $blogstmt->get_result();
    $blogs = $result->fetch_all(MYSQLI_ASSOC);

    if (isset($_POST['delete'])) {
        $id = $_POST['id'];
        $selectStmt = $conn->prepare("SELECT image FROM blogs WHERE id = ?");
        $selectStmt->bind_param("i", $id);
        $selectStmt->execute();

        $result = $selectStmt->get_result();
        $blog = $result->fetch_object();
        $stmt = $conn->prepare("DELETE FROM blogs WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        if ($blog && !empty($blog->image)) {
            unlink('../assets/blog-images/' . $blog->image);
        }
        echo "<script>location.href='index.php?page=blogs'</script>";
        exit();
    }

?>
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">blog </h6>
        <a href="index.php?page=blogs-create" class="btn btn-primary"><i class="fas fa-plus"></i> Add New</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Content</th>
                        <th>Author</th>
                        <th>Created_At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($blogs as $blog): ?>
                    <tr>
                        <td><?php echo $blog['id'] ?></td>
                        <td>
                            <img src="../assets/blog-images/<?php echo $blog['image'] ?>" alt="" width="100">
                        </td>
                        <td><?php echo $blog['title'] ?></td>
                        <td><?php echo $blog['category_name'] ?></td>
                        <td>
                            <div style="max-width: 300px; max-height: 200px; overflow: auto;">
                            <p><?php echo $blog['content'] ?></p>
                        </div>
                        </td>
                        <td><?php echo $blog['author_name'] ?></td>
                        <td><?php echo $blog['created_at'] ?></td>
                        <td>
                            <div class="d-flex align-items-center gap-2"> 
                                
                            </div>
                            <form method="post">
                                <input type="hidden" name="id" value="<?php echo $blog['id'] ?>">
                                <a href="index.php?page=blogs-edit&id=<?php echo $blog['id'] ?>" class="btn btn-sm m-1 btn-success" title="Edit Blog"><i class="fas fa-pen"></i></a>

                                <button type="submit" class="btn btn-sm m-1 btn-danger" name="delete" onclick="return confirm('Are you sure you want to delete this blog?');" title="Delete Blog"><i class="fas fa-trash"></i></button>

                                <a href="index.php?page=blogs-comments&blog_id=<?php echo $blog['id']; ?>" class="btn btn-info m-1" title="View Comments"><i class="fas fa-comment"></i></a>

                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
