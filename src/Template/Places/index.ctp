<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Place'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="places index large-9 medium-8 columns content">
    <div>
        <h3><?= __('Places') ?></h3>
        <span style="float:right;">
            <a href="javascript:toggle('list');">List</a>&nbsp; | &nbsp; <a href="javascript:toggle('map');">Map</a>
        </span>
    </div>
    
    
    <div id="places_map" style="display: none;">
       <style>
        #map-canvas {
        	height: 400px;
        	width:500px;
        }
        #iw_container .iw_title {
        	font-size: 16px;
        	font-weight: bold;
        }
        .iw_content {
        	padding: 15px 15px 15px 0;
        }
            </style>
         <div id="map-canvas"></div>
    </div>
    <div id="places_list" style="display: block;">
        <table cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('title') ?></th>
                    <th><?= $this->Paginator->sort('url') ?></th>
                    <th><?= $this->Paginator->sort('lng') ?></th>
                    <th><?= $this->Paginator->sort('lat') ?></th>
                    <th><?= $this->Paginator->sort('imagesrc') ?></th>
                    <th><?= $this->Paginator->sort('description') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($places as $place): ?>
                <tr>
                    <td><?= $this->Number->format($place->id) ?></td>
                    <td><?= h($place->title) ?></td>
                    <td><?= h($place->url) ?></td>
                    <td><?= $this->Number->format($place->lng) ?></td>
                    <td><?= $this->Number->format($place->lat) ?></td>
                    <td><?= h($place->imagesrc) ?></td>
                    <td><?= h($place->description) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $place->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $place->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $place->id], ['confirm' => __('Are you sure you want to delete # {0}?', $place->id)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="paginator">
            <ul class="pagination">
                <?= $this->Paginator->prev('< ' . __('previous')) ?>
                <?= $this->Paginator->numbers() ?>
                <?= $this->Paginator->next(__('next') . ' >') ?>
            </ul>
            <p><?= $this->Paginator->counter() ?></p>
        </div>
    </div>
</div>
