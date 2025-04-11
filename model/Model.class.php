<?php

/**
 * Classe  Model.
 * Super Classe pour tous les models.
 * Utilise PDO comme PHP Data Object
 *
 * @version 1.0
 * @author zcorp & edotensei
 */

 class Model
 {

 	/* 
     *@var array()
     * le tableau dans lequel vont se greffer les données de config de la base de données
     */
    public static $data = array(

            'DB_HOST'=> 'localhost',
            'DB_NAME'=> 'nob',
            'DB_USER'=> 'jean',
            'DB_PASSWORD'=>'',
            'DB_PORT'=>'',
            'DB_PREFIX'=>'',
            'DB_DSN'=> 'mysql:host=localhost;dbname=altitude'
            );

    public static $pdo;

 	/* 
     * @return PDO object 
     */
    public static function getPDO()
    {
        /* 
         * Verification si l'objet PDO est pas encore appelé 
         */
        if (self::$pdo === null)
        {
            $con = new PDO(
                self::$data['DB_DSN'],
                self::$data['DB_USER'],
                self::$data['DB_PASSWORD'],
                array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
            );

            self::$pdo = $con;

        }

        return self::$pdo;

    }       

 }