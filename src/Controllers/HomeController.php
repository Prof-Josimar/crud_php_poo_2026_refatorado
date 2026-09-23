<?php

namespace App\Controllers;

use App\Config\Database;
use App\Core\View;

class HomeController
{
    public function index(): void
    {
        // Se a conexão falhar, o index.php mostra a página de erro.
        $horaAtual = Database::connection()
            ->query("SELECT DATE_FORMAT(NOW(), '%d/%m/%Y %H:%i:%s')")
            ->fetchColumn();

        View::render('home', ['horaAtual' => $horaAtual]);
    }
}
