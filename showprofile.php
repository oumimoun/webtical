<?php
session_start();

if (isset($_SESSION['loggedIn'], $_SESSION['username'], $_GET['id'])) {
    require("config/connexion.php");
    $userProfile = $_GET['id'];
    // Update follower, following, and publication counts
    $queryFollowers = "SELECT COUNT(*) AS followerCount FROM followers WHERE follower_user = :username";
    $stmtFollowers = $db->prepare($queryFollowers);
    $stmtFollowers->execute([':username' => $userProfile]);
    $followerCount = $stmtFollowers->fetchColumn();

    $queryFollowing = "SELECT COUNT(*) AS followingCount FROM followers WHERE username = :username";
    $stmtFollowing = $db->prepare($queryFollowing);
    $stmtFollowing->execute([':username' => $userProfile]);
    $followingCount = $stmtFollowing->fetchColumn();

    $queryPub = "SELECT COUNT(*) AS publicationCount FROM publication WHERE username = :username";
    $stmtPub = $db->prepare($queryPub);
    $stmtPub->execute([':username' => $userProfile]);
    $publicationCount = $stmtPub->fetchColumn();

    // Fetch user data from database and display on profile page

    $stmt = $db->prepare("SELECT * FROM utilisateur WHERE username = :username");
    $stmt->execute([':username' => $userProfile]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    $username = $user['username'];
    $profilepic = $user['name'];
    $fullname = $user['fullname'];


    $query2 = $db->prepare('SELECT * FROM utilisateur JOIN publication ON utilisateur.username = publication.username WHERE utilisateur.username = :username ORDER BY datePub DESC');
    $query2->execute([':username' => $userProfile]);
    $result2 = $query2->fetchAll(PDO::FETCH_ASSOC);

    $selPub = $db->prepare('SELECT publication.*, utilisateur.*
    FROM publication
    JOIN shares ON publication.idPub = shares.post_id
    JOIN utilisateur ON publication.username = utilisateur.username
    WHERE shares.username = :userprofile
    ORDER BY publication.datePub DESC
    ');
    $selPub->execute([':userprofile' => $userProfile]);
    $result1 = $selPub->fetchAll(PDO::FETCH_ASSOC);

    // trends sel
    $queryT = $db->prepare('SELECT * FROM trends ORDER BY count DESC LIMIT 5');
    $queryT->execute();
    $trends = $queryT->fetchAll(PDO::FETCH_ASSOC);

?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Webtical</title>
        <script src="https://cdn.tailwindcss.com"></script>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/uicons-regular-rounded/css/uicons-regular-rounded.css'>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <script src="https://use.fontawesome.com/fe459689b4.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="./js/like.js"></script>

    </head>

    <body>
        <div class="flex flex-row ">
            <!--Webtical links-->
            <?php include 'layouts/header.php'; ?>
            <!--Webtical main-->
            <div class="basis-1/2 p-4 bg-gray-200 rounded-md shadow-md text-black font-semibold">
                <div class="flex justify-between">
                    <span class="text-lg font-semibold">
                        Profile
                    </span>
                    <i class="fa-solid fa-user"></i>
                </div>

                <div class="pt-2"></div>

                <div class="pt-2"></div>
                <div class="border border-gray-400 "></div>
                <!--content-->

                <div id="post" class="p-4 ">
                    <div class="bg-gradient-to-r from-blue-300 to-blue-400 h-64 border border-gray-400 rounded-xl"></div>
                    <div class="flex justify-center  border-gray-400 rounded-lg w-full mx-auto">

                        <div id="postCount" class="flex flex-col items-center">
                            <span class="font-bold text-xl"><?= $publicationCount ?></span>
                            <span class="text-gray-600">Posts</span>
                        </div>
                        <div id="followerCount" class="flex flex-col items-center mx-4">
                            <span class="font-bold text-xl"><?= $followerCount ?></span>
                            <span class="text-gray-600">Followers</span>
                        </div>
                        <div id="followingCount" class="flex flex-col items-center">
                            <span class="font-bold text-xl"><?= $followingCount ?></span>
                            <span class="text-gray-600">Following</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="flex items-center  mt-[-8rem]">
                            <img id="profile-picture" class="w-32 h-32 rounded-full border-2  border-gray-400 cursor-pointer shadow-lg" src="./uploads/<?= htmlspecialchars($user['name']) ?>" alt="Profile picture">
                            <input type="file" id="profilepic" name="profilepic" accept="image/*" class="hidden">
                        </div>
                    </div>
                    <br>

                    <span class="text-lg"><?php echo $user['fullname']; ?></span><br>
                    <div class="text-gray-600 h-4"><?php echo "@" . $user['username']; ?></div><br>
                    <div class="box-border h-12 border-4"><i class="fi fi-rr-flag-alt"></i>&nbsp<?php echo " " . $user['bio']; ?></div>
                    <button class="rounded-t-lg w-40 h-10 hover:bg-gray-300">Posts</button>

                    <!-- post div -->
                    <!-- <div class="pt-2"></div> -->
                    <div class="border border-gray-400 "></div>

                    <?php
                    $posts = array_merge($result1, $result2);
                    foreach ($posts as $post) {
                        $idPub = $post['idPub'];
                    ?>
                        <div id="post" class="post">
                            <script src="./js/delete.js"></script>
                            <div class="flex pt-2 space-x-2 absolute">
                                <div>
                                    <img src="./uploads/<?php echo $post['name']; ?>" alt="" class="rounded-full w-14">
                                </div>
                                <span class="font-semibold"><?php echo $post['fullname'] ?></span>
                                <span class="font-thin"><em>@</em><?php echo $post['username']; ?></span>
                                <span class="font-light"><?php echo $post['datePub']; ?></span>
                                <!-- <span class="options-link"><i id="dropdownDefaultButton" data-dropdown-toggle="dropdown" class="fas fa-ellipsis-h cursor-pointer "></i></span> -->

                                <!-- Contenu de votre page home.php -->

                                <?php
                                $isAuthenticated = isset($_SESSION['username']);
                                ?>
                                <?php if ($isAuthenticated) { ?>
                                    <span class="options-link">
                                        <i id="dropdownDefaultButton" data-dropdown-toggle="dropdown" class="fas fa-ellipsis-h cursor-pointer"></i>
                                    </span>

                                    <div id="dropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-40 h-auto dark:bg-gray-700">
                                        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefaultButton">
                                            <li>
                                                <a href="deletePost.php?idPub=<?php echo $idPub; ?>" class="block px-2 py-2 hover:bg-gray-100 rounded-md dark:hover:bg-gray-600 dark:hover:text-white">
                                                    <i class="fa-solid fa-trash text-violet-500"></i> Delete
                                                </a>
                                            </li>
                                        </ul>
                                        <script src="./js/dropdown.js">
                                            var dropdownButton = document.getElementById('dropdownDefaultButton');
                                            var dropdown = document.getElementById('dropdown');
                                            var isAuthenticated = <?php echo $isAuthenticated ? 'true' : 'false'; ?>;

                                            dropdownButton.addEventListener('click', function() {
                                                if (isAuthenticated) {
                                                    dropdown.classList.toggle('hidden');
                                                }
                                            });

                                            window.addEventListener('click', function(event) {
                                                if (!dropdown.contains(event.target) && event.target !== dropdownButton) {
                                                    dropdown.classList.add('hidden');
                                                }
                                            });
                                        </script>
                                    </div>
                                <?php
                                }
                                ?>

                            </div>
                            <div class="pl-14 grid ">
                                <br>
                                <br>
                                <span class="ml-4"><?php echo $post['contenuPub']; ?></span>
                                <div class="rounded-md  p-4">
                                    <div class="flex space-x-3">
                                        <?php
                                        if ($post['image'] && file_exists('uploads/' . $post['image'])) {
                                            echo '<img src="uploads/' . $post['image'] . '" class="rounded-lg w-96 h-auto ml-14" >';
                                        }
                                        ?>

                                    </div>
                                </div>
                                <div class="flex justify-between my-0  p-4">
                                    <!-- <i class="fi fi-rr-share-square ml-20"></i> -->
                                    <a href="share.php?idPub=<?php echo $idPub; ?>" class="share-btn"><i class="fi fi-rr-share-square ml-20"></i>
                                        <?php
                                        $query = $db->query("SELECT COUNT(*) FROM shares WHERE post_id = '" . $idPub . "'");
                                        echo $query->fetchColumn();
                                        ?>
                                    </a>
                                    <!-- <i class="fa-solid fa-share text-violet-950 hover:text-violet-600 duration-300"></i> -->
                                    <a href="post.php?idPub=<?php echo $idPub; ?>"><i class="fi fi-rr-comments"></i>
                                        <span class="" id="show_comments<?php echo $idPub; ?>">
                                            <?php
                                            $query = $db->query("SELECT COUNT(*) FROM comments WHERE idPub = '" . $idPub . "'");
                                            echo $query->fetchColumn();
                                            ?>
                                        </span>
                                    </a>
                                    <a class="mr-28">
                                        <!-- <i class="fi fi-rr-heart "></i> -->
                                        <?php
                                        $stmt = $db->prepare("SELECT * FROM likes WHERE idPub = :idPub AND username = :username");
                                        $stmt->execute(array(':idPub' => $idPub, ':username' => $_SESSION['username']));
                                        if ($stmt->rowCount() > 0) {
                                        ?>
                                            <button value="<?php echo $idPub; ?>" class="unlike text-gray-700 font-medium">Unlike</button>
                                        <?php
                                        } else {
                                        ?>
                                            <button value="<?php echo $idPub; ?>" class="like text-gray-700 font-medium">Like</button>
                                        <?php } ?>
                                        <span id="show_like<?php echo $idPub; ?>">
                                            <?php
                                            $query3 = $db->query("SELECT COUNT(*) FROM likes WHERE idPub = '" . $idPub . "'");
                                            echo $query3->fetchColumn();
                                            ?>
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="pt-2"></div>
                        <div class="border border-gray-400 "></div>
                    <?php
                    }
                    ?>
                </div>
            </div>
            <!--Webtical trending & search-->
            <?php include 'layouts/footer.php'; ?>
        </div>
    </body>

    </html>
<?php

} else {
    header('Location: index.php');
}
?>