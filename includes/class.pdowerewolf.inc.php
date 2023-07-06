<?php
/** Data access class
 *  -------
 * @file
 * @brief Use PDO class services for the werewolf app
 * @brief All attributes are statics, the first 4 for the connection
 * 
 * @category  Master Project
 * @package   Werewolf
 * @author    Warren BEVILACQUA <bevilacqua.warren@gmail.com>
 * @version   GIT: <0>
 */

class PdoWerewolf
{
    private static $serveur = 'mysql:host=localhost';
    private static $bdd = 'dbname=werewolf';
    private static $user = 'root';
    private static $mdp = '';
    private static $myPdo;
    private static $myPdoWerewolf = null;

    /**
     * Constructeur privé, crée l'instance de PDO qui sera sollicitée
     * pour toutes les méthodes de la classe
     */
    private function __construct()
    {
        PdoWerewolf::$myPdo = new PDO(
            PdoWerewolf::$serveur . ';' . PdoWerewolf::$bdd,
            PdoWerewolf::$user,
            PdoWerewolf::$mdp
        );
        PdoWerewolf::$myPdo->query('SET CHARACTER SET utf8');
    }

    /**
     * Méthode destructeur appelée dès qu'il n'y a plus de référence sur un
     * objet donné, ou dans n'importe quel ordre pendant la séquence d'arrêt.
     */
    public function __destruct()
    {
        PdoWerewolf::$myPdo = null;
    }

    /**
     * Fonction statique qui crée l'unique instance de la classe
     * Appel : $instancePdoWerewolf = PdoWerewolf::getPdoWerewolf();
     *
     * @return l'unique objet de la classe PdoWerewolf
     */
    public static function getPdoWerewolf()
    {
        if (PdoWerewolf::$myPdoWerewolf == null) {
            PdoWerewolf::$myPdoWerewolf = new PdoWerewolf();
        }
        return PdoWerewolf::$myPdoWerewolf;
    }

    /**
     * Retourne les informations d'un visitors
     *
     * @param String $login Login du visitors
     * @param String $mdp   Mot de passe du visitors
     *
     * @return l'id, le nom, le prénom et le statut sous la forme d'un tableau associatif
     */
    public function getInfosVisitorLogin($login, $pwd)
    {
        $requetePrepare = PdoWerewolf::$myPdo->prepare(
            'SELECT id, surname, '
            . 'name, usertype_id AS status '
            . 'FROM visitor '
            . 'WHERE login = :login '
			. 'AND pwd = :pwd'
        );
        $requetePrepare->bindParam(':login', $login, PDO::PARAM_STR);
        $requetePrepare->bindParam(':pwd', $pwd, PDO::PARAM_STR);
        $requetePrepare->execute();
        return $requetePrepare->fetch();
    }

	public function getGameId()
    {
        $requetePrepare = PdoWerewolf::$myPdo->prepare(
            'SELECT MAX(id) + 1 as id '
            . 'FROM game '
        );
        $requetePrepare->execute();
        return $requetePrepare->fetch();
    }

	public function createGame($id)
	{
		$requetePrepare = PdoWerewolf::$myPdo->prepare(
            'INSERT INTO game (id) '
			. 'VALUES (:id)'
        );
		$requetePrepare->bindParam(':id', $id, PDO::PARAM_INT);
        $requetePrepare->execute();
	}

	public function deleteGame($id)
	{
		$requetePrepare = PdoWerewolf::$myPdo->prepare(
            'DELETE FROM game (id) '
			. 'WHERE id = :id'
        );
        $requetePrepare->bindParam(':id', $id, PDO::PARAM_INT);
        $requetePrepare->execute();
	}

	public function createPLayer($game, $pseudo, $role)
	{
		$requetePrepare = PdoWerewolf::$myPdo->prepare(
            'INSERT INTO players (id_game, pseudo, role) '
			. 'VALUES (:game, :pseudo, :role)'
        );
		$requetePrepare->bindParam(':game', $game, PDO::PARAM_INT);
        $requetePrepare->bindParam(':pseudo', $pseudo, PDO::PARAM_STR);
		$requetePrepare->bindParam(':role', $role, PDO::PARAM_STR);
        $requetePrepare->execute();
	}

	public function deletePLayer($game, $pseudo)
	{
		$requetePrepare = PdoWerewolf::$myPdo->prepare(
            'DELETE FROM players '
			. 'WHERE id_game = :game '
			. 'AND pseudo = :pseudo'
        );
        $requetePrepare->bindParam(':game', $game, PDO::PARAM_INT);
		$requetePrepare->bindParam(':pseudo', $pseudo, PDO::PARAM_STR);
        $requetePrepare->execute();
	}

	public function getPlayerRoleImage($game, $pseudo)
    {
        $requetePrepare = PdoWerewolf::$myPdo->prepare(
            'SELECT c.name, c.image_path as img '
            . 'FROM characters as c '
			. 'INNER JOIN players as p '
			. 'WHERE c.name = p.role '
			. 'AND p.id_game = :game '
			. 'AND p.pseudo = :pseudo'
        );
		$requetePrepare->bindParam(':game', $game, PDO::PARAM_INT);
		$requetePrepare->bindParam(':pseudo', $pseudo, PDO::PARAM_STR);
        $requetePrepare->execute();
        return $requetePrepare->fetch();
    }

	public function getPlayerPseudo($game, $shift)
    {
        $requetePrepare = PdoWerewolf::$myPdo->prepare(
            'SELECT pseudo '
            . 'FROM players '
			. 'WHERE id_game = :game '
			. 'LIMIT 1 OFFSET :shift'
        );
		$requetePrepare->bindParam(':game', $game, PDO::PARAM_INT);
		$requetePrepare->bindParam(':shift', $shift, PDO::PARAM_INT);
        $requetePrepare->execute();
        return $requetePrepare->fetch();
    }

	public function getAllPseudo($game)
    {
        $requetePrepare = PdoWerewolf::$myPdo->prepare(
            'SELECT pseudo '
            . 'FROM players '
			. 'WHERE id_game = :game '
        );
		$requetePrepare->bindParam(':game', $game, PDO::PARAM_INT);
        $requetePrepare->execute();
        return $requetePrepare->fetchAll(PDO::FETCH_ASSOC);
    }

	public function getPseudoButOne($game, $role)
    {
        $requetePrepare = PdoWerewolf::$myPdo->prepare(
            'SELECT pseudo '
            . 'FROM players '
			. 'WHERE id_game = :game '
			. 'AND role != :role'
        );
		$requetePrepare->bindParam(':game', $game, PDO::PARAM_INT);
		$requetePrepare->bindParam(':role', $role, PDO::PARAM_STR);
        $requetePrepare->execute();
        return $requetePrepare->fetchAll(PDO::FETCH_ASSOC);
    }

	public function getSavingStatut($game)
    {
        $requetePrepare = PdoWerewolf::$myPdo->prepare(
            'SELECT saving '
            . 'FROM game '
			. 'WHERE id = :game'
        );
		$requetePrepare->bindParam(':game', $game, PDO::PARAM_INT);
        $requetePrepare->execute();
        return $requetePrepare->fetch();
    }

	public function getKillingStatut($game)
    {
        $requetePrepare = PdoWerewolf::$myPdo->prepare(
            'SELECT killing '
            . 'FROM game '
			. 'WHERE id = :game'
        );
		$requetePrepare->bindParam(':game', $game, PDO::PARAM_INT);
        $requetePrepare->execute();
        return $requetePrepare->fetch();
    }

	public function updateSavingStatut($game)
    {
        $requetePrepare = PdoWerewolf::$myPdo->prepare(
            'UPDATE game '
            . 'SET saving = 1 '
			. 'WHERE id = :game'
        );
		$requetePrepare->bindParam(':game', $game, PDO::PARAM_INT);
        $requetePrepare->execute();
        return $requetePrepare->fetchAll();
    }

	public function updateKillingStatut($game)
    {
        $requetePrepare = PdoWerewolf::$myPdo->prepare(
            'UPDATE game '
            . 'SET killing = 1 '
			. 'WHERE id = :game'
        );
		$requetePrepare->bindParam(':game', $game, PDO::PARAM_INT);
        $requetePrepare->execute();
        return $requetePrepare->fetchAll();
    }

	public function getVoyanteStatut($game)
    {
        $requetePrepare = PdoWerewolf::$myPdo->prepare(
            'SELECT count(role) as nb '
            . 'FROM players '
			. 'WHERE id_game = :game '
			. 'AND role = "Voyante"'
        );
		$requetePrepare->bindParam(':game', $game, PDO::PARAM_INT);
        $requetePrepare->execute();
        return $requetePrepare->fetch();
    }

	public function getSorciereStatut($game)
    {
        $requetePrepare = PdoWerewolf::$myPdo->prepare(
            'SELECT count(role) as nb '
            . 'FROM players '
			. 'WHERE id_game = :game '
			. 'AND role = "Sorcière"'
        );
		$requetePrepare->bindParam(':game', $game, PDO::PARAM_INT);
        $requetePrepare->execute();
        return $requetePrepare->fetch();
    }

	public function getWolfNumber($game)
    {
        $requetePrepare = PdoWerewolf::$myPdo->prepare(
            'SELECT count(role) as nb '
            . 'FROM players '
			. 'WHERE id_game = :game '
			. 'AND role = "Loup-garou"'
        );
		$requetePrepare->bindParam(':game', $game, PDO::PARAM_INT);
        $requetePrepare->execute();
        return $requetePrepare->fetch();
    }

	public function getNotWolfNumber($game)
    {
        $requetePrepare = PdoWerewolf::$myPdo->prepare(
            'SELECT count(role) as nb '
            . 'FROM players '
			. 'WHERE id_game = :game '
			. 'AND role != "Loup-garou"'
        );
		$requetePrepare->bindParam(':game', $game, PDO::PARAM_INT);
        $requetePrepare->execute();
        return $requetePrepare->fetch();
    }
}
?>
