<?php

class KoneksiDatabase
{
    var $namaServer;
    var $namaDB;
    var $namaUser;
    var $passwordInPlaintext;

    function konekKeDatabase()
    {
        return mysqli_connect(
            $this->namaServer,
            $this->namaUser,
            $this->passwordInPlaintext,
            $this->namaDB
        );
    }
}
