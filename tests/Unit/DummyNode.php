<?php

namespace Violinist\ProjectData\Tests\Unit;

class DummyNode
{
    private $nid;

    private $field_pull_request_template;

    private $field_user_pr_template;

    private $owner;

    private $roles;

    public function getOwner()
    {
        // Since a user and a node shares alot of getters and so on, we fake an
        // owner on the class itself.
        return $this;
    }

    public function get($field)
    {
        if (!empty($this->{$field})) {
            return $this->{$field};
        }
    }

    public function hasField($field)
    {
        return (bool) $this->get($field);
    }


    public function id()
    {
        return $this->nid;
    }

    public function getRoles()
    {
        return $this->roles;
    }

    public function set($field, $value)
    {
        if ($field === 'nid') {
            $this->nid = $value;
            return;
        }
        if ($field == 'roles') {
            $this->roles = $value;
            return;
        }
        $field_class = new DummyField();
        $field_class->setString($value);
        $this->{$field} = $field_class;
    }
}
