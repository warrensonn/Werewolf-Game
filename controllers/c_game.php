<?php
/** Game controller
 *  -------
 *  @file
 *  @brief Game controlling 
 * 
 *  @category  Master Project
 *  @package   Werewolf
 *  @author    Warren BEVILACQUA <bevilacqua.warren@gmail.com
 *  @version   GIT: <0>
 */

if (!isset($_REQUEST['action'])) {
	$action = 'voyante';
} else {
	$action = $_REQUEST['action'];
}
$_SESSION['lineNb'] = 4;
if ($_SESSION['playersNumber'] > 8) {
	$_SESSION['lineNb'] = 5;
}

switch ($action) {
	case 'voting':
		{
			$role = "Voting";
			$wolfRemaining = $pdo->getWolfNumber($_SESSION['game'])['nb'];
			$notWolfRemaining = $pdo->getNotWolfNumber($_SESSION['game'])['nb'];
			if ($wolfRemaining == 0) { ?>
				<h1> Les villageois ont gagné</h1>
				<form method="post" action="index.php">
    				<input type="submit" value="Relancer une partie">
  				</form> <?php
			} elseif ($notWolfRemaining == 0) { ?>
				<h1> Les loups-garous ont gagné</h1>
				<form method="post" action="index.php">
    				<input type="submit" value="Relancer une partie">
  				</form> <?php
			} else {
				$pseudosRes = $pdo->getAllPseudo($_SESSION['game']);
				$pseudos = array();
				foreach ($pseudosRes as $pseudo) {
    				$pseudos[] = $pseudo['pseudo'];
				}
				include ("views/v_selecting.php");
			}
			break;
		}
	case 'voyante':
		{
			$role = "Voyante";
			$pseudosRes = $pdo->getPseudoButOne($_SESSION['game'], $role);
			$pseudos = array();
			foreach ($pseudosRes as $pseudo) {
    			$pseudos[] = $pseudo['pseudo'];
			}

			include ("views/v_selecting.php");
			break;
		}
	case 'Loup-garou':
		{
			$role = "Loup-garou";
			$pseudosRes = $pdo->getPseudoButOne($_SESSION['game'], $role);
			$pseudos = array();
			foreach ($pseudosRes as $pseudo) {
    			$pseudos[] = $pseudo['pseudo'];
			}

			include ("views/v_selecting.php");
			break;
		}
	case 'sorciere':
		{
			$role = "Sorcière";
			$pseudosRes = $pdo->getPseudoButOne($_SESSION['game'], $role);
			$pseudos = array();
			foreach ($pseudosRes as $pseudo) {
    			$pseudos[] = $pseudo['pseudo'];
			}
			$index = array_search($_SESSION['eatten'], $pseudos);
			unset($pseudos[$index]);

			$saving = $pdo->getSavingStatut($_SESSION['game'])['saving'];
			$killing = $pdo->getKillingStatut($_SESSION['game'])['killing'];
			include ("views/v_revive.php");
			include ("views/v_selecting.php");
			break;
		}
	case 'showingCard':
		{
			if (isset($_POST['selected'])) {
				$selectedPseudo = $_POST['selected'];
			}
			$role = $_GET['role'];

			switch ($role) {
				case 'Voyante':
					$msg = "Voici la carte de " . $selectedPseudo;
					$imgToShow = $pdo->getPlayerRoleImage($_SESSION['game'], $selectedPseudo)['img'];
					$action = "index.php?uc=game&action=Loup-garou";
					$button = "La voyante se rendort";
					break;
				case 'Loup-garou':
					$msg = "Vous avez décidé de manger " . $selectedPseudo;
					$_SESSION['eatten'] = $selectedPseudo;

					$sorciereStatut = $pdo->getSorciereStatut($_SESSION['game'])['nb'];
					if ($sorciereStatut == 1) {
						$action = "index.php?uc=game&action=sorciere";
					} else {
						$action = "index.php?uc=game&action=voting";
					}
					
					$button = "Les loups s'endorment";
					break;
				case 'Sorcière':
					$msg = "";
					if (isset($_GET['res'])) {
						$msg = "Vous avez décidé de réssusciter " . $_SESSION['eatten'];
						$pdo->updateSavingStatut($_SESSION['game']);
					} else {
						$pdo->deletePLayer($_SESSION['game'], $_SESSION['eatten']);
					}

					if (isset($_POST['selected'])) {
						$msg .= "<br>Vous avez tué " . $_POST['selected'];
						$pdo->deletePLayer($_SESSION['game'], $_POST['selected']);
						$pdo->updateKillingStatut($_SESSION['game']);
					}

					$action = "index.php?uc=game&action=voting";
					$button = "La sorcière s'endort";
					break;
				case 'Voting':
					$roleKilled = $pdo->getPlayerRoleImage($_SESSION['game'], $selectedPseudo)['name'];
					$imgToShow = $pdo->getPlayerRoleImage($_SESSION['game'], $selectedPseudo)['img'];
					$msg = "Voici la carte de " . $selectedPseudo . "<br>C'était un " . $roleKilled;
					$pdo->deletePLayer($_SESSION['game'], $selectedPseudo);

					$voyanteStatut = $pdo->getVoyanteStatut($_SESSION['game'])['nb'];
					if ($voyanteStatut == 1) {
						$action = "index.php?uc=game&action=voyante";
					} else {
						$action = "index.php?uc=game&action=Loup-garou";
					}

					$button = "Le village s'endort";
					break;
			}
			$wolfRemaining = $pdo->getWolfNumber($_SESSION['game'])['nb'];
			$notWolfRemaining = $pdo->getNotWolfNumber($_SESSION['game'])['nb'];
			if ($wolfRemaining == 0) { ?>
				<h1> Les villageois ont gagné</h1>
				<form method="post" action="index.php">
    				<input type="submit" value="Relancer une partie">
  				</form> <?php
			} elseif ($notWolfRemaining == 0) { ?>
				<h1> Les loups-garous ont gagné</h1>
				<form method="post" action="index.php">
    				<input type="submit" value="Relancer une partie">
  				</form> <?php
			} else {
				include ("views/v_selected.php");
			}
			break;
		}
} ?>
