<?php
namespace lilHermit\Model\Behavior;

use Cake\Datasource\EntityInterface;
use Cake\Event\Event;
use Cake\ORM\Behavior;
use Cake\ORM\Entity;
use Cake\Utility\Text;

class SluggableBehavior extends Behavior {

    protected $_defaultConfig = [
        'field' => 'title',
        'slug' => 'slug',
        'replacement' => '-',
        'lowerCase' => false,
        'onCreate' => true,
        'onUpdate' => true
    ];

    public function initialize(array $config) {
        parent::initialize($config);
    }

    public function slug(Entity $entity) {
        $config = $this->config();
        $value = $entity->get($config['field']);

        $slug = Text::slug($value, $config['replacement']);

        if ($config['lowerCase'] === true) {
            $slug = strtolower($slug);
        }

        $entity->set($config['slug'], $slug);
    }

    public function beforeSave(Event $event, EntityInterface $entity) {
        $config = $this->config();
        if (($entity->isNew() && $config['onCreate'] === true) || (!$entity->isNew() && $config['onUpdate'] === true)) {
            $this->slug($entity);
        }
    }
}