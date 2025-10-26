<?php
// Include database connection file
        $blogId = isset($_GET['blog_id']) ? (int) $_GET['blog_id'] : 0;
        $stmt = $conn->prepare("SELECT comments.id, comments.text, comments.created_at, users.name 
                        FROM comments 
                        INNER JOIN users ON comments.user_id = users.id 
                        WHERE comments.blog_id=? 
                        ORDER BY comments.created_at DESC");

        $stmt->bind_param("i", $blogId);
        $stmt->execute();
        $result = $stmt->get_result();  
        $comments = $result->fetch_all(MYSQLI_ASSOC);


?>
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Blog Comments</h6>
        <a href="index.php?page=blogs" class="btn btn-primary"> << Back</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Comments</th>
                        <th>Name</th>
                        <th>Created_At</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($comments as $comment): ?>
                    <tr>
                        <td><?php echo $comment['id'] ?></td>
                        <td><?php echo $comment['text'] ?></td>
                        <td><?php echo $comment['name'] ?></td>
                        <td><?php echo $comment['created_at'] ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php if (empty($comments)): ?>
                <p class="text-danger">No comments found for this blog.</p>
            <?php endif; ?>
        </div>
    </div>
</div>
