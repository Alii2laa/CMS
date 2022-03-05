<table class="table table-bordered table-hover">
    <thead>
    <tr>
        <th>ID</th>
        <th>Username</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Email</th>
        <th>Role</th>

    </tr>
    </thead>
    <tbody>
    <?php
    $query = "SELECT * FROM users";
    $select_all_posts = mysqli_query($connection,$query);

    while ($row = mysqli_fetch_assoc($select_all_posts)){
        $user_id = $row['user_id'];
        $user_name = $row['user_name'];
        $user_firstname = $row['user_firstname'];
        $user_lastname = $row['user_lastname'];
        $user_email = $row['user_email'];
        $user_role = $row['user_role'];




        echo "<tr>";
        echo "<td>{$user_id}</td>";
        echo "<td>{$user_name}</td>";
        echo "<td>{$user_firstname}</td>";
        echo "<td>{$user_lastname}</td>";
        echo "<td>{$user_email}</td>";
        echo "<td>{$user_role}</td>";
        echo "<td><a href='users.php?cahngeToAdmin={$user_id}'>Admin</a></td>";
        echo "<td><a href='users.php?cahngeToUser={$user_id}'>User</a></td>";
        echo "<td><a href='users.php?source=edit_user&edit_user={$user_id}'>Edit</a></td>";
        echo "<td><a href='users.php?delete={$user_id}'>Delete</a></td>";

        echo "</tr>";
    } ?>




    </tbody>
</table>

<?php
if(isset($_GET['cahngeToAdmin'])){

    changeRole('admin',escapeSqlInj($_GET['cahngeToAdmin']));

} elseif (isset($_GET['cahngeToUser'])) {

    changeRole('user',escapeSqlInj($_GET['cahngeToUser']));

} elseif(isset($_GET['delete'])){
    if(isset($_SESSION['user_role'])){
        if($_SESSION['user_role'] == 'admin'){
            $delete_user = $_GET['delete'];
            $query = "DELETE FROM users WHERE user_id ={$delete_user}";
            $delete_query = mysqli_query($connection,$query);
            header("Location: users.php");
        }
    }

}

?>