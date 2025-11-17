<?php 
    $nameError = "";
    $emailError = "";
    $passwordError = "";
    $roleError = "";
    $userID = $_GET['id'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();

    $nameError = "";
    if(isset($_POST['update'])){
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $role = $_POST['role'];

        if(empty($name)){
            $nameError = "Name is required";
        } else {
            $stmt = $conn->prepare("UPDATE users SET name = ?, email = ?, password = ?, role = ? WHERE id = ?");
            $stmt->bind_param("ssssi", $name, $email, $password, $role, $userID);
            $stmt->execute();


            echo "<script>location.href='index.php?page=users'</script>";
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
                        <h6 class="m-0 font-weight-bold text-primary">Usser Edit Form</h6>
                        <a href="index.php?page=users" class="btn btn-primary"> << Back</a>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST">
                        <div class="mb-2">
                            <label for="">Name</label>
                            <input type="text" class="form-control" name="name" value="<?php echo htmlspecialchars($user['name']); ?>">  
                            <span class="text-danger"><?php echo $nameError; ?></span>
                        </div>
                        <div class="mb-2">
                            <label for="">Email</label>
                            <input type="text" class="form-control" name="email" value="<?php echo htmlspecialchars($user['email']); ?>">  
                            <span class="text-danger"><?php echo $emailError; ?></span>
                        </div>
                        <div class="mb-2">
                            <label for="">Password</label>
                            <input type="password" class="form-control" name="password">
                            <span class="text-danger"><?php echo $passwordError; ?></span>
                        </div>  
                        <div>
                            <label for="">Role</label>
                            <select name="role" class="form-control">
                                <option value="user" <?php echo ($user['role'] == 'user') ? 'selected' : ''; ?>>User</option>
                                <option value="admin" <?php echo ($user['role'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
                                <option value="editor" <?php echo ($user['role'] == 'editor') ? 'selected' : ''; ?>>Editor</option>
                            </select>
                            <span class="text-danger"><?php echo $roleError; ?></span>
                        </div>
                        <button class="btn btn-primary" name="update">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>