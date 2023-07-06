<?php
/** Welcome management controller
 *  -------
 *  @file
 *  @brief Welcome management with game creation handling
 * 
 *  @category  Master Project
 *  @package   Werewolf
 *  @author    Warren BEVILACQUA <bevilacqua.warren@gmail.com
 *  @version   GIT: <0>
 */

if (!isset($_REQUEST['action'])) {
	$action = 'choosingNumber';
} else {
	$action = $_REQUEST['action'];
}

switch ($action) {
	case 'choosingNumber':
		{
			include ("views/v_welcome.php");
			break;
		}
	case 'pseudos':
		{
			include ("views/v_welcome.php");
			$_SESSION['playersNumber'] = $_POST['playersNumber'];
			echo "Nombre de joueurs sélectionné : " . $_SESSION['playersNumber'];
			include ("views/v_pseudos.php");
			break;
		}
	case 'gameConfiguration':
		{
			$pseudos = array();
			$hasDuplicates = false;
			for ($i = 1; $i <= $_SESSION['playersNumber']; $i++) {
				$pseudo = $_POST['pseudo' . $i];
				if (in_array($pseudo, $pseudos)) {
					$hasDuplicates = true;
					break;
				}
				$pseudos[] = $pseudo;
			}

			if ($hasDuplicates) {
				echo "<h3>Attention, des pseudos sont dupliqués</h3>";
				include ("views/v_pseudos.php");
			} else {
				$_SESSION['game'] = $pdo->getGameId()['id'];
				$pdo->createGame($_SESSION['game']);

				$roles = [
					'Loup-garou',
					'Loup-garou',
					'Sorcière',
					'Voyante',
					'Villageois',
					'Villageois',
					'Villageois',
					'Villageois'
				];

				for ($i=0; $i < $_SESSION['playersNumber'] - 8; $i++) { 
					$roles[] = 'Villageois';
				}
				shuffle($roles);

				for ($i = 1; $i <= $_SESSION['playersNumber']; $i++) {
					$pseudo = $_POST['pseudo' . $i];

					// Get and delete the role
					$role = array_shift($roles);

					// Insert new player
					$pdo->createPLayer($_SESSION['game'], $pseudo, $role);
				}

				$nb = 0;
				$player = $pdo->getPlayerPseudo($_SESSION['game'], 0)['pseudo'];
				?>
				<br>
				<p class="mt-4"><b>La partie va bientôt commencer, préparez-vous à connaître votre carte</b></p>
				<form method="post" action="index.php?uc=welcome&action=showingRole&player=0" class="mt-4">
				    <input type="hidden" name="player" value="<?php echo $nb ?>">
				    <button type="submit" class="btn btn-primary">Voir la carte de <?php echo $player ?></button>
				</form>
				<?php
			}
			break;
		}
	case 'showingRole':
		{
			$player = $pdo->getPlayerPseudo($_SESSION['game'], $_POST['player'])['pseudo'];
			if ($_POST['player'] < $_SESSION['playersNumber'] - 1) {
				$nextPlayer = $pdo->getPlayerPseudo($_SESSION['game'], $_POST['player']+1)['pseudo'];
			}
			$nb = $_POST['player'] + 1;

			$path = $pdo->getPlayerRoleImage($_SESSION['game'], $player)['img'];
			include ("views/v_roleAttribution.php");
			break;
		}
} ?>
