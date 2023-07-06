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

<body>
    <div class="container">
        <h1 class="mt-4">Bienvenue sur votre jeu "Loup-Garou"</h1>
        <div class="card mt-4">
            <div class="card-header">
                Choix des surnoms dans le jeu
            </div>
            <div class="card-body">
                <form method="post" action="index.php?uc=welcome&action=pseudos">
                    <div class="form-group">
                        <label for="playersNumber">Nombre de joueurs :</label>
                        <select class="form-control" id="playersNumber" name="playersNumber">
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Valider</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
