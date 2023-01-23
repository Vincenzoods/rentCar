<?php
// On déclare le namespace de la classe, qui est "Core\db"
namespace Core\db;
// On utilise l'instruction "use" pour utiliser les classes PDO et PDOException sans avoir à les préfixer avec leur namespace complet
use PDO;
use PDOException;

// On déclare la classe "Database" qui va contenir la logique pour se connecter à la base de données
class Database
{
    // On déclare des attributs privés qui contiendront les informations de connexion à la base de données (host, user, dbname, mdp, char)
    private string $host;
    private string $user;
    private string $dbname;
    private string $mdp;
    private string $char;
    // On déclare un attribut public qui contiendra l'objet PDO qui représente la connexion à la base de données
    public PDO $connection;
    // On déclare un attribut public statique qui contiendra l'instance unique de la classe
    public static $instance;


    // On déclare un constructeur privé pour empêcher l'instanciation en dehors de la classe. Il prend en paramètre les informations de connexion à la base de données.
    private function __construct(string $host, string $dbname, string $user, string $mdp, string $char)
    {
        $this->host = $host;
        $this->dbname = $dbname;
        $this->user = $user;
        $this->mdp = $mdp;
        $this->char = $char;
        // On utilise un bloc try-catch pour essayer de créer une nouvelle connexion à la base de données en utilisant les informations de connexion stockées dans les attributs de la classe.
        //  Si une exception est levée (par exemple, si les informations de connexion sont incorrectes), on affiche un message d'erreur et on arrête l'exécution du script.
        try {
            $this->connection = new PDO("mysql:host={$this->host};dbname={$this->dbname};charset={$this->char}", $this->user, $this->mdp);
        } catch (PDOException $e) {
            echo "[ERREUR] =>{$e->getMessage()}";
            die;
        }
    }

    // On déclare une méthode statique "getInstance" qui permet de créer une nouvelle instance de la classe s'il n'en existe pas déjà, ou de récupérer l'instance existante.
    //  Elle prend en paramètre les informations de connexion à la base de données
    public static function getInstance(string $host, string $dbname, string $user, string $mdp, string $char = 'utf8')
    {
        // On vérifie si l'attribut statique "instance" n'est pas défini ou est vide.
        //  Si c'est le cas, on crée une nouvelle instance de la classe en appelant le constructeur privé avec les informations de connexion.
        if (!isset(self::$instance) or empty(self::$instance)) {
            self::$instance = new Database($host, $dbname, $user, $mdp, $char);
        }
        // On retourne l'instance de la classe. Cette méthode statique "getInstance" est utilisée pour s'assurer qu'il n'y a qu'une seule instance de la classe "Database" à tout moment.
        //  C'est ce qu'on appelle un singleton.
        //  Cela permet de ne pas avoir à recréer une connexion à la base de données à chaque fois qu'on en a besoin, ce qui peut être plus efficace et éviter les problèmes de concurrence
        return self::$instance;
    }
}
