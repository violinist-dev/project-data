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
        return $p;
    }
}
