<?php

namespace App\Controller;
use MongoDB;

       $con = new MongoDB\Client('mongodb://localhost:27017/');
        // $con = new Mongo();
            // Select Database
            $db = $con->articleSite;
            // Select Collection
            $people = $db->User;
            
            
        if(isset($_POST))
        {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $error = array();
            // Email Validation
            if(empty($email) or !filter_var($email,FILTER_SANITIZE_EMAIL))
            {
                $error[] = "Empty or invalid email address";
            }
            if(empty($password)){
                $error[] = "Enter your password";
            }
            if(count($error) == 0){
                
                if($con){

                $qry = array('email' => $email,'password' => $password);
                $result = $people->findOne($qry);
                if($result){
                    return $this->redirectToRoute('articlePage');
                }
            } else {
                die("Mongo DB not installed");
                }
            }
        }


?>