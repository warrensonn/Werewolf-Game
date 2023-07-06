<?php
/** Header views
 *  -------
 *  @file
 *  @brief Header based on the user type 
 * 
 *  @category  Projet Master
 *  @package   Werewolf
 *  @author    Warren BEVILACQUA <bevilacqua.warren@gmail.com>
 *  @version   GIT: <0>
 */
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta charset="UTF-8">
        <title>jeu du Loup-garou</title> 
        <meta name="description" content="werewolf">
        <meta name="author" content="Bevilacqua Warren">
        <meta name="viewsport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
		<script src='includes/fct.js'></script>
    </head>

<style>
.custom-header-img {
    width: 900px;
    height: 250px;
    object-fit: cover;
}
</style>

<body>
    <div class="container">
        <?php $uc = filter_input(INPUT_GET, 'uc', FILTER_SANITIZE_STRING); ?>
        <div class="header">
            <div class="row align-items-center justify-content-center">
                <div class="col-md-6 text-center">
                    <img src="./assets/header.jpeg" 
                         class="img-fluid custom-header-img" 
                         alt="Werewolf" 
                         title="Werewolf">
                    <h1 class="mt-4">Loup-Garou de Thiercelieux</h1> <br>
                </div>
            </div>
        </div>
    </div>
</body>
