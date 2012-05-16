<?php

namespace ZfcUserAcl\Model;

use ZfcBase\Model\ModelAbstract;

class Role extends ModelAbstract implements RoleInterface
{
    protected $roleId;
    protected $default;
    protected $weight;
 
    public function __construct($roleId = null)
    {
        $this->roleId = $roleId;
    }

    /**
     * Get roleId.
     *
     * @return roleId
     */
    public function getRoleId()
    {
        return $this->roleId;
    }
 
    /**
     * Set roleId.
     *
     * @param $roleId the value to be set
     */
    public function setRoleId($roleId)
    {
        $this->roleId = $roleId;
        return $this;
    }
 
    /**
     * Get default.
     *
     * @return default
     */
    public function getDefault()
    {
        return $this->default;
    }
 
    /**
     * Set default.
     *
     * @param $default the value to be set
     */
    public function setDefault($default)
    {
        $this->default = $default;
        return $this;
    }
 
    /**
     * Get weight.
     *
     * @return weight
     */
    public function getWeight()
    {
        return $this->weight;
    }
 
    /**
     * Set weight.
     *
     * @param $weight the value to be set
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;
        return $this;
    }
}
