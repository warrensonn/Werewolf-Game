<?php
/** Selection view
 *
 * @file
 * @brief Allow player to choose between the possible target
 *
 * @category  Master Project
 * @package   Werewolf
 * @author    Bevilacqua Warren <bevilacqua.warren@gmail.com>
 * @version   GIT: <0>
 */
?>

<style>
    .ligne {
        display: flex;
        flex-wrap: wrap;
    }

    .pseudo-container {
        width: 25%;
        box-sizing: border-box; /* inclure la marge et le rembourrage dans la largeur */
        padding: 5px; /* ajouter un espacement entre les éléments */
    }
</style>

<?php 
if ($role == "Voting") { ?>
    <h2 class="text-primary">Place aux votes du village</h2> <?php
} else if ($role == "Loup-garou") { ?>
    <h2 class="text-danger">C'est l'heure de manger pour les loups-garous</h2> <?php
} else if ($role == "Voyante") { ?>
    <h2 class="text-info">La voyante peut regarder une carte</h2> <?php
} ?>
<h3 class="mt-4">Sélectionnez votre cible</h3>
<div class="row">
    <?php
    $nbPseudosParLigne = 4;
    for ($i = 0; $i < sizeof($pseudos); $i += $nbPseudosParLigne) { ?>
        <div class="col-md-3">
            <?php for ($j = $i; $j < $i + $nbPseudosParLigne && $j < sizeof($pseudos); $j++) { 
                if (isset($pseudos[$j])) { ?>
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $pseudos[$j] ?></h5>
                            <form method="post" action="index.php?uc=game&action=showingCard&role=<?php echo $role ?>">
                                <input type="hidden" name="selected" value="<?php echo $pseudos[$j] ?>">
                                <button type="submit" class="btn btn-primary btn-sm">Cibler</button>
                            </form>
                        </div>
                    </div>
                <?php }
            } ?>
        </div>
    <?php } ?>
</div>
<?php
if ($role == "Sorcière") { ?>
    <div class="mt-4">
        <h3>Ne pas utiliser de pouvoirs</h3>
        <form method="post" action="index.php?uc=game&action=showingCard&role=Sorcière">
            <button type="submit" class="btn btn-secondary btn-sm">Ne rien faire</button>
        </form>
    </div>
<?php } ?>
