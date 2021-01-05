<?php
/**
 * Created by vendty.
 * User: Rafael Moreno
 * Date: 25/02/2019
 * Time: 3:02 PM
 */

namespace App\Tools;


use App\User;

/**
 * Class Password
 * @package App\Tools
 */
class Password
{
    /**
     * @var string
     */
    protected $hashMethod = 'sha1';

    /**
     * @var bool
     */
    protected $storeSalt = false;

    /**
     * @var int
     */
    protected $saltLength = 10;

    /**
     * @param string $password
     * @param string|null $salt
     * @param bool $useSha1Override
     * @return bool|string
     */
    public function hash(string $password, string $salt = null, $useSha1Override = false)
    {
        if (empty($password)) {
            return false;
        }

        if (!$useSha1Override && $this->hashMethod == 'bcrypt') {
            //
        }

        if ($this->storeSalt && $salt) {
            return sha1($password . $salt);
        } else {
            $salt = $this->salt();
            return  $salt . substr(sha1($salt . $password), 0, -$this->saltLength);
        }
    }

    /**
     * @param User $user
     * @param string $password
     * @param bool $useSha1Override
     * @return bool
     */
    public function validate(User $user, string $password, $useSha1Override = false)
    {
        $dbPassword = null;

        if (is_null($user) || empty($password)) {
            return false;
        }

        if (!$useSha1Override && $this->hashMethod == 'bcrypt') {
            //
        }

        if ($this->storeSalt) {
            $dbPassword = sha1(($password . $user->salt));
        } else {
            $salt = substr($user->password, 0, $this->saltLength);
            $dbPassword =  $salt . substr(sha1($salt . $password), 0, -$this->saltLength);
        }

        if ($dbPassword == $user->password) {
            return true;
        }

        return false;
    }

    /**
     * @return bool|string
     */
    private function salt()
    {
        return substr(md5(uniqid(rand(), true)), 0, $this->saltLength);
    }
}
