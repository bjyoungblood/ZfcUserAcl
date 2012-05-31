<?php

namespace ZfcUserAcl\Model;

use Zend\Acl\Role\RoleInterface as ZfRoleInterface;

interface RoleInterface extends ZfRoleInterface
{
    public function setRoleId($roleId);
 
    public function getDefault();
    public function setDefault($default);
 
    public function getParent();
    public function setParent($parent);
}
