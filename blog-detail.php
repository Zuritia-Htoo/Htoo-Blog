<?php
    require_once ('admin/config/db.php');
    require_once ('layout/header.php');
    require_once ('layout/navbar.php');

    // Fetch categories for the sidebar 
    $stmt_categories = $conn->prepare("SELECT * FROM categories");
    $stmt_categories->execute();
    $result_categories = $stmt_categories->get_result();
    $categories = $result_categories->fetch_all(MYSQLI_ASSOC);

    // Fetch some blogs for the sidebar
    $blogStmt = $conn->prepare("SELECT * FROM blogs ORDER BY created_at DESC LIMIT 4");
    $blogStmt->execute();
    $blogResult = $blogStmt->get_result();
    $recent_blogs = $blogResult->fetch_all(MYSQLI_ASSOC);

    // Check if we are viewing a category list
    if (isset($_GET['category'])) {
        $categoryId = $_GET['category'];
        $stmt = $conn->prepare("SELECT blogs.id, blogs.title, blogs.content, blogs.image, blogs.created_at, users.name, categories.name AS category_name FROM blogs INNER JOIN users ON blogs.user_id = users.id INNER JOIN categories ON blogs.category_id = categories.id WHERE blogs.category_id = ? ORDER BY blogs.id DESC");
        $stmt->bind_param("i", $categoryId);
        $stmt->execute();
        $result = $stmt->get_result();
        $blogs = $result->fetch_all(MYSQLI_ASSOC);
        $page_title = "Blogs in Category"; 
    } elseif (isset($_GET['id'])) {
        $blogID = $_GET['id'];
        $stmt = $conn->prepare("SELECT blogs.id, blogs.title, blogs.content, blogs.image, blogs.created_at, users.name FROM blogs INNER JOIN users ON blogs.user_id = users.id WHERE blogs.id = ? LIMIT 1");
        $stmt->bind_param("i", $blogID);
        $stmt->execute();
        $result = $stmt->get_result();
        $blog = $result->fetch_assoc();
        $page_title = $blog['title']; 
    } else {
        // Default: show all recent blogs if no ID or category is specified
        $stmt = $conn->prepare("SELECT blogs.id, blogs.title, blogs.content, blogs.image, blogs.created_at, users.name, categories.name AS category_name FROM blogs INNER JOIN users ON blogs.user_id = users.id INNER JOIN categories ON blogs.category_id = categories.id ORDER BY blogs.id DESC LIMIT 4");
        $stmt->execute();
        $result = $stmt->get_result();
        $blogs = $result->fetch_all(MYSQLI_ASSOC);
        $page_title = "All Blogs"; 
    }
    // Handle comment submission
   if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submitComment'])) {
    if (isset($_SESSION['user'])) {
        $text = trim($_POST['comment'] ?? '');
        $user_id = (int) $_SESSION['user']->id;
        $blogID = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        
        if (!empty($text) && $blogID > 0) {
            $stmt = $conn->prepare("INSERT INTO comments (text, blog_id, user_id, created_at) VALUES (?, ?, ?, NOW())");
            $stmt->bind_param("sii", $text, $blogID, $user_id);

            if ($stmt->execute()) {
                echo "<script>alert('Comment submitted successfully.');</script>";
            } else {  
                echo "<script>alert('Error: " . $stmt->error . "');</script>";
            }
        } else {
            echo "<script>alert('Comment cannot be empty or blog not found.');</script>";
        }
    } else {
        echo "<script>alert('You must be logged in to comment.');</script>";
    }
}
    // Fetch comments for the current blog post
    if (isset($blogID)) {
        $stmt = $conn->prepare("SELECT comments.*, users.name FROM comments INNER JOIN users ON comments.user_id = users.id WHERE comments.blog_id = ? ORDER BY comments.created_at DESC");
        $stmt->bind_param("i", $blogID);
        $stmt->execute();
        $result = $stmt->get_result();  
        $blog_comments = $result->fetch_all(MYSQLI_ASSOC);
    }
?>

<div id="blog">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h3 data-aos="fade-right" data-aos-duration="800"><?php echo $page_title; ?></h3>
                <div class="heading-line" data-aos="fade-left" data-aos-duration="800"></div>

                <?php if (isset($_GET['category'])): ?>
                    <?php if (!empty($blogs)): ?>
                        <?php foreach($blogs as $blog_item): ?>
                            <div class="card my-3" data-aos="fade" data-aos-duration="800">
                                <div class="card-body p-0">
                                    <div class="img-wrapper">
                                        <img src="assets/blog-images/<?php echo $blog_item['image']; ?>" class="img-fluid" alt="">
                                    </div>
                                    <div class="content p-3">
                                        <h5 class="fw-semibold"><?php echo $blog_item['title']; ?></h5>
                                        <div class="mb-3"><?php echo $blog_item['created_at']; ?> | by <?php echo $blog_item['name']; ?></div>
                                        <p>
                                            <?php echo substr($blog_item['content'], 0, 150);?>
                                            <a href="blog-detail.php?id=<?php echo $blog_item['id']; ?>" class="text-decoration-none">See More</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No blogs found in this category.</p>
                    <?php endif; ?>
                <?php elseif (isset($_GET['id']) && !isset($_GET['category'])): ?>
                    <?php if ($blog): ?>
                        <div class="card my-3" data-aos="fade-up" data-aos-duration="800">
                            <div class="card-body p-0">
                                <div class="img-wrapper">
                                    <img src="assets/blog-images/<?php echo $blog['image']; ?>" class="img-fluid" alt="">
                                </div>
                                <div class="content p-3">
                                    <h5 class="fw-semibold"><?php echo $blog['title']; ?></h5>
                                    <div class="mb-3"><?php echo $blog['created_at']; ?> | by <?php echo $blog['name']; ?></div>
                                    <p><?php echo $blog['content'];?></p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="comment">
                            <?php if(isset($_SESSION['user'])): ?>
                            <h5 data-aos="fade-right" data-aos-duration="800">Leave a Comment</h5>
                            <form method="post" data-aos="fade-left" data-aos-duration="800">
                                <div class="mb-2">
                                    <textarea name="comment" rows="5" class="form-control"></textarea>
                                </div>
                                <button class="btn my-2" name="submitComment">Submit</button>
                                </form>
                                <?php else: ?>
                                    <a href="#signIn" data-bs-toggle="offcanvas" aria-controls="staticBackdrop" class="btn mb-3">Sign in to comment</a>
                            
                            <?php endif; ?>
                            <h6 class="fw-bold">User's Comments</h6>
                            <?php if (!empty($blog_comments)): ?>
                                <?php foreach ($blog_comments as $comment): ?>
                                    <div class="card card-body my-3" data-aos="fade-right" data-aos-duration="800">
                                        <h6><?php echo htmlspecialchars($comment['name']); ?></h6>
                                        <p><?php echo htmlspecialchars($comment['text']); ?></p>
                                        <div class="mt-3">
                                            <span class="float-end"><?php echo $comment['created_at']; ?></span>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                                <?php else: ?>
                                    <p>No comments yet. Be the first to comment!</p>
                                <?php endif; ?>

                        </div>
                    <?php else: ?>
                        <p>Blog not found.</p>
                    <?php endif; ?>
                <?php else: ?>
                    <?php if (!empty($blogs)): ?>
                         <?php foreach($blogs as $blog_item): ?>
                            <div class="card my-3" data-aos="fade" data-aos-duration="800">
                                <div class="card-body p-0">
                                    <div class="img-wrapper">
                                        <img src="assets/blog-images/<?php echo $blog_item['image']; ?>" class="img-fluid" alt="">
                                    </div>
                                    <div class="content p-3">
                                        <h5 class="fw-semibold"><?php echo $blog_item['title']; ?></h5>
                                        <div class="mb-3"><?php echo $blog_item['created_at']; ?> | by <?php echo $blog_item['name']; ?></div>
                                        <p>
                                            <?php echo substr($blog_item['content'], 0, 150);?>
                                            <a href="blog-detail.php?id=<?php echo $blog_item['id']; ?>" class="text-decoration-none">See More</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No blogs available.</p>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
            <?php require_once ('layout/right-side.php'); ?>
        </div>
    </div>
</div>
<?php require_once 'layout/footer.php'; ?>