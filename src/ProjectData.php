<?php

namespace Violinist\ProjectData;

class ProjectData
{

    /**
     * The nid.
     *
     * @var int
     */
    protected $nid;

    /**
     * The php version.
     *
     * @var string
     */
    protected $phpVersion;

    /**
     * @var string
     */
    protected $customPrMessage;

    /**
     * Roles for the project, inherited from the user.
     *
     * @var array
     */
    protected $roles;

    /**
     * Should we update all?
     *
     * @var bool
     */
    protected $updateAll;

    /**
     * @return array
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @param array $roles
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;
    }

    /**
     * @return string
     */
    public function getCustomPrMessage()
    {
        return $this->customPrMessage;
    }

    /**
     * @param string $customPrMessage
     */
    public function setCustomPrMessage($customPrMessage)
    {
        $this->customPrMessage = $customPrMessage;
    }

    /**
     * Get the nid.
     *
     * @return int
     *   Nid.
     */
    public function getNid()
    {
        return $this->nid;
    }

    public function shouldUpdateAll()
    {
        return $this->updateAll;
    }

    /**
     * Set the nid.
     *
     * @param int $nid
     *   A nid.
     */
    public function setNid($nid)
    {
        $this->nid = $nid;
    }

    /**
     * Get the php version.
     *
     * @return string
     *   The php version.
     */
    public function getPhpVersion()
    {
        return $this->phpVersion;
    }

    /**
     * Set the php version.
     *
     * @param string $phpVersion
     *   The php version.
     */
    public function setPhpVersion($phpVersion)
    {
        $this->phpVersion = $phpVersion;
    }

    /**
     * Set the update all flag.
     */
    public function setUpdateAll($update)
    {
      $this->updateAll = (bool) $update;
    }

    /**
     * Create an object from a node.
     *
     * @param \Drupal\node\NodeInterface $node
     *   A node.
     *
     * @return \Violinist\ProjectData\ProjectData
     *   A new project.
     */
    public static function fromNode($node)
    {
        $p = new self();
        $p->setNid($node->id());
        $p->setPhpVersion('7.0');
        if ($node->hasField('field_pull_request_template') && !$node->get('field_pull_request_template')->isEmpty()) {
            $p->setCustomPrMessage($node->get('field_pull_request_template')->first()->getString());
        }
        if (!$p->getCustomPrMessage()) {
            // See if we have a default one on the user.
            $owner = $node->getOwner();
            if ($owner->hasField('field_user_pr_template') && !$owner->get('field_user_pr_template')->isEmpty()) {
                $p->setCustomPrMessage($owner->get('field_user_pr_template')->first()->getString());
            }
        }
        if ($node->hasField('field_php_version') && !$node->get('field_php_version')->isEmpty()) {
            $p->setPhpVersion($node->get('field_php_version')->first()->getString());
        }
        $owner = $node->getOwner();
        if ($owner) {
            $p->setRoles($owner->getRoles());
        }
        return $p;
    }
}
