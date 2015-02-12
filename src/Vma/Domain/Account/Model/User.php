<?php
/**
 * Created by PhpStorm.
 * User: alexandre
 * Date: 27/01/15
 * Time: 17:09
 */

namespace Vma\Domain\Account\Model;


class User
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var string
     */
    protected $username;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set username
     *
     * @param string $username
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }
}