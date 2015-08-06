<?php

/**
 * Datab.php
 * All things MySQL
 */

class Datab {
    private $db;

    public function __construct() {
        $this->db = new PDO('mysql:host=localhost;dbname=osuladders', 'root', '', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"));
    }

    /*
     * userExists(username)
     * Checks if the user is already in the database
     * ???
     */
    public function userExists($username) {
        $do = $this->db->prepare("SELECT username FROM users WHERE username = :username");
        $do->bindParam(':username', $username);
        $do->execute();
        $result = $do->fetch();
        if (strtolower($result['username']) == strtolower($username)) {
            return true;
        } else {
            return false;
        }
    }

    /*
     * ladderCheck(username)
     * Checks the status of the ladder
     * ???
     */
    public function ladderCheck($ladderkey)
    {
        $do = $this->db->prepare("SELECT ladderkey, usable FROM ladders WHERE ladderkey = :ladderkey");
        $do->bindParam(':ladderkey', $ladderkey);
        $do->execute();
        $result = $do->fetch(PDO::FETCH_ASSOC);
        if (isset($result['ladderkey']) && $result['usable'] == 0)
        {
            /*
             * ladder exists, but not defined, proceed to asign users
             */
            return 'ladder-create';

        } elseif (isset($result['ladderkey']) && $result['usable'] == 1) 
        {
            /*
             * ladder exists
             */
            return 'ladder-exists';

        } elseif (!isset($result['ladderkey'])) 
        {
            /*
             * invalid key
             */
            return 'ladder-invalid';
        }

    }

    /*
     * createKey(ladderkey)
     * Creates a ladder key
     */
    public function createKey($ladderkey)
    {
        $do = $this->db->prepare("INSERT INTO ladders (ladderkey, usable) VALUES (:ladderkey, 0)");
        $do->bindParam(':ladderkey', $ladderkey);
        $do->execute();
    }

    /*
     * useKey(ladderkey)
     * Changes key usable status from 0 to 1, meaning the ladder has been created
     */
    public function useKey($ladderkey) 
    {
        $do = $this->db->prepare("UPDATE ladders SET usable='1' WHERE ladderkey = :ladderkey");
        $do->bindParam(':ladderkey', $ladderkey);
        $do->execute();
    }

    /*
     * createKey(ladderkey)
     * Returns an array with all the users from the ladder
     */
    public function getUsersFromKey($ladderkey) 
    {
        $do = $this->db->prepare("SELECT username FROM users WHERE fromladder = :ladderkey");
        $do->bindParam(':ladderkey', $ladderkey);
        $do->execute();
        $result = $do->fetchAll(PDO::FETCH_ASSOC);
        $usernames = array();
        foreach ($result as $key) 
        {
            array_push($usernames, $key['username']);
        }
        $usernames['mode'] = '0';
        return $usernames;
    }

    public function putStats($data, $mode, $ladderkey, $master) {
        // computer_science_degree.png
        $do = $this->db->prepare("INSERT INTO users (user_id, fromladder, laddermaster, mode, username, pp_rank, pp_raw,
                    accuracy, playcount, ranked_score, 
                    total_score, level, count_rank_ss, count_rank_s, 
                    count_rank_a, country) VALUES 
                    (:userid, :fromladder, :laddermaster, :mode, :username, :rank, :pp,
                    :accuracy, :playcount, :rankedscore,
                    :totalscore, :lvl, :ssranks, :sranks,
                    :aranks, :country)");
        $do->bindParam(':userid', $data[0]['user_id']);
        $do->bindParam(':fromladder', $ladderkey);
        $do->bindParam(':laddermaster', $master);
        $do->bindParam(':mode', $mode);
        $do->bindParam(':username', $data[0]['username']);
        $do->bindParam(':rank', $data[0]['pp_rank']);
        $do->bindParam(':pp', $data[0]['pp_raw']);
        $do->bindParam(':accuracy', $data[0]['accuracy']);
        $do->bindParam(':playcount', $data[0]['playcount']);
        $do->bindParam(':rankedscore', $data[0]['ranked_score']);
        $do->bindParam(':totalscore', $data[0]['total_score']);
        $do->bindParam(':lvl', $data[0]['level']);
        $do->bindParam(':ssranks', $data[0]['count_rank_ss']);
        $do->bindParam(':sranks', $data[0]['count_rank_s']);
        $do->bindParam(':aranks', $data[0]['count_rank_a']);
        $do->bindParam(':country', $data[0]['country']);
        $do->execute();
    }

    public function getStats($ladderkey) {
        $do = $this->db->prepare("SELECT * FROM users, ladders
                    WHERE users.fromladder = :key AND ladders.ladderkey = :key
                    ORDER BY pp_rank ASC;");
        $do->bindParam(':key', $ladderkey);
        $do->execute();
        $data = $do->fetchAll(PDO::FETCH_ASSOC);

        /* foreach ($usernames as $key => $value) 
        {
            $do = $this->db->prepare("SELECT * FROM USERS WHERE username = :user");
            $do->bindParam(':user', $value);
            $do->execute();
            $result = $do->fetch();
            if (!empty($result)) {
                $do = $this->db->prepare("SET SQL_SAFE_UPDATEs=0; DELETE FROM users WHERE username = :user; SET SQL_SAFE_UPDATEs=1");
                $do->bindParam(':user', $value);
                $do->execute();
            }
        } */
        return $data;
    }

    public function clearLadder($ladderkey) 
    {
        $do = $this->db->prepare("SET SQL_SAFE_UPDATEs=0 ; DELETE FROM users WHERE fromladder = :ladderkey ; SET SQL_SAFE_UPDATEs=1;");
        $do->bindParam(':ladderkey', $ladderkey);
        $do->execute();
    }
}