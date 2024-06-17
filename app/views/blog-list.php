<?php require 'app/views/top.php'; ?>
<div class="body__overlay"></div>

<!-- Start Main Area -->
<div class="slider__container slider--one bg__cat--3 ">
    <form method="POST" class="form-inline mb-4">
        <div class="form-group mr-3">
            <select id="id" name="id" class="form-control">
                <option value="">Select Category</option> <!-- Default unset option -->
                <?php
                if ($categories->num_rows > 0) {
                    while ($category = $categories->fetch_assoc()) {
                        $selected = isset($_POST['id']) && $_POST['id'] == $category['id'] ? 'selected' : '';
                        echo '<option value="' . htmlspecialchars($category['id']) . '" ' . $selected . '>' . htmlspecialchars($category['title']) . '</option>';
                    }
                } else {
                    echo '<option value="">No categories available</option>';
                }
                ?>
            </select>
        </div>
        <div class="form-group mr-3">
            <input type="text" name="search" class="form-control" placeholder="Search by title or tag"
                value="<?php echo isset($_POST['search']) ? htmlspecialchars($_POST['search']) : ''; ?>">
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Filter</button>
    </form>

    <br>
    <!-- Main content -->
    <div class="single__slide animation__style01">
        <div class="container">
            <div class="row">
                <?php
                if ($blogs->num_rows > 0) {
                    while ($blog = $blogs->fetch_assoc()) {
                        echo '<div class="col lg-4">';
                        echo '<div class="card " style="width: 18rem; border: 1px solid black; padding: 20px; border-radius: 10px;">';
                        $id = $blog['author_id'];
                        $author = $data->getDataById($id, 'users');
                        echo '<p class="card-text"><strong>' . htmlspecialchars($author['firstname']) . '</strong></p>';
                        echo '<img src="/blog-site-mvc/' . htmlspecialchars($blog['image'] ?? '') . '" class="card-img-top" alt="...">';
                        echo '<br><br>';
                        echo '<div class="card-body">';
                        echo '<h5 class="card-title" style="color:#c43b68">' . htmlspecialchars($blog['title']) . '</h5>';
                        echo '<br>';
                        echo '<p class="card-text">' . htmlspecialchars($blog['short_desc'] ?? '') . '</p>';
                        echo '<br>';
                        echo '</div>';
                        echo '<b>Posted On:</b>';
                        echo '<p class="card-text">' . htmlspecialchars($blog['date']) . '</p>';
                        echo '<div class="card-body">';
                        echo '<a href="/blog-site-mvc/BlogList/viewBlogDetails?id=' . htmlspecialchars($blog['id']) . '" class="card-link" style="color:#df1054">Read more</a>';
                        echo '</div>';
                        echo '</div><br>';
                        $tags = explode(',', $blog['tags']);
                        if ($tags) {
                            echo '<ul class="list-group" style="width: 290px">';
                            foreach ($tags as $tag) {
                                echo '<li class="list-group-item">' . htmlspecialchars($tag) . '</li>';
                            }
                            echo '</ul>';
                            echo '</div>';
                        }
                    }
                } else {
                    echo "No record Found !";
                }
                ?>

            </div>
        </div>
    </div>
    <!-- End Main content -->
</div>
<!-- End Blog Posts Section -->
<!-- End Main Area -->
<?php require 'app/views/footer.php'; ?>