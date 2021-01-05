<?php

namespace App\Database;

use App\User;
use Illuminate\Support\Facades\App;

/**
 * Class Connection
 * @package App\Database
 */
class Connection
{
	/**
	 * @var string
	 */
	protected $host;

	/**
	 * @var string
	 */
	protected $database;

	/**
	 * @var string
	 */
	protected $username;

	/**
	 * @var string
	 */
	protected $password;

    /**
     * Connection constructor.
     */
	public function __construct(User $user)
    {
        $this->host = $user->dbConfig->servidor;
        $this->database = $user->dbConfig->base_dato;
        $this->username = $user->dbConfig->usuario;
        $this->password = $user->dbConfig->clave;

        $this->setConfig();
	}

    /**
     * @return mixed
     */
	private function setConfig()
	{
	    App::make('config')->set('database.connections.mysql_shop', [
            'driver' => 'mysql',
            'host' => $this->host,
            'port' => env('DB_PORT', '3306'),
            'database' => $this->database,
            'username' => $this->username,
            'password' => $this->password,
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
	    ]);

	    return App::make('config')->get('database.connections.mysql_shop');
	}
}
