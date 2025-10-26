<?php 
    #User sign up
    if(isset($_POST['signUpBtn'])){
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $role = $_POST['role'];

        $role = isset($_POST['role']) ? $_POST['role'] : 'user';
        $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $password, $role);
        if($stmt->execute()){
            echo "<script>alert('Registration successful. Please sign in.');</script>";
        } else {
            echo "<script>alert('Registration failed. Please try again.');</script>";
        }
    }

    #User sign in
    if(isset($_POST['signInBtn'])){
        $email = $_POST['email'];
        $password = $_POST['password'];

        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows > 0){
            $user = $result->fetch_object();
            $_SESSION['user'] = $user;
            if($user->role === 'admin' || $user->role === 'editor') {
                echo "<script>location.href = 'admin/index.php';</script>";
                exit();
            } elseif($user->role === 'user') {
                // Redirect back to the current page
                $redirect = $_SERVER['HTTP_REFERER'] ?? 'index.php';
                echo "<script>location.href = '$redirect';</script>";
                exit;
            }
        } else {
            echo "<script>alert('Invalid email or password');</script>";
            exit(); 
        }
    }
?>

<!-- Footer -->
    <footer id="footer" class="d-flex justify-content-center align-items-center">
        <div class="container" >
            <div>&copy; 2025 Htoo Technology, Inc. All rights reserved.</div>
        </div>
    </footer>

    <!-- sign up  -->
    <div class="offcanvas offcanvas-start" data-bs-backdrop="static" tabindex="-1" id="signUp" aria-labelledby="signUpLabel">
        <div class="offcanvas-header">
          <h5 class="offcanvas-title" id="signUpLabel">Sign Up</h5>
          <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
          <div class="">
            <form method="post" action="">
                <div class="mb-2">
                    <input type="text" class="form-control" placeholder="name" name="name" required>
                </div>
                <div class="mb-2">
                    <input type="text" class="form-control" placeholder="email" name="email" required>
                </div>
                <div class="mb-2">
                    <input type="text" class="form-control" placeholder="password" name="password" required>
                </div>
                <div class="mb-2">
                    <select class="form-control" name="role">
                        <option value="">Select Role</option>
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                        <option value="editor">Editor</option>
                    </select>
                </div>
                <button class="btn" name="signUpBtn">Sign Up</button>
            </form>
          </div>
        </div>
    </div>

    <!-- sign in  -->
    <div class="offcanvas offcanvas-start" data-bs-backdrop="static" tabindex="-1" id="signIn" aria-labelledby="signInLabel">
        <div class="offcanvas-header">
          <h5 class="offcanvas-title" id="signInLabel">Sign In</h5>
          <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
          <div class="">
            <form action="" method="post">
                <div class="mb-2">
                    <input type="text" class="form-control" placeholder="email" name="email">
                </div>
                <div class="mb-2">
                    <input type="password" class="form-control" placeholder="password" name="password">
                </div>
                <button class="btn" name="signInBtn">Sign In</button>
                <div class="mt-2"><a href="#signUp" data-bs-toggle="offcanvas" data-bs-target="#signUp" aria-controls="signUp">Don't have an account? Sign Up</a></div>
            </form>
          </div>
        </div>
    </div>
    
    <!-- bootstrap cdn  -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <!-- aos  -->
    <script src="assets/aos/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>
</html>