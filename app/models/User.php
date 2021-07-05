<?php
require_once "../app/core/Database.php";
class User
{
    private $db;


    public function __construct()
    {
        $this->db = new Database;
    }
    public function checkEmailExist($email)
    {
        $this->db->query('SELECT * FROM users WHERE email = :email');
        // Bind value
        $this->db->bind(':email', $email);

        $row = $this->db->single();

        // Check row
        if ($this->db->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }
    public function selectUserByEmail($email)
    {
        $this->db->query('SELECT * FROM users WHERE email = :email');
        // Bind value
        $this->db->bind(':email', $email);

        $row = $this->db->single();

        // Check row
        if ($this->db->rowCount() > 0) {
            return $row;
        } else {
            return false;
        }
    }
    public function register($email, $firstname, $lastname, $gendor, $photo, $password)
    {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $this->db->query('INSERT INTO users (email,firstname,lastname,gendor,photo,password)
        VALUES (:email,:firstname,:lastname,:gendor,:photo,:password);');
        // Bind values
        $this->db->bind(':email', $email);
        $this->db->bind(':firstname', $firstname);
        $this->db->bind(':lastname', $lastname);
        $this->db->bind(':gendor', $gendor);
        $this->db->bind(':photo', $photo);
        $this->db->bind(':password', $password);
        // Execute
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
    //login user
    public function login_user($email, $password)
    {
        $this->db->query('SELECT * FROM users WHERE email = :email');
        $this->db->bind(':email', $email);

        $row = $this->db->single();

        $hashed_password = $row->password;
        if (password_verify($password, $hashed_password)) {
            return true;
        } else {
            return false;
        }
    }
}
