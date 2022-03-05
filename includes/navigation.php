<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->



        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/cms">Start Bootstrap</a>
        </div>


        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <?php

                if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin'){
                    if(isset($_GET['post_id'])) {
                        $post_id = $_GET['post_id'];
                        echo "<li><a href='/cms/admin/posts.php?source=edit_post&post_id={$post_id}'>Edit</a></li>";
                    }
                }

                ?>
                <?php
                    $query = "SELECT * FROM categories";
                    $select_all_categories_query = mysqli_query($connection,$query);
                    while ($row = mysqli_fetch_assoc($select_all_categories_query)){
                        $cat_id =  $row['cat_id'];
                        $cat_title =  $row['cat_title'];
                        echo "<li><a href='/cms/category/{$cat_id}'>{$cat_title}</a></li>";
                    }
                ?>
                <?php if(!isset($_SESSION['user_role'])): ?>
                    <li><a href='/cms/registration'>Registration</a></li>
                <?php endif; ?>




                <li><a href='/cms/contact'>Contact</a></li>
                <?php if(!isset($_SESSION['user_role'])): ?>
                    <li><a href='/cms/login'>Login</a></li>;
                <?php else: ?>
                    <li><a href='/cms/includes/logout.php'>Logout</a></li>
                <?php endif; ?>







            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>