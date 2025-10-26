<?php 
    $nameError = "";
    $emailError = "";
    $passwordError = "";
    $roleError = "";

    if (isset($_POST['submit'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $role = $_POST['role'];

        if (empty($name)) {
            $nameError = "Name is required";
        } elseif (empty($email)) {
            $emailError = "Email is required";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailError = "Invalid email format";
        } elseif (empty($password)) {
            $passwordError = "Password is required";
        } else {
            $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $name, $email, $password, $role);
            $stmt->execute();
            header("Location: index.php?page=users");
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
                        <h6 class="m-0 font-weight-bold text-primary">User Crate Form</h6>
                        <a href="index.php?page=users" class="btn btn-primary"> << Back</a>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST">
                        <div class="mb-2">
                            <label for="">Name</label>
                            <input type="text" class="form-control" name="name">
                            <span class="text-danger"><?php echo $nameError ?: ''; ?></span>
                        </div>
                        <div class="mb-2">
                            <label for="">Email</label>
                            <input type="email" class="form-control" name="email">
                            <span class="text-danger"><?php echo $emailError ?: ''; ?></span>
                        </div>
                        <div>
                            <label for="">Password</label>
                            <input type="password" class="form-control" name="password">
                            <span class="text-danger"><?php echo $passwordError ?: ''; ?></span>
                        </div>
                        <div class="mb-2">
                            <label for="">Role</label>
                            <select name="role" class="form-control">
                                <option value="admin">Admin</option>
                                <option value="editor">Editor</option>
                                <option value="user">User</option>
                            </select>
                        </div>
                        <button class="btn btn-primary" name="submit">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>