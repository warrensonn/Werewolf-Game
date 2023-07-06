<?php
/** Revive witch power view
 *
 * @file
 * @brief Allow the witch to revive if possible to werewolf victim of the name
 *
 * @category  Master Project
 * @package   Werewolf
 * @author    Bevilacqua Warren <bevilacqua.warren@gmail.com>
 * @version   GIT: <0>
 */
?>

<h2 class="text-primary">Place à la sorcière</h2>
<h3>Les loups-garous ont mangé <?php echo $_SESSION['eatten']?></h3>
<?php if ($saving == 0) { ?>
    <div class="form-group">
        <label for="revive">Voulez-vous réssusciter <?php echo $_SESSION['eatten']; ?>?</label>
        <form method="post" action="index.php?uc=game&action=showingCard&role=Sorcière&res=true">
            <button type="submit" class="btn btn-primary">Réssusciter</button>
        </form>
    </div>
<?php } ?>
