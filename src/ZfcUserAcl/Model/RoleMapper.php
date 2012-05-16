<?php

namespace ZfcUserAcl\Model;

use ZfcBase\Mapper\DbMapperAbstract,
    Zend\Db\Sql\Select,
    Zend\Db\Sql\Where;

class RoleMapper extends DbMapperAbstract implements RoleMapperInterface
{
    protected $tableName = 'user_role';
    
    public function getRoleById($roleId)
    {
        $where = new Where;
        $where->equalTo('role_id', $roleId);

        $sql = new Select;
        $sql->from($this->tableName)
            ->where($where);

        $row = $this->getTableGateway()->selectWith($sql)->current();

        return Role::fromArray((array) $row);
    }

    public function getDefaultRole()
    {
        $platform = $this->getTableGateway()->getAdapter()->getPlatform();
        $identifier = $platform->quoteIdentifier('default');

        $sql = new Select;
        $sql->from($this->tableName)
            ->where("$identifier = 1");

        $row = $this->getTableGateway()->selectWith($sql)->current();

        return Role::fromArray((array) $row);
    }

    public function getUserRole($userId)
    {
        $where = new Where();
        $where->equalTo('user_role_linker.user_id', $userId); 

        $sql = new Select;
        $sql->from('user_role')
            ->join('user_role_linker', 'user_role.role_id = user_role_linker.role_id', array())
            ->order('weight DESC');

        $sql->where($where);
        $rowset = $this->getTableGateway()->selectWith($sql);
        $row = $rowset->current();

        return Role::fromArray((array) $row);
    }
}
