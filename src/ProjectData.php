<?php

namespace Violinist\ProjectData;

use Drupal\violinist_projects\ProjectNode;
use Drupal\violinist_teams\TeamNode;
use Symfony\Component\Dotenv\Dotenv;

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

    public function getEnvArray() : array
    {
        $env = $this->getEnvString();
        $dotenv_data = new Dotenv();
        try {
            return $dotenv_data->parse($env);
        } catch (\Throwable $e) {
            return [];
        }
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
     * @param \Drupal\violinist_projects\ProjectNode $node
     *   A project node.
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
            // See if we have a default one on the team.
            $team = $node->getTeam();
            if ($team && $team->hasField('field_pull_request_template') && !$team->get('field_pull_request_template')->isEmpty()) {
                $p->setCustomPrMessage($team->get('field_pull_request_template')->first()->getString());
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
            // The team one should really take precedence at this point. In fact,
            // we will remove the user one altogether at some point, but double
            // here is not the worst either.
            $team = $node->getTeam();
            if ($team instanceof TeamNode) {
                $new_env_string = '';
                foreach ($team->getEnvironmentVariables() as $key => $value) {
                    $new_env_string .= $key . '=' . $value . "\n";
                }
                if ($new_env_string) {
                    $p->setEnvString($new_env_string);
                }
            }
        }
        return $p;
    }
}
