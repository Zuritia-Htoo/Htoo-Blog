<?php 
    # Fetch categories from the database 
    $stmt = $conn->prepare("SELECT * FROM categories");
    $stmt->execute();   
    $result = $stmt->get_result();
    $categories = $result->fetch_all(MYSQLI_ASSOC);

    # Fetch some blogs for the sidebar
    $blogStmt = $conn->prepare("SELECT * FROM blogs ORDER BY created_at DESC LIMIT 4");
    $blogStmt->execute();
    $blogResult = $blogStmt->get_result();
    $blogs = $blogResult->fetch_all(MYSQLI_ASSOC);
?>
    <div class="col-md-4">
        <h5 data-aos="fade-left" data-aos-duration="800">Blogs Categories</h5>
        <div class="heading-line" data-aos="fade-right" data-aos-duration="800"></div>
        <ul class="mb-5" data-aos="zoom-in" data-aos-duration="800">
            <?php foreach($categories as $category): ?>
                <li class="my-2"><a href="blog-detail.php?category=<?php echo $category['id']; ?>"><?php echo $category['name']; ?></a></li>
            <?php endforeach; ?>
        </ul>
        <h5 data-aos="fade-left" data-aos-duration="800">Blogs You May Like</h5>
        <?php foreach($blogs as $blog): ?>
        <a href="blog-detail.php?id=<?php echo $blog['id']; ?>">
            <div class="recent-blog border rounded p-2 my-1 d-flex justify-content-between align-items-center" data-aos="zoom-in" data-aos-duration="800">
                <img src="assets/blog-images/<?php echo $blog['image']; ?> " alt="">
                <div class="ms-2">
                    <?php echo substr($blog['content'], 0, 50); ?>...
                </div>
            </div>
        </a>
        <?php endforeach; ?>
    </div>