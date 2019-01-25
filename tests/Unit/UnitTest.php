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

    public function testFromNodeWithCustomPrMessageInOwner()
    {
        $node = new DummyNode();
        $node->set('nid', 1);
        $node->set('field_user_pr_template', 'eirik test template user');
        $data = ProjectData::fromNode($node);
        $this->assertEquals(1, $data->getNid());
        $this->assertEquals('7.0', $data->getPhpVersion());
        $this->assertEquals('eirik test template user', $data->getCustomPrMessage());
    }

    public function testFromNodeWithOverriddenAndOwner()
    {
        $node = new DummyNode();
        $node->set('nid', 1);
        $node->set('field_pull_request_template', 'eirik test template');
        $node->set('field_user_pr_template', 'eirik test template user');
        $data = ProjectData::fromNode($node);
        $this->assertEquals(1, $data->getNid());
        $this->assertEquals('7.0', $data->getPhpVersion());
        $this->assertEquals('eirik test template', $data->getCustomPrMessage());
    }
}
