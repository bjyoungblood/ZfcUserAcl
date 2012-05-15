<?php

namespace ZfcUserAcl\Model;

use ZfcBase\Mapper\DbMapperAbstract,
    Zend\Db\Sql\Select as Select;

class RoleMapper extends DbMapperAbstract implements RoleMapperInterface
{
    protected $tableName = 'user_role';

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
}
