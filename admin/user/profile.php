<?php

    $userId = $_SESSION['user']->id;
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
?>
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">User Profile</h6>
    </div>
    <div class="card-body">
        <strong>Name:</strong> <?php echo $user['name']; ?><br>
        <strong>Email:</strong> <?php echo $user['email']; ?><br>
        <strong>Role:</strong> <?php echo $user['role']; ?><br>
    </div>
</div>
