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
     * Either a path to a directory (without the last slash) or null (means root).
     *
     * @var string|null
     */
    protected $composerJsonDir;

    /**
     * ENV string.
     *
     * @var string
     */
    protected $envString;

    /**
     * @return string
     */
    public function getEnvString()
    {
        return $this->envString;
    }

    /**
     * @param string $envString
     */
    public function setEnvString($envString)
    {
        $this->envString = $envString;
    }

    /**
     * @return string|null
     */
    public function getComposerJsonDir()
    {
        return $this->composerJsonDir;
    }

    /**
     * @param string|null $composerJsonDir
     */
    public function setComposerJsonDir($composerJsonDir)
    {
        $this->composerJsonDir = $composerJsonDir;
    }

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
        if ($node->hasField('field_composer_json_path') && !$node->get('field_composer_json_path')->isEmpty()) {
            $directory = $node->get('field_composer_json_path')->first()->getString();
            $p->setComposerJsonDir($directory);
        }
        $owner = $node->getOwner();
        if ($owner) {
            $p->setRoles($owner->getRoles());
        }
        $p->setEnvString('');
        if ($node->hasField('field_environment_variables') && !$node->get('field_environment_variables')->isEmpty()) {
            $p->setEnvString($node->get('field_environment_variables')->first()->getString());
        }
        if (!$p->getEnvString()) {
            // Use the user one. If available.
            if ($owner) {
                if ($owner->hasField('field_environment_variables') && !$owner->get('field_environment_variables')->isEmpty()) {
                    $p->setEnvString($owner->get('field_environment_variables')->first()->getString());
                }
            }
        }
        return $p;
    }
}
