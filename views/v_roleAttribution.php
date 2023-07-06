<?php
if ($nb > $_SESSION['playersNumber'] - 1) {
	$msg = "Commencer la partie";
	$action = "index.php?uc=game";
} else {
	$msg = "Carte du joueur suivant: $nextPlayer";
	$action = "index.php?uc=welcome&action=showingRole&player=$nb";
}
?>

<style>
.custom-header-img {
    width: 900px;
    height: 250px;
    object-fit: contain;
}
</style>

<body>
    <div class="container">
        <div class="text-right">
            <h2 class="mt-4">Pseudo : <?php echo $player; ?></h2>
            <img src="<?php echo $path; ?>"
                 alt="Image"
                 class="img-fluid custom-header-img">

            <form method="post" action="<?php echo $action ?>" class="mt-4">
                <input type="hidden" name="player" value="<?php echo $nb ?>">
                <button type="submit" class="btn btn-primary"><?php echo $msg ?></button>
            </form>
        </div>
    </div>
</body>
