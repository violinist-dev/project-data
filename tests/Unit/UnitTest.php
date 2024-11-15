<?php

namespace Violinist\ProjectData\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Violinist\ProjectData\ProjectData;

class UnitTest extends TestCase
{
    public function testCustomPrMessage()
    {
        $data = new ProjectData();
        $this->assertTrue(!$data->getCustomPrMessage());
        $data->setCustomPrMessage('message');
        $this->assertEquals('message', $data->getCustomPrMessage());
    }

    public function testFromNode()
    {
        $node = new DummyNode();
        $node->set('nid', 1);
        $data = ProjectData::fromNode($node);
        $this->assertEquals(1, $data->getNid());
        $this->assertEquals('7.0', $data->getPhpVersion());
        $this->assertTrue(!$data->getCustomPrMessage());
    }

    public function testFromNodeWithCustomPrMessage()
    {
        $node = new DummyNode();
        $node->set('nid', 1);
        $node->set('field_pull_request_template', 'eirik test template');
        $data = ProjectData::fromNode($node);
        $this->assertEquals(1, $data->getNid());
        $this->assertEquals('7.0', $data->getPhpVersion());
        $this->assertEquals('eirik test template', $data->getCustomPrMessage());
    }

    public function testFromNodeWithCustomPrMessageInTeam()
    {
        $node = new DummyNode();
        $node->set('nid', 1);
        $team_node = new DummyNode();
        $team_node->set('field_pull_request_template', 'eirik test template team');
        $node->set('team', $team_node);
        $data = ProjectData::fromNode($node);
        $this->assertEquals(1, $data->getNid());
        $this->assertEquals('7.0', $data->getPhpVersion());
        $this->assertEquals('eirik test template team', $data->getCustomPrMessage());
    }

    public function testFromNodeWithOverriddenAndTeam()
    {
        $node = new DummyNode();
        $node->set('nid', 1);
        $node->set('field_pull_request_template', 'eirik test template');
        $team_node = new DummyNode();
        $team_node->set('field_pull_request_template', 'eirik test template team');
        $node->set('team', $team_node);
        $data = ProjectData::fromNode($node);
        $this->assertEquals(1, $data->getNid());
        $this->assertEquals('7.0', $data->getPhpVersion());
        $this->assertEquals('eirik test template', $data->getCustomPrMessage());
    }

    public function testFromNodeWithPhpVersion()
    {
        $node = new DummyNode();
        $node->set('nid', 1);
        $node->set('field_php_version', '7.2');
        $data = ProjectData::fromNode($node);
        $this->assertEquals(1, $data->getNid());
        $this->assertEquals('7.2', $data->getPhpVersion());
    }

    public function testFromNodeWithRoles()
    {
        $node = new DummyNode();
        $node->set('nid', 1);
        $node->set('roles', ['role1', 'role2']);
        $data = ProjectData::fromNode($node);
        $this->assertEquals(1, $data->getNid());
        $this->assertEquals(['role1', 'role2'], $data->getRoles());
    }

    public function testFromNodeWithEnv()
    {
        $node = new DummyNode();
        $node->set('field_environment_variables', 'FOO=bar');
        $data = ProjectData::fromNode($node);
        self::assertEquals(['FOO' => 'bar'], $data->getEnvArray());
    }
}
