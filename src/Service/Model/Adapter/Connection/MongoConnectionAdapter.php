<?php
namespace Matryoshka\Scafolding\Service\Model\Adapter\Connection;

use Matryoshka\Scafolding\Oop\GeneratorInterface;
use Matryoshka\Scafolding\Service\Model\Adapter\ServiceNameTrait;
use Zend\Console\Prompt\Line;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

/**
 * Class MongoConnectionAdapter
 */
class MongoConnectionAdapter implements AdapterConnectionInterface, ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;
    use ServiceNameTrait;
    /**
     * @var string
     */
    protected $database;

    /**
     * @var string
     */
    protected $hosts;

    /**
     * @var string
     */
    protected $username;

    /**
     * @var string
     */
    protected $password;

    /**
     * @return string
     */
    public function getHosts()
    {
        return $this->hosts;
    }

    /**
     * @param string $hosts
     * @return $this
     */
    public function setHosts($hosts)
    {
        $this->hosts = $hosts;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return $this
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     * @return $this
     */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return $this
     */
    public function settingFromPrompt()
    {
        $serviceName = Line::prompt('Enter name service:', false, 100);
        $this->setServiceName($serviceName);

        $database = Line::prompt('Enter name database:', false, 100);
        $this->setPassword($database);

        $hosts= Line::prompt('Enter hosts:', true, 200);
        $this->setHosts($hosts);

        $username = Line::prompt('Enter username:', true, 100);
        $this->setUsername($username);

        $password = Line::prompt('Enter name database:', true, 100);
        $this->setPassword($password);
    }

    /**
     * @param $path
     * @return $this
     */
    public function generate($path)
    {
        // TODO: Implement generate() method.
    }
} 