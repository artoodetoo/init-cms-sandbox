<?php
/**
 * This file is part of the init_cms_sandbox package.
 *
 * (c) artoodetoo
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
 

namespace Application\Networking\InitCmsBundle\Entity;

use Networking\InitCmsBundle\Entity\BaseUser;
/**
 * @author artoodetoo
 */
class User extends BaseUser
{
    /**
     * @var string $ref This User's reference code
     */
    protected $ref;
    /**
     * @var string $followRef Who do this user follow?
     */
    protected $followRef;
    /**
     * @var string $vkontakteUid Identity from VK.COM
     */
    protected $vkontakteUid;
    /**
     * @var string $vkontakteName User name from VK.COM
     */
    protected $vkontakteName;
    /**
     * @var string $vkontakteData Extra data from VK.COM
     */
    protected $vkontakteData;

    public function __construct()
    {
        parent::__construct();
        $this->ref = md5(uniqid());
    }

    /**
     * Set ref
     *
     * @param string $ref
     * @return User
     */
    public function setRef($ref)
    {
        $this->ref = $ref;
    
        return $this;
    }

    /**
     * Get ref
     *
     * @return string 
     */
    public function getRef()
    {
        return $this->ref;
    }

    /**
     * Set followRef
     *
     * @param string $followRef
     * @return User
     */
    public function setFollowRef($followRef)
    {
        $this->followRef = $followRef;
    
        return $this;
    }

    /**
     * Get followRef
     *
     * @return string 
     */
    public function getFollowRef()
    {
        return $this->followRef;
    }

    /**
     * Set vkontakteUid
     *
     * @param string $vkontakteUid
     * @return User
     */
    public function setVkontakteUid($vkontakteUid)
    {
        $this->vkontakteUid = $vkontakteUid;
    
        return $this;
    }

    /**
     * Get vkontakteUid
     *
     * @return string 
     */
    public function getVkontakteUid()
    {
        return $this->vkontakteUid;
    }

    /**
     * Set vkontakteName
     *
     * @param string $vkontakteName
     * @return User
     */
    public function setVkontakteName($vkontakteName)
    {
        $this->vkontakteName = $vkontakteName;
    
        return $this;
    }

    /**
     * Get vkontakteName
     *
     * @return string 
     */
    public function getVkontakteName()
    {
        return $this->vkontakteName;
    }

    /**
     * Set vkontakteData
     *
     * @param json $vkontakteData
     * @return User
     */
    public function setVkontakteData($vkontakteData)
    {
        $this->vkontakteData = $vkontakteData;
    
        return $this;
    }

    /**
     * Get vkontakteData
     *
     * @return json 
     */
    public function getVkontakteData()
    {
        return $this->vkontakteData;
    }

}