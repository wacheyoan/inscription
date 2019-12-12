<?php


class Users
{

    private $db;
    private $insert;
    private $select;
    private $selectById;
    private $update;
    private $delete;

    public function __construct($db)
    {
        $this->db = $db;
        $this->insert = $db->prepare("
            INSERT INTO users(firstName,lastName,birthDate,gender,country,job,email)
            values (:firstName,:lastName,:birthDate,:gender,:country,:job,:email)
        ");
        $this->select = $db->prepare("
            SELECT * FROM users
            ORDER BY country
        ");

        $this->selectById = $db->prepare("
            SELECT * FROM users
            WHERE id = :id
        ");
        $this->update = $db->prepare("
            UPDATE users
            SET firstName=:firstName,lastName=:lastName,birthDate=:birthDate,gender=:gender,country=:country,
                job=:job,email=:email
            WHERE id = :id
        ");

        $this->delete = $db->prepare("
            DELETE 
            FROM users
            Where id = :id
        ");

    }

    public function insert($firstName,$lastName,$birthDate,$gender,$country,$job,$email){
        $r = true;
        $this->insert->execute([
            'firstName' => $firstName,
            'lastName' => $lastName,
            'birthDate' => $birthDate,
            'gender' => $gender,
            'country' => $country,
            'job' => $job,
            'email' => $email
        ]);

        if($this->insert->errorCode()!=0){
            print_r($this->insert->errorInfo());
            $r = false;
        }

        return $r;

    }

    public function select(){

        $liste = $this->select->execute();

        if($this->select->errorCode()!=0){
            print_r($this->select->errorInfo());
        }

        return $this->select->fetchAll();
    }

    public function selectById($id){
        $this->selectById->execute([
            'id' => $id
        ]);
        if($this->selectById->errorCode()!=0){
            print_r($this->selectById->errorInfo());
        }

        return $this->selectById->fetch();

    }

    public function update($firstName,$lastName,$birthDate,$gender,$country,$job,$email,$id){
        $r = true;
        $this->update->execute([
            'firstName' => $firstName,
            'lastName' => $lastName,
            'birthDate' => $birthDate,
            'gender' => $gender,
            'country' => $country,
            'job' => $job,
            'email' => $email,
            'id' => $id
        ]);

        if($this->update->errorCode()!=0){
            print_r($this->update->errorInfo());
            $r = false;
        }

        return $r;

    }

    public function delete($id){
        $r = true;
        $this->delete->execute([
            'id' => $id
        ]);

        if($this->delete->errorCode()!=0){
            print_r($this->delete->errorInfo());
            $r = false;
        }

        return $r;

    }


}