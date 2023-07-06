<?php
/** \mainpage Project Werewolf
 *
 * \section Game Web Application using MVC model PHP Version 7
 *
 * Data access class / Functions / Views / Controllers in this documentation
 *
 * @category  Master Project
 * @package   Werewolf
 * @author    Bevilacqua Warren <bevilacqua.warren@gmail.com>
 * @version   GIT: <0>
 */

require_once 'includes/fct.inc.php';
require_once 'includes/class.pdowerewolf.inc.php';
session_start();
$pdo = PdoWerewolf::getPdoWerewolf();
require 'views/v_header.php';
$uc = filter_input(INPUT_GET, 'uc', FILTER_SANITIZE_STRING);
if (empty($uc)) {
    $uc = 'welcome';
}
switch ($uc) {
case 'welcome':
    include 'controllers/c_welcome.php';
    break;
case 'game':
	include 'controllers/c_game.php';
	break;
case 'creatingGame':
	include 'controllers/c_creatingGame.php';
	break;
}
?>
