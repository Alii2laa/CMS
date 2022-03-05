
<?php
if(ifItIsMethod('post')){
    if(isset($_POST['login'])){
        if(isset($_POST['username']) && isset($_POST['password'])){
            login_user($_POST['username'],$_POST['password']);
        }else{
            redirect("/cms/");
        }
    }

}
?>



<style>
    .well a{
        display: block;
        width: 75%;
        margin: 10px auto;
    }
</style>
<div class="col-md-4">

    <!-- Blog Search Well -->
    <div class="well">
        <h4>Blog Search</h4>
        <form action="/cms/search" method="post">
            <div class="input-group">
                <input name="search" type="text" class="form-control">
                <span class="input-group-btn">
                    <button name="submit" class="btn btn-default" type="submit">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
                </span>
            </div>
        </form><!-- /search form -->
        <!-- /.input-group -->
    </div>

    <!-- Blog Login Well -->
    <div class="well">

        <?php if(isset($_SESSION['user_role'])): ?>
            <h4 class="text-center"> <?php echo $_SESSION['userName']?></h4>
            <?php
                if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin'){
                    echo "<a href='/cms/admin/profile.php' class='btn btn-primary'>Profile</a>";
                    echo "<a href='/cms/admin/index.php' class='btn btn-primary'>Admin Panel</a>";
                }
            ?>
            <a href="/cms/includes/logout.php" class="btn btn-primary" style="background-color: #dc3545!important;border-color: #dc3545!important">Log out</a>

        <?php else: ?>
            <h4>Login</h4>
            <form method="post">
                <div class="form-group">
                    <input name="username" type="text" class="form-control" placeholder="Username" autocomplete="off">
                </div>
                <div class="input-group">
                    <input name="password" type="password" class="form-control" placeholder="Password">
                    <span class="input-group-btn">
                        <button class="btn btn-primary" name="login" type="submit">Login</button>
                    </span>
                </div>
                <div class="form-group">
                    <a href="/cms/forgot?tokId=<?php echo uniqid(true);?>">Forgot Password!</a>
                </div>
            </form><!-- /search form -->
            <!-- /.input-group -->
        <?php endif; ?>


    </div>





    <!-- Blog Categories Well -->
    <div class="well">
        <h4>Blog Categories</h4>
            <div class="row">


                    <div class="col-lg-12">
                        <ul class="list-unstyled">
                            <?php
                            $query = "SELECT * FROM categories";
                            $select_categories_sidebar = mysqli_query($connection,$query);
                            if($select_categories_sidebar){
                                while ($row = mysqli_fetch_assoc($select_categories_sidebar)) {
                                    $cat_id = $row['cat_id'];
                                    $cat_title = $row['cat_title'];

                                    echo "<li><a href='/cms/category/{$cat_id}'>{$cat_title}</a></li>";
                                }
                            }else{
                                echo "<h1>No CATs founded</h1>";
                            }
                            ?>
                        </ul>
                    </div>
                <!-- /.col-lg-6 -->
            </div>
            <!-- /.row -->
        </div>


    <!-- Side Widget Well -->
    <?php include "includes/widget.php"; ?>

</div>