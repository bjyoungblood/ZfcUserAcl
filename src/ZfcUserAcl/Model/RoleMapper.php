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

    /**
     * @TODO caching
     */
    public function getAllStaticRoles($parentId = null)
    {
        $sql = new Select;
        $sql->from($this->tableName);

        if (is_null($parentId)) {
            $where = new Where;
            $where->isNull('parent')->OR->equalTo('parent', '');

            $sql->where($where);

            $rowset = $this->getTableGateway()->selectWith($sql);
            if (count($rowset) < 1) {
                throw new \Exception('No top-level ACL roles defined.');
            }

            $roles = Role::fromArraySet((array) $rowset->toArray());

            foreach ($roles as $r) {
                $children = $this->getAllStaticRoles($r->getRoleId());
                $r->setChildren($children);
            }

            return $roles;
        } else {
            $where = new Where;
            $where->equalTo('parent', $parentId);

            $rowset = $this->getTableGateway()->selectWith($sql->where($where));
            if (count($rowset) > 0) {
                $roles = Role::fromArraySet((array) $rowset->toArray());

                foreach ($roles as $r) {
                    $children = $this->getAllStaticRoles($r->getRoleId());
                    $r->setChildren($children);
                }

                return $roles;
            } else {
                return array();
            }
        }
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

    public function getUserRoles($userId)
    {
        $where = new Where();
        $where->equalTo('user_role_linker.user_id', $userId); 

        $sql = new Select;
        $sql->from('user_role')
            ->join('user_role_linker', 'user_role.role_id = user_role_linker.role_id', array());

        $sql->where($where);
        $rowset = $this->getTableGateway()->selectWith($sql);

        if (count($rowset) < 1) {
            return $this->getDefaultRole();
        }

        return Role::fromArraySet((array) $rowset->toArray());
    }
}
