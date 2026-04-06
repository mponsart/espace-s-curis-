<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\App;
use PDO;

abstract class BaseModel
{
    protected PDO $db;

    public function __construct()
    {
        $this->db = App::instance()->db();
    }
}