<?php
/** Selected view
 *
 * @file
 * @brief Display the name and image (if required) of the selected person
 *
 * @category  Master Project
 * @package   Werewolf
 * @author    Bevilacqua Warren <bevilacqua.warren@gmail.com>
 * @version   GIT: <0>
 */
?>

<body>
    <div class="container">
        <?php if (isset($msg)) { ?>
            <h2 class="text-primary"><?php echo $msg; ?></h2>
        <?php } ?>
        <?php if (isset($imgToShow)) { ?>
            <img src="<?php echo $imgToShow ?>" alt="Image" class="img-fluid">
        <?php } ?>
        <form method="post" action="<?php echo $action ?>" class="mt-4">
            <button type="submit" class="btn btn-primary"><?php echo $button ?></button>
        </form>
    </div>
</body>
</html>
