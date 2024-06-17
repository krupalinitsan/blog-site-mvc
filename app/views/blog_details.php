<?php require 'app/views/top.php'; ?>
<div class="body__overlay"></div>

<!-- Start Main Area -->
<div class="slider__container slider--one bg__cat--3">
    <div class="single__slide animation__style01">
        <div class="container">
            <div class="center">
                <div class="card" style="width: 40rem; padding: 20px; margin: auto;">
                    <div class="card-body">
                        <p class="card-text"><strong><?php echo htmlspecialchars($blog['description']); ?></strong></p>
                        <br>
                    </div>
                    <br>
                    <div>
                        <div class="card" style="border: 1px solid black; padding: 20px;">
                            <div>
                                <?php
                                $id = $blog['id'];
                                $message = $message ?? ''; // Initialize the message variable if not set
                                ?>

                                <?php if ($message): ?>
                                    <div class="alert alert-success">
                                        <?php echo htmlspecialchars($message); ?>
                                    </div>
                                <?php endif; ?>

                                <!-- Comment Form -->
                                <form action="" method="post" style="margin-bottom: 20px;">
                                    <input type="hidden" name="post_id" value="<?php echo $id; ?>" required>
                                    <input type="hidden" name="reply_of" value="0">

                                    <p>
                                        <label>Your name</label>
                                        <input type="text" name="name" required>
                                    </p>

                                    <p>
                                        <label>Your email address</label>
                                        <input type="email" name="email" required>
                                    </p>

                                    <p>
                                        <label>Comment</label>
                                        <textarea name="comment" required style="background-color: #ffffff;"></textarea>
                                    </p>
                                    <p>
                                        <input type="submit" value="Add Comment" name="post_comment">
                                    </p>
                                </form>

                                <?php
                                function displayComments($comments, $reply_of = 0, $margin = 0)
                                {
                                    static $comment_counter = 0;

                                    foreach ($comments as $comment) {
                                        if ($comment['reply_of'] == $reply_of) {
                                            echo '<div style="margin-left: ' . $margin . 'px; border: 1px solid black; padding: 10px; margin-top: 10px;">';
                                            echo '<p>' . htmlspecialchars($comment['name']) . '</p>';
                                            echo '<p><b>' . htmlspecialchars($comment['comment']) . '</p></b>';

                                            if ($comment_counter < 3) {

                                                echo '<button onclick="toggleReplyForm(' . $comment['id'] . ')">Reply</button>';
                                                echo '<form id="replyForm' . $comment['id'] . '" action="" method="post" style="display:none; margin-top: 10px;">';
                                                // echo '<form action="" method="post" style="margin-top: 10px;">';
                                                echo '<input type="hidden" name="post_id" value="' . $comment['post_id'] . '" required>';
                                                echo '<input type="hidden" name="reply_of" value="' . $comment['id'] . '">';
                                                echo '<input type="hidden" name="name" value="' . htmlspecialchars($comment['author_firstname']) . '">';
                                                echo '<input type="hidden" name="email" value="' . htmlspecialchars($comment['author_email']) . '">';
                                                echo '<p><label>Comment</label><textarea name="comment" required style="background-color: #ffffff;"></textarea></p>';
                                                echo '<p><input type="submit" value="Reply" name="reply_comment"></p>';
                                                echo '</form>';
                                                $comment_counter++; // Increment the comment counter
                                            }

                                            displayComments($comments, $comment['id'], $margin + 20);
                                            echo '</div>';
                                        }
                                    }
                                }

                                displayComments($comments);
                                ?>
                                <script>
                                    function toggleReplyForm(commentId) {
                                        var form = document.getElementById('replyForm' + commentId);
                                        if (form.style.display === 'none' || form.style.display === '') {
                                            form.style.display = 'block';
                                        } else {
                                            form.style.display = 'none';
                                        }
                                    }
                                </script>
                            </div>
                        </div>
                    </div>
                    <br>
                    <a href="<?= constant('BASE_URL') ?>/BlogList/userpage" class="filter-link">
                        <center><button type="button" class="btn btn-primary">Go Back</button></center>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Main content -->
</div>
<?php require 'app/views/footer.php'; ?>