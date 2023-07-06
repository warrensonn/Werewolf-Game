<?php
/** Welcome views
 *  -------
 *  @file
 *  @brief Welcome page displaying the possibilities
 * 
 *  @category  Master Project
 *  @package   Werewolf
 *  @author    Warren BEVILACQUA <bevilacqua.warren@gmail.com>
 *  @version   GIT: <0>
 */
?>

<form method="post" action="index.php?uc=welcome&action=gameConfiguration">
    <div class="row">
        <?php for ($i = 1; $i <= $_SESSION['playersNumber']; $i++) { ?>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="pseudo<?php echo $i ?>" class="font-weight-bold text-primary">
                        Pseudo joueur <?php echo $i ?> :
                    </label>
                    <input type="text" class="form-control" id="pseudo<?php echo $i ?>" name="pseudo<?php echo $i ?>">
                </div>
            </div>
        <?php } ?>
    </div>
    <button type="submit" class="btn btn-primary">Valider</button>
</form>
