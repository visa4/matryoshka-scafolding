<?php
namespace Matryoshka\Scafolding\Service\Model\Adapter\Connection;

use Matryoshka\Scafolding\Exception\RuntimeException;
use Matryoshka\Scafolding\Service\ConfigExistingTrait;
use Matryoshka\Scafolding\Service\Model\Adapter\ServiceNameTrait;
use Zend\Code\Generator\FileGenerator;
use Zend\Code\Generator\ValueGenerator;
use Zend\Console\Prompt\Line;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;
use Zend\Stdlib\ArrayUtils;

/**
 * Class MongoConnectionAdapter
 */
class MongoConnectionAdapter implements AdapterConnectionInterface, ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;
    use ServiceNameTrait;
    use ConfigExistingTrait;

    const CONFIG_KEY = 'mongodb';
    const CONFIG_KEY_DATABASE = 'database';
    const CONFIG_KEY_HOSTS = 'hosts';
    const CONFIG_KEY_PASSWORD = 'password';
    const CONFIG_KEY_USERNAME = 'username';

    /**
     * @var string
     */
    protected $database;

    /**
     * @var string
     */
    protected $hosts = '127.0.0.1:27017';

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
    public function getDatabase()
    {
        return $this->database;
    }

    /**
     * @param string $database
     * @return $this
     */
    public function setDatabase($database)
    {
        $this->database = $database;
        return $this;
    }

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
        if ($hosts) {
            $this->hosts = $hosts;
        }
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
        $this->setDatabase($database);

        $hosts= Line::prompt('Enter hosts:', true, 200);
        $this->setHosts($hosts);

        $username = Line::prompt('Enter username:', true, 100);
        $this->setUsername($username);

        $password = Line::prompt('Enter name password:', true, 100);
        $this->setPassword($password);
    }

    /**
     * @param $path
     * @return $this
     */
    public function generate($path)
    {
        if ($this->isConfigExisting()) {
           return $this;
        }

        $config = [self::CONFIG_KEY => [
            $this->getServiceName() => [
                self::CONFIG_KEY_DATABASE => $this->getDatabase()]
            ]
        ];

        if ($this->getHosts()) {
            $config[self::CONFIG_KEY][ $this->getServiceName()][self::CONFIG_KEY_HOSTS] = $this->getHosts();
        }

        if ($this->getPassword()) {
            $config[self::CONFIG_KEY][ $this->getServiceName()][self::CONFIG_KEY_PASSWORD] = $this->getPassword();
        }

        if ($this->getUsername()) {
            $config[self::CONFIG_KEY][ $this->getServiceName()][self::CONFIG_KEY_USERNAME] = $this->getUsername();
        }

        if (!is_file($path)) {
            $globalConfig = $path . "/config/autoload/global.php";

        } else {
            $globalConfig = $path;
        }

        if ($globalConfig) {
            $oldGlobalConfig = include $globalConfig;
            $newGlobalConfig = ArrayUtils::merge($oldGlobalConfig, $config);

            $file = new FileGenerator();
            $file->setFilename("global.php");

            $valueGenerator = new ValueGenerator();
            $valueGenerator->setValue($newGlobalConfig);
            $valueGenerator->setArrayDepth(0);

            $file->setBody("return " . $valueGenerator->generate() . ";");

            return file_put_contents($globalConfig, $file->generate());
        }

        throw new RuntimeException(sprintf('Wrong file config for model connection adapter %s', $globalConfig));
    }
} 