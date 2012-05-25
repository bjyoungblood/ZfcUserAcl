<?php

namespace ZfcUserAcl\Model;

use ZfcBase\Model\ModelAbstract;

class Role extends ModelAbstract implements RoleInterface
{
    protected $roleId;
    protected $default;
    protected $parent;
    protected $children;
 
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
     * Get parent.
     *
     * @return parent
     */
    public function getParent()
    {
        return $this->parent;
    }
 
    /**
     * Set parent.
     *
     * @param $parent the value to be set
     */
    public function setParent($parent)
    {
        $this->parent = $parent;
        return $this;
    }

    public function getChildren()
    {
        return $this->children;
    }

    public function setChildren(array $children)
    {
        $this->children = $children;
        return $this;
    }

    public function addChild(RoleInterface $child)
    {
        $this->children[] = $child;
        return $this;
    }
}
