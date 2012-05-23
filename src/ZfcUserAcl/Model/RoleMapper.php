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

        $rowset = $this->getTableGateway()->selectWith($sql);
        $row = $row->current()->toArray();

        return Role::fromArray((array) $row);
    }

    public function getAllStaticRoles()
    {
        $sql = new Select;
        $sql->from($this->tableName);

        $rowset = $this->getTableGateway()->selectWith($sql);
        if (count($rowset) < 1) {
            throw new \Exception('No ACL roles defined.');
        }

        return Role::fromArraySet((array) $rowset->toArray());
    }

    public function getDefaultRole()
    {
        $platform = $this->getTableGateway()->getAdapter()->getPlatform();
        $identifier = $platform->quoteIdentifier('default');

        $sql = new Select;
        $sql->from($this->tableName)
            ->where("$identifier = 1");

        $rowset = $this->getTableGateway()->selectWith($sql);

        if (count($rowset) < 1) {
            throw new \Exception('Please define a default role.');
        } else if (count($rowset) > 1) {
            throw new \Exception('Please define only one default role.');
        }

        $row = $rowset->current();

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

        if (count($rowset) < 1) {
            return $this->getDefaultRole();
        }

        $row = $rowset->current();

        return Role::fromArray((array) $row);
    }
}
