<?php

namespace ZfcUserAcl\Model;

use Zend\Acl\Role\RoleInterface as ZfRoleInterface;

interface RoleInterface extends ZfRoleInterface
{
    public function getRoleId();
    public function setRoleId($roleId);
 
    public function getDefault();
    public function setDefault($default);
 
    public function getWeight();
    public function setWeight($weight);
}
