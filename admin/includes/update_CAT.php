<form action="" method="post">
    <div class="form-group">
        <label for="cat_title">
            Update Category
        </label>

        <?php
        if(isset($_GET['edit'])){
            $edit_cat_id = $_GET['edit'];

            $query = "SELECT * FROM categories WHERE cat_id ={$edit_cat_id}";
            $select_cat_id = mysqli_query($connection,$query);
            if($select_cat_id){
                while($row = mysqli_fetch_assoc($select_cat_id)){
                    $cat_id = $row['cat_id'];
                    $cat_title = $row['cat_title'];
                }
            }else{
                header("Location: ../error404.php");
            }
            ?>
            <input type="text" name="cat_title" value="<?php
            if(isset($cat_title)){
                echo $cat_title;
            }
            ?>" class="form-control">
        <?php } ?>

        <?php
        if(isset($_POST['cat_update'])){
            $cat_title = mysqli_escape_string($connection,$_POST['cat_title']);
            if($cat_title == "" || empty($cat_title)){
                echo "<mark style='background-color:#f8d7da;color:#842029;display: inline-block;margin: 10px 0px'>This Field Should Not Be Empty</mark>";
            }else{

                $stmt = mysqli_prepare($connection,"UPDATE categories SET cat_title = ? WHERE cat_id = ?");
                mysqli_stmt_bind_param($stmt,'si',$cat_title,$cat_id);
                mysqli_stmt_execute($stmt);
                if (!$stmt) {
                    die("Not Added please try" . mysqli_error($connection));
                }
                header("Location: categories.php");

            }



        }
        ?>

    </div>
    <div class="form-group">
        <input type="submit" name="cat_update" value=" Update Category" class="btn btn-primary">
    </div>

</form><!-- CAT add -->