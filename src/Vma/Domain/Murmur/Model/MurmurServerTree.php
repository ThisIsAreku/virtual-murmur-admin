<?php

namespace Vma\Domain\Murmur\Model;


class MurmurServerTree extends \Murmur_Tree
{

    function __construct(\Murmur_Tree $tree)
    {
        $this->children = [];
        foreach ($tree->children as $treeChild) {
            $this->children[$this->findNextKey($treeChild->c->position)] = new self($treeChild);
        }

        ksort($this->children);

        $this->c     = $tree->c;
        $this->users = $tree->users;
    }

    private function findNextKey($id)
    {
        if (!isset($this->children[$id])) {
            return $id;
        }

        return $this->findNextKey($id + 1);
    }

    public function hasSubContent()
    {
        return !(empty($this->children) && empty($this->users));
    }

    public function getNumUsersInSubtree()
    {
        $current = count($this->users);
        foreach ($this->children as $treeChild) {
            $current += $treeChild->getNumusersInSubtree();
        }

        return $current;
    }

    public function getCollapsed()
    {
        return $this->getNumUsersInSubtree() === 0;
    }
}