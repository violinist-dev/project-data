<?php

namespace violinist\ProjectData;

class ProjectData {

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
   * Get the nid.
   *
   * @return int
   *   Nid.
   */
  public function getNid() {
    return $this->nid;
  }

  /**
   * Set the nid.
   *
   * @param int $nid
   *   A nid.
   */
  public function setNid($nid) {
    $this->nid = $nid;
  }

  /**
   * Get the php version.
   *
   * @return string
   *   The php version.
   */
  public function getPhpVersion() {
    return $this->phpVersion;
  }

  /**
   * Set the php version.
   *
   * @param string $phpVersion
   *   The php version.
   */
  public function setPhpVersion($phpVersion) {
    $this->phpVersion = $phpVersion;
  }

  /**
   * Create an object from a node.
   *
   * @param \Drupal\node\NodeInterface $node
   *   A node.
   *
   * @return \Drupal\cronner\TransferProject
   *   A new project.
   */
  public static function fromNode($node) {
    $p = new self();
    $p->setNid($node->id());
    $p->setPhpVersion('7.0');
    return $p;
  }

}
